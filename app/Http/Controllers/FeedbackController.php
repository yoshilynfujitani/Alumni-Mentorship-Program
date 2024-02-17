<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\mentorAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //
    public function sendFeedback(Request $request){
        $feedback = new Feedback();
        $appointmentDetails = mentorAppointment::find($request->appointmentId);
        
        if($request->userRole == 'Student'){
            $appointmentDetails->feedback_sent_student = 1;
        }
        else{
            $appointmentDetails->feedback_sent_mentor = 1;
        }
            
        $appointmentDetails->save();

        $feedback->appointmentId = $request-> appointmentId;
        $feedback->userId = Auth::id();
        $feedback->userToRateId = $request-> userToRateId;
        $feedback->rating = $request->rating;
        $feedback->comments = $request->comments;

        $res = $feedback->save();

        return $res;
        
    }

    public function getFeedback(Request $request){
       
        $data = Feedback::where('appointmentId', $request->appointmentId)
        ->where('userId', '!=', Auth::id())
        ->get();

        return $data;
    }

    public function getRecentMentorFeedback(Request $request){
        $data = Feedback::where('userToRateId', $request->mentorId)
        ->orderBy('created_at', 'desc') 
        ->take(3)
        ->select('rating', 'comments')
        ->get();

   
    
        return $data;
    }

  
}
