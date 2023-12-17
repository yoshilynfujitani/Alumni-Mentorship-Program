<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mentor;
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
        $data = DB::table(DB::raw('adminportal.users AS users'))
        ->join(DB::raw('mentorportal.appointmentdetails AS appt'),'users.id','=','appt.mentorId')
        ->join(DB::raw('mentorportal.appointmentstatus AS status'), 'appt.Status', '=', 'status.statusId')
        ->where("studentId",Auth::id())
        ->orderBy("appt.created_at")
        ->select('users.name', 'appt.*', 'status.*') 
        ->get();
       
        
        return $data;
    }
    
}
