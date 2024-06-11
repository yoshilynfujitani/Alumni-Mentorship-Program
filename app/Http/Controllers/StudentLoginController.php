<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentLoginController extends Controller
{
    public function login(Request $request) {
        $user = User::where("email", $request->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }
    
        if ($user->role === 2 && $user->verified === 0) {
            return response()->json(['message' => 'Unverified user'], 403);
        }
    
        Auth::login($user);
    
        $userDetails = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'verified' => $user->verified,
            'first_login' => $user->first_login
     
        ];
    
        return response()->json([
            'message' => 'Login successful',
            'user' => $userDetails
        ], 200);
    }
    
    
    public function checkUserStatus(){
        $user = Auth::user();
    
   
        $ticketStatus = $user->ticketStatus;
        $fieldToTake = $user->fieldToTake;
        $allowToAppoint = $user->allowToAppoint;
        $rating = $user->rating;
        $username = $user->name;
        return ['ticketStatus' =>$ticketStatus, 'fieldToTake'=>$fieldToTake, 'allowToAppoint'=>$allowToAppoint, 'userId'=>Auth::id()
    ,'rating'=>$rating, 'username'=> $username];
    }
    public function updateLastActive(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->last_active_at = now();
            $user->save();

            return response()->json(['message' => 'Last active timestamp updated.']);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function isOnline($id)
{
    $user = User::findOrFail($id);
    $lastActiveAt = $user->last_active_at;
    
    if ($lastActiveAt && Carbon::now()->diffInMinutes($lastActiveAt) <= 5) {
        return response()->json(['online' => true]);
    }
    
    return response()->json(['online' => false]);
}

    public function getUserTicketStatus(){
        $user = Auth::user();

        $ticketStatus = $user->ticketStatus;
        return ['ticketStatus' => $ticketStatus];
    }

    public function getUserAllowToAppointStatus(){
        $user = Auth::user();
        $allowToAppoint = $user->allowToAppoint;
        return ['allowToAppoint' => $allowToAppoint];
    }

    public function checkLogin()
{
    if (Auth::check()) {
        $user = Auth::user();
        
        $userName = $user->name;
        $role = $user->role;
        
        $collegeId = $user->course;
        $college = DB::connection('admin')->table('colleges')->where('id', $collegeId)->select('CollegeName')->first();

        // Initialize collegeName to null
        $collegeName = null;
        
        if ($college) {
            $collegeName = $college->CollegeName;
        }
        
        return [
            'college' => $collegeName,
            'role' => $role,
            'loggedIn' => true,
            'userName' => $userName,
            'userId' => $user->id
        ];
    } else {
        return [
            'loggedIn' => false,
        ];
    }
}

    

    public function logout() {
        
        return Auth::logout();
      }
}
