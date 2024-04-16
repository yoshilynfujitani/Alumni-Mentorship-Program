<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

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
            'verified' => $user->verified
     
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
           
    
            
            return [
                'loggedIn' => true,
                'userName' => $userName,
                'userId' => Auth::id()
               
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
