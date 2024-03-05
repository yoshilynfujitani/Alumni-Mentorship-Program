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
        foreach ($request->activeAvailableDays as $day) {
            $daysOfTheWeek .= $day;
        }
        
      
        $mentorschedule = new Schedule();

        $mentorschedule->mentor_id = Auth::id();
        $mentorschedule->daysOfTheWeek = (int)$daysOfTheWeek;

        $mentorschedule->save();
    }

    public function getLatestSchedule(){
        $currentSchedule = Schedule::where("mentor_id",Auth::id())->latest()->first();
        
        $currentSchedule->daysOfTheWeek = str_split($currentSchedule->daysOfTheWeek);

        return $currentSchedule->daysOfTheWeek;
    }
}
