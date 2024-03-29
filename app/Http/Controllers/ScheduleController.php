<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    //
    public function setSchedule(Request $request){
    
        $daysOfTheWeek = "";
        foreach ($request->editAvailableDays as $day) {
            $daysOfTheWeek .= $day;
        }
        
      
        $mentorschedule = new Schedule();

        $mentorschedule->mentor_id = Auth::id();
        $mentorschedule->daysOfTheWeek = (int)$daysOfTheWeek;

        $mentorschedule->save();
    }

    public function getLatestSchedule(Request $request){


        $mentorId = $request->has('mentorId') ? $request->mentorId : Auth::id();
   

        $currentSchedule = Schedule::where("mentor_id", $mentorId)->orderBy('created_at', 'desc')->first();
        
        $currentSchedule->daysOfTheWeek = str_split($currentSchedule->daysOfTheWeek);

        return $currentSchedule->daysOfTheWeek;
    }

    public function getAllSchedule(){
        $sched = Schedule::where('mentor_id', Auth::id())
        ->orderByDesc('created_at')
        ->select('daysOfTheWeek', 'created_at')
        ->paginate(10);

        return $sched;

    }


}
