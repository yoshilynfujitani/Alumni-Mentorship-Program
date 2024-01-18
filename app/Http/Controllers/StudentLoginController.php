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
    
    public function checkUserStatus(){
        $user = Auth::user();
    
   
        $ticketStatus = $user->ticketStatus;
        $fieldToTake = $user->fieldToTake;
        $allowToAppoint = $user->allowToAppoint;
        return ['ticketStatus' =>$ticketStatus, 'fieldToTake'=>$fieldToTake, 'allowToAppoint'=>$allowToAppoint, 'userId'=>Auth::id()];
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
