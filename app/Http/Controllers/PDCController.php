<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\mentorAppointment;

class PDCController extends Controller
{
    //
    public function updateMentorStatus(Request $request){
        $userRecord = User::find($request->mentorId);

        $userRecord->verified = $request->statusId;

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


    
        $res = $newAppointment->save();


    }

    public function searchUser(Request $request){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
         
        $users = User::where('name','LIKE',"%{$request->searchQuery}%")->get();

        return $users;
    }
}
