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
    public function getMentors(Request $request)
    {
        $user = Auth::user();
        $queryPerPage = 10;

        
        $query = DB::connection('admin')->table('users')
            ->leftJoin('userstatus', 'users.verified', '=', 'userstatus.statusId')
            ->leftJoin('fields', 'users.field', '=', 'fields.id')
            ->join('colleges', 'users.course', '=','colleges.id')
            ->select('users.name','users.id','users.created_at', 'userstatus.statusName', 'fields.fieldName', 'colleges.CollegeName')
            ->where('users.role', 2)
            ->where('verified', 1)
            ->orderBy('created_at');

    
        if ($user->role !== 3) {
            $query->where('course', $user->course);
        }

       
        if ($request->searchBy === 0 || $request->searchBy === null) {
            $query->where('users.verified', 1);
        }

      
        return $query->paginate($queryPerPage);
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
            ->join('colleges', 'colleges.id', '=', 'users.course')
            ->select('mentorrequest.*', 'users.name', 'colleges.CollegeName')
            ->orderBy('mentorrequest.created_at', 'DESC')
            ->paginate(10);
    } else {
        // For other users, get mentor requests filtered by their course with user details
        $applications = MentorRequest::join('users', 'users.id', '=', 'mentorrequest.userId')
            ->join('colleges', 'colleges.id', '=', 'users.course')
            ->where('users.course', $authUser->course)
            ->select('mentorrequest.*', 'users.name', 'colleges.CollegeName')
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
    $user = Auth::user();

    if($user->role === 4){
        $mentors = User::where('name','LIKE',"%{$request->mentorQuery}%")
                    ->where('role', 2)
                    ->where('verified', 1)
                    ->where('course', $user->course);
                    
    }
    else{
        $mentors = User::where('name','LIKE',"%{$request->mentorQuery}%")
                    ->where('verified', 1)
                    ->where('role', 2);
    }
    

                        
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
        ->leftJoin('fields', 'users.field', '=', 'fields.id')
        ->where('users.role', 2)
        ->select('users.name', 'users.email', 'users.course', 'fields.fieldName', 'users.id', 'users.rating');

    // Apply mentor name search if provided
    if ($request->mentorQuery && !$request->selectedCourseId) {
        $query->where('users.name', 'LIKE', "%{$request->mentorQuery}%");
    } elseif (!$request->mentorQuery && $request->selectedCourseId) {
        $query->whereRaw('FIND_IN_SET(?, users.field)', [$request->selectedCourseId]);
    } elseif ($request->mentorQuery && $request->selectedCourseId) {
        $query->where('users.name', 'LIKE', "%{$request->mentorQuery}%")
              ->whereRaw('FIND_IN_SET(?, users.field)', [$request->selectedCourseId]);
    }

    if ($request->allowToAppoint == 1 && $request->fieldToTake) {
        $query->whereRaw('FIND_IN_SET(?, users.field)', [$request->fieldToTake]);
    }

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
        ->orderBy('appointmentdetails.updated_at', 'desc')
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
