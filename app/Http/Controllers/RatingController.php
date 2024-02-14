<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    //
    public function calculateRating(Request $request){
   
        $user = DB::connection('admin')->table('users')->where('id', $request-> userId)->first();
       
        $userFeedbacks = Feedback::where('userToRateId', $request-> userId)->get();
        
        $totalRating = 0;
        foreach ($userFeedbacks as $feedback) {
            $totalRating += $feedback->rating;
        }
    
        $ratingValue = ($userFeedbacks->count() > 0) ? $totalRating / $userFeedbacks->count() : 0;
    
        // Update mentor's rating in the database
        DB::connection('admin')->table('users')->where('id', $request-> userId)->update(['rating' => $ratingValue]);
    
        return response()->json(['success' => true, 'message' => 'Rating calculated and saved successfully']);
    }
    
}
