<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class StudentLoginController extends Controller
{
    //
    public function login(Request $request){
        if(User::where("email",$request->email)->exists()){
            $user = User::where("email",$request->email)->first();
            if(Hash::check($request->password, $user->password)){
                Auth::login($user);
    
                // Include user details in the response
                $userDetails = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    // Add other user details as needed
                ];
    
                return response()->json([
                    'message' => 'Login successful',
                    'user' => $userDetails
                ], 200);
            } else {
                return response()->json(['message' => 'Invalid password'], 401);
            }
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
    

    public function checkLogin()
    {
        if (Auth::check()) {
            // User is logged in
            $user = Auth::user();
    
            // Additional information
            $userName = $user->name; // Replace 'name' with the actual field in your users table
            $ticketStatus = $user->ticketStatus; // Replace 'ticket_status' with the actual field in your users table
    
            // Return the information as an associative array
            return [
                'loggedIn' => true,
                'userName' => $userName,
                'ticketStatus' => $ticketStatus,
            ];
        } else {
            // User is not logged in
            return [
                'loggedIn' => false,
            ];
        }
    }
    

    public function logout() {
        
        return Auth::logout();
      }
}
