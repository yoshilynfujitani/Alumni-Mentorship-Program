<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\MentorRequest;
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
      $user = Auth::user();

        $queryPerPage = 10;
        if($user->role === 3){
            $query = DB::connection('admin')->table('users')
            ->orderBy('created_at')
            ->join('userstatus', 'users.verified', '=', 'userstatus.statusId')
            ->join('fields', 'users.field', '=', 'fields.id')
            ->select('users.*', 'userstatus.statusName', 'fields.fieldName')
            ->where('users.role', 2);
        }
        else{
             $query = DB::connection('admin')->table('users')
            ->where('course', $user->course)
            ->orderBy('created_at')
            ->join('userstatus', 'users.verified', '=', 'userstatus.statusId')
            ->join('fields', 'users.field', '=', 'fields.id')
            ->select('users.*', 'userstatus.statusName', 'fields.fieldName')
            ->where('users.role', 2);
        }
       
    
            // dd($request->searchBy);
        if ($request->searchBy == 0 || $request->searchBy == null) {
            return $query->where('users.verified', 1)->paginate($queryPerPage);
        }
    
    
        if ($request->searchBy == 2) {
            return $query->paginate($queryPerPage);
        }
    }

    public function getRequestToBeMentor(Request $request){
        $user = User::where("email", $request->email)->first();
        $request = new MentorRequest();

        $request->userId = $user->id;
        $request->email = $user->email;

        $request->save();

        return;
    }

    public function checkExisitingMentorRequest(Request $request){
        $existing = MentorRequest::where("email", $request->email)->where('verified',0)->first();

        if($existing){
            return $existing->existingApplication = true;
        }   
        return;
    }

   public function getMentorApplications() {
    $authUser = Auth::user();
    $applications = null;

    if ($authUser->role === 3) {
        // For admins, get all mentor requests with user details
        $applications = MentorRequest::join('users', 'users.id', '=', 'mentorrequest.userId')
            ->select('mentorrequest.*', 'users.name', 'users.course')
            ->orderBy('mentorrequest.created_at', 'DESC')
            ->paginate(10);
    } else {
        // For other users, get mentor requests filtered by their course with user details
        $applications = MentorRequest::join('users', 'users.id', '=', 'mentorrequest.userId')
            ->where('users.course', $authUser->course)
            ->select('mentorrequest.*', 'users.name', 'users.course')
            ->orderBy('mentorrequest.created_at', 'DESC')
            ->paginate(10);
    }

    return $applications;
}

    

    public function searchRequest(Request $request){
        return MentorRequest::join('users', 'users.id', '=', 'mentorrequest.userId')
        ->select('users.name', 'users.course')
        ->where('name', 'LIKE', "%{$request->ticketQuery}%")
        ->orderBy('mentorrequest.created_at', 'DESC')
        ->paginate(10);
    }
    

    public function searchMentor(Request $request){
    $mentors = User::where('name','LIKE',"%{$request->mentorQuery}%")
                    ->where('role', 2);

                        
    //null is default search
    if($request->searchBy === null && $request->selectedCourseId === null){
        $mentors = $mentors->paginate(12);
    }
    //1 is when student is allowed to make appointments
    else if($request->selectedCourseId && $request->fieldToTake === null){
         $mentors = $mentors->whereRaw('FIND_IN_SET(?, users.field)', [$request->selectedCourseId])->paginate(12);
      
    }
    else{
      
        $mentors = $mentors->whereRaw('FIND_IN_SET(?, users.field)', [$request->fieldToTake])->paginate(12);

        foreach ($mentors as $mentor) {
            $appointment = MentorAppointment::where('studentId', auth()->id())
                                            ->where('status', 0)
                                            ->where('mentorId', $mentor->id)
                                            ->exists();
    
            $mentor->hasAppointment = $appointment;
    
            $feedbacks = Feedback::where('userToRateId', $mentor->id)->get();
            $mentor->feedBackCount = $feedbacks->count();
        }
    }

    return $mentors;
}

    

public function getMentorsStudent(Request $request) {
    $query = DB::connection('admin')->table('users')
        ->join('fields', 'fields.id', '=', 'users.field')
        ->where('users.role', 2)
        ->select('users.name', 'users.email', 'users.course', 'fields.fieldName', 'users.id', 'users.rating');

    // Apply mentor name search if provided
    if ($request->mentorQuery && $request->selectedCourseId === null) {
        $query->where('userfields.fieldName', 'LIKE', "%{$request->mentorQuery}%");
    }
     else if ($request->mentorQuery === null &&  $request->selectedCourseId  ) {
        $query->whereRaw('FIND_IN_SET(?, users.field)', [$request->selectedCourseId]);
       
    }

    else if($request->mentorQuery  &&  $request->selectedCourseId ){
            $query->where('name','LIKE',"%{$request->mentorQuery}%");
            $query = $query->whereRaw('FIND_IN_SET(?, users.field)', [$request->selectedCourseId]);
                
    }


    // Null is the default search
    // if ($request->searchBy === null) {
    //     if ($request->allowToAppoint == 1 && $request->fieldToTake) {
    //         $query->whereRaw('FIND_IN_SET(?, users.field)', [$request->fieldToTake]);
    //     }
    // } 
    else if ($request->allowToAppoint == 1 && $request->fieldToTake) {
        $query->whereRaw('FIND_IN_SET(?, users.field)', [$request->fieldToTake]);}
    

    $mentors = $query->paginate(12);

    foreach ($mentors as $mentor) {
        $appointment = MentorAppointment::where('studentId', auth()->id())
            ->where('status', 0)
            ->where('mentorId', $mentor->id)
            ->exists();

        $mentor->hasAppointment = $appointment;

        $feedbacks = Feedback::where('userToRateId', $mentor->id)->get();
        $mentor->feedBackCount = $feedbacks->count();
    }

    return $mentors;
}


    
    public function getMentorAppointment(){
        return mentorAppointment::where('appointmentdetails.mentorId', Auth::id())
        ->join('appointmentstatus', 'appointmentstatus.statusId', '=', 'appointmentdetails.status')
        ->join(DB::raw('adminportal.users AS users'), 'users.id', '=', 'appointmentdetails.studentId')
        ->join(DB::raw('adminportal.colleges AS college'), 'college.id', '=', 'users.course')
        ->join(DB::raw('mentorportal.requestordetails AS reqby'), 'appointmentdetails.requestedBy','=','reqby.id')
        ->select('appointmentdetails.*', 'appointmentstatus.*', 'users.name', 'college.CollegeName', 'reqby.requestor')
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
