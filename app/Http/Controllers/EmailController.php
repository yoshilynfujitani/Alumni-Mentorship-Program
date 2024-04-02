<?php

namespace App\Http\Controllers;

use App\Mail\HelloEmail;
use Illuminate\Http\Request;
use App\Mail\AppointmentMail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    //
    public function sendEmail(Request $request)
    {
    
        
        $receiverEmailAddress = $request->email;

        try {
            
            Mail::to($receiverEmailAddress)->send(new HelloEmail);
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
