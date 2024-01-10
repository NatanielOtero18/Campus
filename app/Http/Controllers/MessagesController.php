<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ClassroomMessage;
use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MessagesController extends Controller
{
    //
    public function index(){
        return Inertia::render('Messages/ListThreads',[
            'threads' => auth()->user()->threads()->has('messages')->with(['participants' ,'participants.user'])->latest('updated_at')->get()->map(fn($th) =>[
                'id' => $th->id,
                'subject' => $th->subject,
                'created_at' => $th->created_at,
                'updated_at' => $th->updated_at,
                'deleted_at' => $th->deleted_at,
                'participants' => $th->participants,
                'unreadCount' => $th->userUnreadMessagesCount(),

            ])
            // 'threads' => Thread::has('messages')->with(['participants' ,'participants.user'])->latest('updated_at')->get()->map(fn($th) =>[
            //     'id' => $th->id,
            //     'subject' => $th->subject,
            //     'created_at' => $th->created_at,
            //     'updated_at' => $th->updated_at,
            //     'deleted_at' => $th->deleted_at,
            //     'participants' => $th->participants,
            //     'unreadCount' => $th->userUnreadMessagesCount(),

            // ])
        ]);
    }

    public function create(User $user){
        return Inertia::render('Messages/CreateMessage',[
            'receiver' => $user
        ]);
    } 
    public function show(Thread $thread)
    {
        $recipient = $thread->participants()->where('participants.user_id','!=',auth()->user()->id)->first();
        $participant = Participant::with('thread')->where('user_id','like',auth()->user()->id)->whereRelation('thread','id','like',$thread->id)->first();
        $participant->last_read = New Carbon(); 
        $participant->save();
        return Inertia::render('Messages/ShowThread', [
            'thread' => Thread::with(['messages' => function($query){
                $query->orderBy('updated_at','desc');
            }])->where('id','like',$thread->id)->first(),
            'recipient'=> User::find($recipient->user_id)
        ]);
    }

    public function store(Request $request)
    {
        $atts = $request->validate([
            'subject' => ['required'],
            'message' => ['required'],
            'recipient' => ['required']
        ]);

        $thread = Thread::create([
            'subject' => $atts['subject']
        ]);

        Message::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->user()->id,
            'body' => $atts['message']
        ]);

        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->user()->id,
            'last_read' => new Carbon(),
        ]);

        $thread->addParticipant($atts['recipient']);

        return Inertia::location(route('ListThreads'));


    }
    public function update(Request $request,Thread $thread){
       
        $msg = $request->validate([
            'message' => ['required'],
            'recipient' => ['required']
        ]);

        $thread->activateAllParticipants();

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->user()->id,
            'body' => $msg['message'],
        ]);

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => auth()->user()->id,
        ]);
        $participant->last_read = new Carbon();
        $participant->save();

        // Recipients       
        $thread->addParticipant($msg['recipient']);
      

       
    }

    public function classroomChat(Request $request, Classroom $classroom){
        $msg = $request->validate([
            'message' => ['required'],
        ]);

        ClassroomMessage::create([
            'message' => $msg['message'],
            'classroom_id' => $classroom->id,
            'user_id' => auth()->user()->id
        ]);

    }
}
