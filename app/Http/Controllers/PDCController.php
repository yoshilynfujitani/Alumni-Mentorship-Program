<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use App\Models\User;
use App\Models\Convo;
use Illuminate\Http\Request;
use App\Models\MentorRequest;
use App\Models\mentorAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PDCController extends Controller
{

    public function createPDCAccount(Request $request){
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->course = $request->course;
         $user->password = Hash::make($request->password);
        $user->role = 4;
        $user->verified = 1;

        return $user->save();
    }

    public function getColleges(){
        $data = DB::connection("admin")->table('colleges')
        ->select("id","CollegeName")
        ->get();
 

        return $data;
    }



public function getPDCAccounts(Request $request){
    try {
        // Get filter and sort parameters from the request
        $sortField = $request->input('sort_field', 'name'); // Default sort field
        $sortOrder = $request->input('sort_order', 'asc');  // Default sort order
        $search = $request->input('search', '');            // Search keyword

        $query = User::where('role', 4)
            ->join('colleges', 'users.course', '=', 'colleges.id')
            ->select('users.name', 'users.email', 'colleges.CollegeName', 'users.last_active_at', 'users.id', 'users.code');

        // Apply search filter if provided
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'LIKE', '%' . $search . '%')
                  ->orWhere('users.email', 'LIKE', '%' . $search . '%')
                  ->orWhere('colleges.collegeName', 'LIKE', '%' . $search . '%');
            });
        }

        // Apply sorting
        $query->orderBy($sortField, $sortOrder);

        // Paginate the results
        $data = $query->paginate(10);

        // Transform the data to include the isOnline status
        $data->getCollection()->transform(function($user) {
            $user->isOnline = $user->last_active_at && Carbon::now()->diffInMinutes($user->last_active_at) <= 5;
            return $user;
        });

        return response()->json($data, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred while fetching data'], 500);
    }
}





    public function updateMentorStatus(Request $request){
        $userRecord = User::find($request->mentorId);
        $application = MentorRequest::find($request->mentorId);

        $application->verified = $request->statusId;
        $userRecord->verified = $request->statusId;

        $application->save();
        $userRecord->save();
        return $userRecord;
    }

    public function assignStudentToMentor(Request $request){
        $newAppointment = new mentorAppointment();

        $newAppointment->studentId = $request->studentId;
        $newAppointment->mentorId = $request->mentorId;
        $newAppointment->title = $request->title;
        $newAppointment->field = $request->field;
        $newAppointment->startSchedule = Carbon::parse($request->date);
        $newAppointment->requestedBy = 2;


    
        $res = $newAppointment->save();


    }

    public function searchUser(Request $request){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
         
        $users = User::where('name','LIKE',"%{$request->searchQuery}%")
        ->where('role', 1)
        ->get();

        return $users;
    }

    public function resetPDCPassword(Request $request){
        $user = User::find($request->id);
     
        $code = mt_rand(10000000,99999999);

        $user->code = $code;
        $user->password = Hash::make($code);
        $user->first_login = 1;

        return $user->save();
    }

    public function resetPassword(Request $request){
        $user = User::where("email", $request->email)->first();
       

        $user->first_login = 0;
        $user->code = null;
        $user->password = Hash::make($request->password);

        return $user->save();
    }
}
