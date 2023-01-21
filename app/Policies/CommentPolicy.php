<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Comment $comment)
    {
        return $user->is($comment->author) && $comment->type === Comment::TYPE_NOTE;
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->is($comment->author) && $comment->type === Comment::TYPE_NOTE;
    }
}
