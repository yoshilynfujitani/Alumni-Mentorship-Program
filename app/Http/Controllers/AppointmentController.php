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

    public function getPieChartData(){
        $appointments = mentorAppointment::
    join(DB::raw('adminportal.userfields AS field'), 'field.fieldId', '=', 'appointmentdetails.field')
    ->where('appointmentdetails.studentId', Auth::id())
    ->select('field.fieldName', 'field.id')
    ->addSelect(DB::raw('(SELECT COUNT(DISTINCT appointmentId) FROM appointmentdetails WHERE appointmentdetails.field = field.fieldId AND appointmentdetails.studentId = ' . Auth::id() . ') as count'))
    ->groupBy('field.fieldName', 'field.id')
    ->get();

 // You may need to adjust this query based on your actual data structure
       
        $data = [
            'labels' => [],
            'datasets' => [
                [
                    'backgroundColor' => ["#41B883", "	#FAFA33", "#00D8FF", "#DD1B16"],
                    'data' => [],
                ],
            ],
        ];

        // Populate labels and data based on the subject of the appointment
        foreach ($appointments as $appointment) {
            $data['labels'][] = $appointment->fieldName;
            $data['datasets'][0]['data'][] = $appointment->count; // Assuming you have a 'count' field in your Appointment model
        }

        return response()->json(['chartData' => $data]);
    }
    public function getBarChartData()
    {
        $currentYear = now()->year; // Get the current year
        $appointments = MentorAppointment::whereYear('created_at', $currentYear)
            ->orderBy('created_at')
            ->where('studentId', Auth::id())
            ->get();

        $monthlyAppointments = [];

        // Initialize counts for all months to zero
        foreach (range(1, 12) as $month) {
            $monthName = Carbon::createFromDate($currentYear, $month, 1)->format('F');
            $monthlyAppointments[$monthName] = 0;
        }

        // Count appointments for each month
        foreach ($appointments as $appointment) {
            $month = Carbon::parse($appointment->created_at)->format('F');
            $monthlyAppointments[$month]++;
        }

        return array_values($monthlyAppointments);
    }
    
    
}
