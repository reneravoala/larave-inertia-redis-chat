<?php

namespace App\Models;


use Cmgmyr\Messenger\Models\Thread;

class Discussion extends Thread
{
    public function one($userId)
    {
        return $this->participants()->where('user_id', $userId)->first();
    }

    public function otherUser($userId)
    {
        return $this->participants()
            ->whereNot('user_id', $userId)
            ->join('users', 'participants.user_id', '=', 'users.id')
            ->select('users.*')
            ->first();
    }

    public function messagesWithUser()
    {
        return $this->messages()
            ->orderBy('messages.created_at', 'ASC')
            ->join('users', 'messages.user_id', '=', 'users.id')
            ->select('messages.*', 'users.name');
    }
}
