<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class StudentSignUpController extends Controller
{
    //
    public function signUp(Request $request){
        if(User::where('email', $request->email)->exists()){
            return;
        }
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->course = $request->course;
        $user->role = 1;
        $user->password = Hash::make($request->password);

        $res = $user->save();

        return $res;
    }
}
