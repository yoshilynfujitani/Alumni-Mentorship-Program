<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\mentorAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    //
    public function requestAppointment(Request $request){
        $newAppointment = new mentorAppointment();
       
        $newAppointment->studentId = Auth::id();
        $newAppointment->mentorId = $request->mentorId;
        $newAppointment->title = $request->title;
        $newAppointment->field = $request->field;
        
       
        $newAppointment->startSchedule = Carbon::parse($request->date);
    
        $res = $newAppointment->save();
    
        return $res;
    }
    public function getAppointments(){
        return  DB::connection("mentor")->table('appointmentdetails')
        ->select('appointmentdetails.*', 'mentordetails.name as mentor_name')
        ->join('mentordetails', 'mentordetails.mentorId', '=', 'appointmentdetails.mentorId')
        ->where('appointmentdetails.studentId', '=', Auth::id())
        ->get();
    
    }
}
