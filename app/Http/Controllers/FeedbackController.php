<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\mentorAppointment;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //
    public function sendFeedback(Request $request){
        $feedback = new Feedback();
        $appointmentDetails = mentorAppointment::find($request->appointmentId);
        
        $appointmentDetails->feedback_sent = 1;
        $appointmentDetails->save();

        $feedback->appointmentId = $request-> appointmentId;
        $feedback->studentId = Auth::id();
        $feedback->mentorId = $request-> mentorId;
        $feedback->rating = $request->rating;
        $feedback->comments = $request->comments;

        $res = $feedback->save();

        return $res;
        
    }
}
