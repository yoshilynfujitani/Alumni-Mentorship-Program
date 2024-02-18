<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Convo;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Models\mentorAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Broadcast;

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

        return event(new MessageSent($request->message, Auth::id(), $request->appointmentId ));
    }

    public function getConvoId(){
        $ConvoId = mentorAppointment::where('studentId', Auth::id())
        ->join(DB::raw('adminportal.users AS user'), 'user.id', '=', 'mentorId')
        ->where('Status', 1)
        ->orWhere('Status', 3)
        ->select("appointmentId", "title", "user.name")
        ->get();

        return  $ConvoId;
    }

}
