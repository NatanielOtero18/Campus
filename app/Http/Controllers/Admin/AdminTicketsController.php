<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Tickets;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminTicketsController extends Controller
{
    //
    public function index(Request $request){
        
        return Inertia::render('Admin/AdminTickets',[
            'tickets' => Tickets::all()
        //     ->when($request->input('search'), function ($query, $search) {
        //         $query->where('subject', 'like', '%' . $search . '%');
        //         $query->orWhere('content', 'like', '%' . $search . '%');

        //     })
        //     ->orderBy('pivot_solved')
        //     ->get()
        //     ->map(fn($message)=>[
        //         'id' => $message->id,
        //         'subject' => $message->subject,
        //         'content' => $message->content,
        //         'sender' => User::find($message->sender_id),
        //         'created_at' => $message->created_at,
        //         'updated_at' => $message->updated_at,
        //         'solved' => $message->receiver->solved
        //     ]            
        //    )
        ]);
    }
    public function createTicket(){
        return Inertia::render('Admin/ContactAdmin');
    }

    public function storeTicket(Request $request){
        $att = $request->validate([
            'subject' => ['required', 'max:255'],
            'content' => ['required'],
            'sender_id' => ['required', 'exists:users,id'],
        ]);         

        $message = Tickets::create($att);       
        
    }
}
