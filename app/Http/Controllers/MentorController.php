<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    //
    public function signUp(Request $request){
   
        if(Mentor::where('email', $request->email)->exists()){
            return;
        }
        $user = new Mentor;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->field = $request->field;
        $user->password = Hash::make($request->password);
    
        $res = $user->save();

        return $res;
    }

    public function getMentors(){
        return Mentor::select()->where('verified', 1)->get();
    }
}
