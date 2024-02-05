<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    //
    public function calculateRating(Request $request){
        $mentor = DB::connection('admin')->table('users')->where('id', $request->mentorId)->first();
       
        $mentorFeedbacks = Feedback::where('mentorId', $request->mentorId)->get();
        
        $totalRating = 0;
        foreach ($mentorFeedbacks as $feedback) {
            $totalRating += $feedback->rating;
        }
    
        $ratingValue = ($mentorFeedbacks->count() > 0) ? $totalRating / $mentorFeedbacks->count() : 0;
    
        // Update mentor's rating in the database
        DB::connection('admin')->table('users')->where('id', $request->mentorId)->update(['rating' => $ratingValue]);
    
        return response()->json(['success' => true, 'message' => 'Rating calculated and saved successfully']);
    }
    
}
