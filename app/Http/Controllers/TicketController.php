<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Http\Requests\PostTicketCommentRequest;
use App\Models\HistoryBuy;
use App\Models\Ticket;
use App\Models\Ticket_Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(){
        $user = Auth::user();
        if ($user->role != 1) {
            $tickets = Ticket::where('user_id', $user->id)->get();
        } else {
            $tickets = Ticket::all();
        }
        return view('ticket.index', compact('tickets'));
    }

    public function show($ticket_id){
        $user = Auth::user();
        $ticket = Ticket::where('id', $ticket_id)->first();
        if ($user->role != 1) {
            $ticket = Ticket::where('id', $ticket_id)->where('user_id', $user->id)->first();
        }
        
        abort_if(empty($ticket), 404);

        return view('ticket.show', compact('ticket'));
    }

    public function create(){
        $user = Auth::user();
        abort_if($user->role == 1, 404);
        $getHistoryBuy = HistoryBuy::where('user_id', $user->id)->orderBy('created_at','desc')->get();
        return view('ticket.create', compact('getHistoryBuy'));
    }

    public function postCreate(CreateTicketRequest $request){
        $user = Auth::user();
        abort_if($user->role == 1, 404);
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['ip_address'] = $request->ip();

        $ticket = new Ticket($data);
        $ticket->save();

        return redirect()->route('ticket.show', ['ticket_id' => $ticket->id]);
    }

    public function postComment(PostTicketCommentRequest $request, $ticket_id){
        $user = Auth::user();
        $ticket = Ticket::where('id', $ticket_id)->first();
        if ($user->role != 1) {
            $ticket = Ticket::where('id', $ticket_id)->where('user_id', $user->id)->first();
        }
        abort_if(empty($ticket), 404);

        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['ticket_id'] = $ticket->id;
        $data['ip_address'] = $request->ip();

        $ticket_comment = new Ticket_Comment($data);
        $ticket_comment->save();
        $ticket->status = 2;
        if ($user->role == 1) {
            $ticket->status = 3;
        }
        $ticket->save();

        return redirect()->route('ticket.show', ['ticket_id' => $ticket->id]);
    }

    public function close(Request $request){
        $user = Auth::user();
        $ticket = Ticket::where('id', $request->get('ticket_id'))->first();
        if ($user->role != 1) {
            $ticket = Ticket::where('id', $request->get('ticket_id'))->where('user_id', $user->id)->first();
        }
        if (empty($ticket)) {
            return response()->json(['status' => false]);
        }

        $ticket->status = 4;
        $ticket->save();

        return response()->json(['status' => true]);
    }
}
