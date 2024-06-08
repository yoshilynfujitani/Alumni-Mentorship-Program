<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AlumniCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    //
    public function getAlumni(){
        $user = Auth::user();

        if($user->role === 3){
            $data = DB::connection("admin")->table('users')
                ->join('colleges', 'colleges.id', '=', 'users.course')
                ->where('users.verified', 0)
                ->select('users.name','users.email', 'colleges.CollegeName')
                ->get();
        }
        else{
            $data = User::where('verified', 0)
            ->where('course', $user->course)
            ->get();
        }
        

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
        $user = Auth::user();

          if($user->role === 3){
             $data = User::where('verified', 0)
            ->where('name','LIKE',"%{$request->alumniQuery}%")->get();

        }
        else{
             $data = User::where('verified', 0)
            ->where('course', $user->course)
            ->where('name','LIKE',"%{$request->alumniQuery}%")->get();

        }
         
        return $data;
    }
}
