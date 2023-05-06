<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;

class ReplyPolicy extends Policy
{

    public function destroy(User $user, Reply $reply)
    {
        return $reply->user_id === $user->id;
        return true;
    }

}
