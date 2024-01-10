<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tickets;
use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminTicketsController extends Controller
{
    //
    public function index(Request $request){
        
        return Inertia::render('Admin/AdminTickets',[
            'tickets' => Tickets::
            when($request->input('search'), function ($query, $search) {
                $query->where('subject', 'like', '%' . $search . '%');
                $query->orWhere('content', 'like', '%' . $search . '%');
                $query->orWhereRelation('user.role','name','like', '%' . $search . '%');

            })
            ->orderBy('solved')
            ->get()                 
           
        ]);
    }
    public function tasks(){
        return Inertia::render('Admin/AdminTasks',[
            'tickets' => Tickets::where('solved', false)->get()
        ]);
    }
    public function createTicket(){
        return Inertia::render('Admin/ContactAdmin');
    }

    public function storeTicket(Request $request){


        $att = $request->validate([
            'subject' => ['required', 'max:255'],
            'content' => ['required']         
        ]);  
        
       
        $thread = Thread::create([
            'subject' => "Ticket-" . $att['subject']
        ]);
        $att['user_id'] =  auth()->user()->id;
        $att['thread_id'] = $thread->id;
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->user()->id,
            'last_read' => new Carbon(),
        ]);

        Tickets::create($att);       
        
    }

    public function solveTicket(Tickets $ticket)
    {
        return Inertia::render('Admin/SolveTicket',[
            'ticket' => $ticket,
            'thread' => Thread::with(['messages' => function($query){
                $query->orderBy('updated_at','desc');
            }])->where('id','like',$ticket->thread->id)->first()
            
        ]);
    }

    public function setTicketSolved(Tickets $ticket)
    {
        $ticket->solved = true;
        $ticket->save();
    }

    
}
