<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }
    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count', 1);
        $reply->topic->user->notifyUser(new TopicReplied($reply));
    }
    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count');
    }
}
