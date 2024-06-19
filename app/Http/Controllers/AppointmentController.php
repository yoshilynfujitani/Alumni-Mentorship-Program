<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Convo;
use App\Models\Mentor;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\mentorAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    //
    public function requestAppointment(Request $request){
        $newAppointment = new mentorAppointment();
        $student = DB::connection('admin')->table('users')->where('id', Auth::id())->first();

       
        $newAppointment->studentId = Auth::id();
        $newAppointment->mentorId = $request->mentorId;
        $newAppointment->title = $request->title;
        $newAppointment->field = $request->field;
        $newAppointment->startSchedule = Carbon::parse($request->date);

        // DB::connection('admin')->table('users')->where('id', Auth::id())->update(['allowToAppoint' => 2]);


    
        $res = $newAppointment->save();

    
        return $res;
    }
    public function getOngoingAppointments(Request $request){

        if($request->userType === 1){
        $data = DB::table(DB::raw('adminportal.users AS users'))
        ->join(DB::raw('mentorportal.appointmentdetails AS appt'),'users.id','=','appt.mentorId')
        ->join(DB::raw('mentorportal.appointmentstatus AS status'), 'appt.Status', '=', 'status.statusId')
        ->join(DB::raw('mentorportal.requestordetails AS reqby'), 'appt.requestedBy','=','reqby.id')
        ->join(DB::raw('adminportal.fields AS field'), 'appt.field','=','field.id')
        ->where("studentId",Auth::id())
        ->where("StatusId", 1)
        ->orderBy("appt.created_at")
        ->select('users.name', 'appt.*', 'status.*', 'reqby.requestor', 'field.fieldName') 
        ->paginate(5);
        }
        else if($request->userType === 2){
        $data = DB::table(DB::raw('adminportal.users AS users'))
        ->join(DB::raw('mentorportal.appointmentdetails AS appt'),'users.id','=','appt.studentId')
        ->join(DB::raw('mentorportal.appointmentstatus AS status'), 'appt.Status', '=', 'status.statusId')
        ->join(DB::raw('mentorportal.requestordetails AS reqby'), 'appt.requestedBy','=','reqby.id')
        ->join(DB::raw('adminportal.fields AS field'), 'appt.field','=','field.id')
        ->where("mentorId",Auth::id())
        ->where("StatusId", 1)
        ->orWhere("StatusId", 0)
        ->orderBy("appt.created_at")
        ->select('users.name', 'appt.*', 'status.*', 'reqby.requestor', 'field.fieldName') 
        ->paginate(5);
        }
        
       
        return $data;
    }
    public function getCountTotalAppointments(){
        $data = mentorAppointment::where("studentId", Auth::id())->count();
    
        return $data;
    }
    public function getAppointments(){
        $data = DB::table(DB::raw('adminportal.users AS users'))
        ->join(DB::raw('mentorportal.appointmentdetails AS appt'),'users.id','=','appt.mentorId')
        ->join(DB::raw('mentorportal.appointmentstatus AS status'), 'appt.Status', '=', 'status.statusId')
        ->join(DB::raw('mentorportal.requestordetails AS reqby'), 'appt.requestedBy','=','reqby.id')
        ->join(DB::raw('adminportal.fields AS field'), 'appt.field','=','field.id')
        ->where("studentId",Auth::id())
      
        ->orderBy("appt.created_at", "desc")
        ->select('users.name', 'appt.*', 'status.*', 'reqby.requestor', 'field.fieldName') 
        ->paginate(10);
       
        
        return $data;
    }

    

    public function getAppointment(Request $request) {
    $appointmentId = $request->input('appointmentId');

    $data = DB::table(DB::raw('adminportal.users AS users'))
        ->join(DB::raw('mentorportal.appointmentdetails AS appt'), 'users.id', '=', 'appt.studentId')
        ->join(DB::raw('adminportal.colleges AS college'), 'users.course', '=', 'college.id')
        ->join(DB::raw('mentorportal.appointmentstatus AS status'), 'appt.Status', '=', 'status.statusId')
        ->join(DB::raw('mentorportal.requestordetails AS reqby'), 'appt.requestedBy', '=', 'reqby.id')
        ->where("appt.appointmentId", $appointmentId) 
        ->select('users.name','users.rating', 'appt.*', 'status.*', 'reqby.requestor', 'users.course', 'college.CollegeName') 
        ->first();

    $feedbackExists = Feedback::where('appointmentId', $appointmentId)
        ->where('userId', Auth::id())
        ->exists();

    $data->feedbackSent = $feedbackExists;

    return $data;
}

    public function getPieChartData(Request $request){
        
        $appointments = mentorAppointment::join(DB::raw('adminportal.fields AS field'), 'field.id', '=', 'appointmentdetails.field');

        if($request->role == 1) {
            $appointments->where('appointmentdetails.studentId', Auth::id())
                ->select('field.fieldName', 'field.id')
                ->addSelect(DB::raw('(SELECT COUNT(DISTINCT appointmentId) FROM appointmentdetails WHERE appointmentdetails.field = field.id AND appointmentdetails.studentId = ' . Auth::id() . ') as count'))
                ->groupBy('field.fieldName', 'field.id');
            }
        elseif($request->role == 2) {
            $appointments->where('appointmentdetails.mentorId', Auth::id())
                ->select('field.fieldName', 'field.id')
                ->addSelect(DB::raw('(SELECT COUNT(DISTINCT appointmentId) FROM appointmentdetails WHERE appointmentdetails.field = field.id AND appointmentdetails.mentorId = ' . Auth::id() . ') as count'))
                ->groupBy('field.fieldName', 'field.id');
        
            }

        $appointments = $appointments->get();

        $data = [
            'labels' => [],
            'datasets' => [
                [
                    'backgroundColor' => ["#41B883", "#FAFA33", "#00D8FF", "#DD1B16"],
                    'data' => [],
                ],
            ],
        ];

        foreach ($appointments as $appointment) {
            $data['labels'][] = $appointment->fieldName;
            $data['datasets'][0]['data'][] = $appointment->count; 
        }

        return response()->json(['chartData' => $data]);
    }
    public function getBarChartData(Request $request)
    {
        $currentYear = now()->year; 
        $appointments = MentorAppointment::whereYear('created_at', $currentYear)
            ->orderBy('created_at');
            if($request->role == 1){
                $appointments->where('studentId', Auth::id());
            }
            elseif($request->role == 2){
                $appointments->where('mentorId', Auth::id());
            }
            
            $appointments = $appointments->get();

        $monthlyAppointments = [];

        foreach (range(1, 12) as $month) {
            $monthName = Carbon::createFromDate($currentYear, $month, 1)->format('F');
            $monthlyAppointments[$monthName] = 0;
        }

  
        foreach ($appointments as $appointment) {
            $month = Carbon::parse($appointment->created_at)->format('F');
            $monthlyAppointments[$month]++;
        }

        return array_values($monthlyAppointments);
    }

    
    
    
}
