<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PDCController extends Controller
{
    //
    public function updateMentorStatus(Request $request){
        $userRecord = User::find($request->mentorId);

        $userRecord->verified = $request->statusId;

        $userRecord->save();
        return $userRecord;
    }
}
