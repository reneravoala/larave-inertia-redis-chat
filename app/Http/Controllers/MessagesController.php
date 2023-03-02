<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\CreateThreadRequest;
use App\Http\Requests\SetReadRequest;
use App\Models\Discussion;
use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class MessagesController extends Controller
{
    public function index(int $thread_id)
    {
        $thread = Discussion::find($thread_id);
        $thread->markAsRead(auth()->user()->id);
        return inertia('Messages/Index', [
            'threads' => auth()->user()->threads,
            'thread' => $thread,
            'messages' => $thread->messagesWithUser()->get(),
            'other' => $thread->otherUser(auth()->user()->id),
            'user' => auth()->user(),
        ]);
    }

    public function show(int $thread_id)
    {
        $thread = Discussion::find($thread_id);
        $thread->one(auth()->user()->id)->update([
            'last_read' => new Carbon,
        ]);
        return inertia('Messages/Discussion', [
            'thread' => $thread,
            'messages' => $thread->messagesWithUser()->get(),
            'other' => $thread->otherUser(auth()->user()->id),
            'user' => auth()->user(),
        ]);
    }

    public function create(int $thread_id, CreateMessageRequest $request)
    {
        $message = Message::create([
            'thread_id' => $thread_id,
            'user_id' => auth()->user()->id,
            'body' => $request->body,
        ]);

        Redis::client()->publish('messages_' . $thread_id, json_encode([
            'thread_id' => $thread_id,
            'user_id' => auth()->user()->id,
            'body' => $request->body,
            'name' => auth()->user()->name,
            'created_at' => $message->created_at,
        ]));
    }

    public function createThread()
    {
        return inertia('Messages/CreateThread', [
            'users' => User::whereNot('id', auth()->user()->id)->get()
        ]);
    }

    public function storeThread(CreateThreadRequest $request)
    {
        $thread = Discussion::create([
            'subject' => $request->subject
        ]);
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => $request->user_id,
            'last_read' => new Carbon
        ]);
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => auth()->user()->id,
            'last_read' => new Carbon
        ]);

        return Redirect::route('messages.index', $thread->id);
    }

    public function setRead(SetReadRequest $request)
    {
        Participant::where('user_id', auth()->user()->id)
            ->where('thread_id', $request->thread_id)
            ->update([
                'last_read' => new Carbon
            ]);
    }
}
