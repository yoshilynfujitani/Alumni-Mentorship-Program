<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Feedback;
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
    

    public function getMentorsStudent(Request $request) {
        $desiredFieldValue = $request->selectedCourseId;
        $query = DB::connection('admin')->table('users')
            ->join('userfields', 'userfields.fieldId', '=', 'users.field')
            ->where('users.role', 2)
            ->select('users.name', 'users.email', 'users.course', 'userfields.fieldName', 'users.id', 'users.rating');
    
        if ($request->allowToAppoint == null && $request->selectedCourseId == null) {
            $mentors = $query->paginate(12);
            foreach ($mentors as $mentor) {
                $feedbacks = Feedback::where('userToRateId', $mentor->id);
                $mentor->feedBackCount = $feedbacks->count();
            }
            return $mentors;
        }
    
        if ($request->allowToAppoint == 0 || $request->allowToAppoint == 1 || $request->allowToAppoint == 2) {
            if (!empty($desiredFieldValue)) {
                $mentors = $query->whereRaw('FIND_IN_SET(?, users.field)', [$desiredFieldValue])->paginate(12);
            } else {
                // Handle the case when $desiredFieldValue is empty or null
                // For example, skip the FIND_IN_SET condition
                $mentors = $query->paginate(12);
            }
    
            foreach ($mentors as $mentor) {
                $appointment = MentorAppointment::where('studentId', auth()->id())
                    ->where('status', 0)
                    ->where('mentorId', $mentor->id)
                    ->exists();
    
                $mentor->hasAppointment = $appointment;
    
                $feedbacks = Feedback::where('userToRateId', $mentor->id);
                $mentor->feedBackCount = $feedbacks->count();
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

            $otherappointment = mentorAppointment::
            where('field', $appointment->field)
            ->where('appointmentId', $request->appointmentId)
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

    public function updateField(Request $request){
        $user = User::where('id', Auth::id())->first();

        $user->field = strVal($request->FieldId);
        $user->save();
        return ;
    }

    public function getField(){
        $user = User::where('id', Auth::id())->first();

        return $user->field;
    }
  
}
