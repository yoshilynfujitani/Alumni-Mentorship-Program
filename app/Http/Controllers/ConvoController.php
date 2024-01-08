<?php

namespace App\Http\Controllers;

use App\Models\Convo;
use Illuminate\Http\Request;

use Auth;

class ConvoController extends Controller
{
    //
    public function getChat(Request $request){
        $getConvo = Convo::where('appointmentId',$request->appointmentId)->get();


        return $getConvo ;
    }

    public function sendChat(Request $request){
        $newConvo = new Convo();

        $newConvo->userId = Auth::id();
        $newConvo->appointmentId = $request->appointmentId;
        $newConvo->chats = $request->message;

        $newConvo->save();

        return;
    }

}
