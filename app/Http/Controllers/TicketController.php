<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    //
    public function requestTicket(Request $request){
        $newTicket = new Ticket();
       
        $newTicket->studentId = Auth::id();
        $newTicket->field = $request->fieldId;
        $newTicket->ticketRemarks = $request->ticketRemarks;
        $newTicket->save();

        $currentUser = User::find(Auth::id());
        $currentUser->ticketStatus = 0;
        $currentUser->save();

        return;
    }
   public function getTickets(){
    $user = Auth::user();
    $data = null;

    if ($user->role === 3) {
        $data = Ticket::orderBy('created_at', 'DESC')
            ->join('users', 'users.id', '=', 'ticketlogs.studentId')
            ->join('userfields', 'userfields.fieldId', '=', 'ticketlogs.field')
            ->join('userstatus', 'userstatus.statusId', '=', 'ticketlogs.ticketStatus')
            ->select('users.name', 'users.course', 'ticketlogs.*', 'userfields.fieldName', 'userstatus.statusName')
            ->paginate(10);
    } else {
        $data = Ticket::orderBy('created_at', 'DESC')
            ->where('users.course', '=', $user->course)
            ->join('users', 'users.id', '=', 'ticketlogs.studentId')
            ->join('userfields', 'userfields.fieldId', '=', 'ticketlogs.field')
            ->join('userstatus', 'userstatus.statusId', '=', 'ticketlogs.ticketStatus')
            ->select('users.name', 'users.course', 'ticketlogs.*', 'userfields.fieldName', 'userstatus.statusName')
            ->paginate(10);
    }

    return $data;
}

    public function getTicketsOfStudent(){
        
        return Ticket::where('studentId', Auth::id())
        ->orderBy('created_at', 'DESC')
        ->join('users', 'users.id','=', 'ticketlogs.studentId')
        ->join('userfields', 'userfields.fieldId', '=', 'ticketlogs.field')
        ->join('userstatus', 'userstatus.statusId', '=', 'ticketlogs.ticketStatus')
        ->select('users.name','users.course', 'ticketlogs.*', 'userfields.fieldName', 'userstatus.statusName')
        ->paginate(10);
    }

    public function searchTicket(Request $request){
        $user = Auth::user();
        $data = null;

        if($user->role === 3){
            $data = Ticket::join('users', 'users.id', '=', 'ticketlogs.studentId')
            ->join('userfields', 'userfields.fieldId', '=', 'ticketlogs.field')
            ->join('userstatus', 'userstatus.statusId', '=', 'ticketlogs.ticketStatus')
            ->select('users.name', 'users.course', 'ticketlogs.*', 'userfields.fieldName', 'userstatus.statusName')
            ->where('name', 'LIKE', "%{$request->ticketQuery}%")
            ->orderBy('ticketlogs.created_at', 'DESC')
            ->get();
        }
        else{
            $data = Ticket::where('users.course', '=', $user->course)
            ->join('users', 'users.id', '=', 'ticketlogs.studentId')
            ->join('userfields', 'userfields.fieldId', '=', 'ticketlogs.field')
            ->join('userstatus', 'userstatus.statusId', '=', 'ticketlogs.ticketStatus')
            ->select('users.name', 'users.course', 'ticketlogs.*', 'userfields.fieldName', 'userstatus.statusName')
            ->where('name', 'LIKE', "%{$request->ticketQuery}%")
            ->orderBy('ticketlogs.created_at', 'DESC')
            ->get();
        }
        return $data;
        }

    public function  verifyTicket(Request $request){
        DB::transaction(function () use ($request) {
        $user = User::find($request->studentId);
        $ticket = Ticket::find($request->ticketId);

        if($request->requestStatus == 2){
            $user->ticketStatus = 2;
            $ticket->ticketStatus = 2;
            $user->save();
            $ticket->save();
            return ;
        }
        if($request->requestStatus == 1){
            $user->ticketStatus = 1;
            $user->fieldToTake = $request->field;
            $user->allowToAppoint = 1;

            $ticket->ticketStatus = 1;
            $user->save();
            $ticket->save();
            return;
        }
    });
    }

    public function getRecentStudentTicketRequests(Request $request) {
        $data = Ticket::where('ticketlogs.studentId', $request->studentId)
            ->join("userstatus", "userstatus.statusId", "=", "ticketStatus")
            ->orderBy('ticketlogs.created_at', 'desc') 
            ->take(5)
            ->select('ticketlogs.created_at', 'ticketlogs.ticketStatus', 'userstatus.statusName')
            ->get();
            
    
        return $data;
    }
    
    
}
