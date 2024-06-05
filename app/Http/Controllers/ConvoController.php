<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Convo;

use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Models\mentorAppointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
    $newConvo->created_at = $request->created_at;
// dd($request->file('file')->getClientOriginalName());
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('chat_files');
        $newConvo->fileName = $fileName;
        $newConvo->filePath = $filePath;
    }

    $newConvo->save();  

        return event(new MessageSent($request->message, Auth::id(), $request->appointmentId, $request->created_at, $request->file('file')->getClientOriginalName(),$newConvo->file_path ));
    }

    public function downloadFile(Request $request){
        $filePath = $request->filePath;

        if (!Storage::exists($filePath)) {
            abort(404);
        }
        return response()->download(storage_path('app/' . $filePath));
    }


    public function getConvoId(Request $request){
        if($request->role == 1){
            $ConvoId = mentorAppointment::where('studentId', Auth::id())
                ->join('adminportal.users AS user', 'user.id', '=', 'mentorId')
                ->join('mentorportal.appointmentstatus AS status', 'Status', '=', 'status.statusId')
                ->where(function ($query) {
                    $query->where('Status', 1)
                        ->orWhere('Status', 3);
                })
                ->select("appointmentId", "title", "user.name", 'status.statusName', 'status.statusId', 'mentorId as userId')
                ->get();
        }
        else if($request->role == 2){
            $ConvoId = mentorAppointment::where('mentorId', Auth::id())
                ->join('adminportal.users AS user', 'user.id', '=', 'studentId')
                ->join('mentorportal.appointmentstatus AS status', 'Status', '=', 'status.statusId')
                ->where(function ($query) {
                    $query->where('Status', 1)
                        ->orWhere('Status', 3);
                })
                ->select("appointmentId", "title", "user.name", 'status.statusName', 'status.statusId', 'studentId as userId')
                ->get();
        }
        else if($request->role == 3){
            $ConvoId = mentorAppointment::
                join('adminportal.users AS user', 'user.id', '=', 'studentId')
                ->join('mentorportal.appointmentstatus AS status', 'Status', '=', 'status.statusId')
                ->where(function ($query) {
                    $query->where('Status', 1)
                        ->orWhere('Status', 3);
                })
                ->select("appointmentId", "title", "user.name", 'status.statusName', 'status.statusId')
                ->get();
        }
        return $ConvoId;
    }
    

    // public function getConvoIdForMentor(){
    //     $ConvoId = mentorAppointment::where('mentorId', Auth::id())
    //     ->join(DB::raw('adminportal.users AS user'), 'user.id', '=', 'mentorId')
    //     ->join(DB::raw('mentorportal.appointmentstatus AS status'), 'Status', '=', 'status.statusId')
    //     ->where('Status', 1)
    //     ->orWhere('Status', 3)
    //     ->select("appointmentId", "title", "user.name", 'status.statusName', 'status.statusId')
    //     ->get();

    //     return  $ConvoId;
    // }

    public function searchConvo(Request $request)
{   
    $convo = mentorAppointment::query(); 

    if ($request->role == 1) {
        $convo->where('studentId', Auth::id())
            ->join('adminportal.users AS user', 'user.id', '=', 'mentorId');
    } elseif ($request->role == 2) {
        $convo->where('mentorId', Auth::id())
            ->join('adminportal.users AS user', 'user.id', '=', 'studentId');
    } elseif ($request->role == 3) {
        // No additional conditions for role 3
         $convo->join('adminportal.users AS user', 'user.id', '=', 'studentId');
    }

    $convo->join('mentorportal.appointmentstatus AS status', 'Status', '=', 'status.statusId')
        ->where('user.name', 'LIKE', "%{$request->titleQuery}%")
        ->where(function($query) {
            $query->where('Status', 1)
                  ->orWhere('Status', 3);
        })
        ->select("appointmentId", "title", "user.name", 'status.statusName', 'status.statusId');

    $convoResult = $convo->get(); 

    return $convoResult;
}


}
