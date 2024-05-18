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
        $mentorschedule->start = $request->start;
        $mentorschedule->end = $request->end;

        $mentorschedule->save();
    }

    public function getLatestSchedule(Request $request){


        $mentorId = $request->has('mentorId') ? $request->mentorId : Auth::id();
   

        $currentSchedule = Schedule::where("mentor_id", $mentorId)->orderBy('created_at', 'desc')->first();

        if(empty($currentSchedule)){
            return;
        }
        else{
            $currentSchedule->daysOfTheWeek = str_split($currentSchedule->daysOfTheWeek);
            return $currentSchedule;
        }
          
    }

    public function getAllSchedule(Request $request){
        $mentorId = $request->has('mentorId') ? $request->mentorId : Auth::id();
        $sched = Schedule::where('mentor_id', $mentorId)
        ->orderByDesc('created_at')
        ->select('daysOfTheWeek','start','end', 'created_at')
        ->paginate(10);

        return $sched;

    }


}
