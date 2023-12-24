<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    //
    public function signUp(Request $request){
   
        if(User::where('email', $request->email)->exists()){
            return;
        }
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->field = $request->field;
        $user->role = 2;
        $user->password = Hash::make($request->password);
    
        $res = $user->save();

        return $res;
    }

    public function getMentors(Request $request){
        if($request->fetchMentorBy == "active"){
            return DB::connection('admin')->table('users')
            ->join('userstatus', 'users.verified', '=', 'userstatus.statusId')
            ->select('users.*', 'userstatus.statusName')
            ->where('users.verified', 1)
            ->where('users.role', 2)->get();
        }
        
        if($request->fetchMentorBy == "pending"){
            return DB::connection('admin')->table('users')
            ->join('userstatus', 'users.verified', '=', 'userstatus.statusId')
            ->select('users.*', 'userstatus.statusName')
            ->where('users.verified', 0)
            ->where('users.role', 2)->get();
        }
        if($request->fetchMentorBy == "all"){
            return DB::connection('admin')->table('users')->orderBy('created_at')
            ->join('userstatus', 'users.verified', '=', 'userstatus.statusId')
            ->select('users.*', 'userstatus.statusName')
        
            ->where('users.role', 2)->get();
        }
        

    }
  
}
