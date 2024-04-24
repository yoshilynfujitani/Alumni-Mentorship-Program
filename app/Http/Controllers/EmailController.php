<?php

namespace App\Http\Controllers;


use App\Mail\HelloEmail;
use App\Models\AlumniCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\AppointmentMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    public function sendEmail(Request $request)
    {

        $code = Str::random(8);
        
        $receiverEmailAddress = $request->email;

        try {
            
            Mail::to($receiverEmailAddress)->send(new HelloEmail($request->userName,$code,$receiverEmailAddress));



            $alumniCode = new AlumniCode();
            $alumniCode->email = $receiverEmailAddress;
            $alumniCode->code = $code;
            $alumniCode->save();
            
            return "Email has been sent successfully.";
            
        } catch (\Exception $e) {
            // Handle exceptions if any
            return "Error: " . $e->getMessage();
        }
    }

    public function sendEmailAppointment(Request $request)
    {
    
        
        $receiverEmailAddress = $request->email;
       

        try {
            
            Mail::to($receiverEmailAddress)->send(new AppointmentMail);
            return "Email has been sent successfully.";
            
        } catch (\Exception $e) {
            // Handle exceptions if any
            return "Error: " . $e->getMessage();
        }
    }
}
