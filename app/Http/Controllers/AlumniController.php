<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniCode;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    //
    public function getAlumni(){
        $data = User::where('verified', 0)->get();

        return $data;
    }

    public function verifyInvite(Request $request){
        $user = User::where('email', $request->email)->first();
        $alumnicode = AlumniCode::where('email', $request->email)->latest()->first();
      
    
        if($alumnicode->code === $request->code && $alumnicode->email === $request->email){
            $user->verified = 1;
            $user->save();
            return 1;
        }
        else{
            return 0;
        }
     
    }

    public function searchAlumni(Request $request){
          $data = User::where('verified', 0)
          ->where('name','LIKE',"%{$request->alumniQuery}%")->get();

        return $data;
    }
}
