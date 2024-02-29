<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use App\Models\mentorAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    //
    public function signUp(Request $request){
   
        if(User::where('email', $request->email)->exists()){
            return;
        }
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->field = $request->field;
        $user->role = 2;
        $user->password = Hash::make($request->password);
    
        $res = $user->save();

        return $res;
    }

    public function getMentorDetail(Request $request){
        $mentor = User::where('id', $request->mentorId);

        return $mentor;
    }
    public function getMentors(Request $request ){
      
        $queryPerPage = 10;
        $query = DB::connection('admin')->table('users')
            ->orderBy('created_at')
            ->join('userstatus', 'users.verified', '=', 'userstatus.statusId')
            ->join('userfields', 'users.field', '=', 'userfields.fieldId')
            ->select('users.*', 'userstatus.statusName', 'userfields.fieldName')
            ->where('users.role', 2);
    
            // dd($request->searchBy);
        if ($request->searchBy == 0 || $request->searchBy == null) {
            return $query->where('users.verified', 1)->paginate($queryPerPage);
        }
    
        if ($request->searchBy == 1) {
            return $query->where('users.verified', 0)->paginate($queryPerPage);
        }
    
        if ($request->searchBy == 2) {
            return $query->paginate($queryPerPage);
        }
    }
    

    public function getMentorsStudent(Request $request){
        $query = DB::connection('admin')->table('users')
        ->join('userfields', 'userfields.fieldId', '=', 'users.field')
        ->where('users.role', 2)
        ->select('users.name', 'users.email', 'users.course', 'userfields.fieldName', 'users.id', 'users.rating' );

        if($request->allowToAppoint == null && $request->selectedCourseId == null){
            return $query->paginate(12);
        }

        if($request->allowToAppoint == 0){
            return $query->where("users.field",$request->selectedCourseId)->paginate(12);
        }

        if ($request->allowToAppoint == 1 || $request->allowToAppoint == 2) {
            $mentors = $query->where('users.field', $request->fieldToTake)->paginate(12);
    
            foreach ($mentors as $mentor) {
                $appointment = MentorAppointment::where('studentId', auth()->id())
                    ->where('status', 0)
                    ->where('mentorId', $mentor->id)
                    ->exists();
    
                if ($appointment) {
                    
                    $mentor->hasAppointment = true;
        
                } else {
                    $mentor->hasAppointment = false;
                
                }
            }
    
            return $mentors;
        }

     
    
       
    }

    public function getMentorAppointment(){
        return mentorAppointment::where('appointmentdetails.mentorId', Auth::id())
        ->join('appointmentstatus', 'appointmentstatus.statusId', '=', 'appointmentdetails.status')
        ->join(DB::raw('adminportal.users AS users'), 'users.id', '=', 'appointmentdetails.studentId')
        ->join(DB::raw('mentorportal.requestordetails AS reqby'), 'appointmentdetails.requestedBy','=','reqby.id')
        ->select('appointmentdetails.*', 'appointmentstatus.*', 'users.name', 'users.course', 'reqby.requestor')
        ->paginate(10);
    }

    public function verifyRequest(Request $request){
        
        $appointment = mentorAppointment::find($request->appointmentId);
        $user = User::find($request->studentId);

        if($request->requestStatus == 1){

            $otherappointment = mentorAppointment::where('studentId', $request->studentId)
            ->where('field', $appointment->field)
            ->where('appointmentId', '<>', $request->appointmentId)
            ->where('Status', 0)
            ->update(['Status' => 4]);

            $appointment->Status = 1;
            $user->allowToAppoint = 0;
            $user->fieldToTake = null;
            $user->ticketStatus = null;
            $user->save();
            $appointment->save();

        }

        if($request->requestStatus == 2){
            $appointment->Status = 2;
            $user->allowToAppoint = 1;
            $appointment->remarks = $request->remarks;
            $appointment->save();
            $user->save();
        }

        if($request->requestStatus == 3){
            $appointment->Status = 3;
            $appointment->save();
        }

        return;

    }
  
}
