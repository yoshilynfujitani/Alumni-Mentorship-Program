<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    //
    public function requestTicket(Request $request){
        $newTicket = new Ticket();
       
        $newTicket->studentId = Auth::id();
        $newTicket->field = $request->fieldId;
        $newTicket->save();

        $currentUser = User::find(Auth::id());
        $currentUser->ticketStatus = 1;
        $currentUser->save();

        return;
    }
}
