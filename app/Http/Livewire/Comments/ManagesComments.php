<?php

namespace App\Http\Livewire\Comments;

use App\Models\Comment;
use App\Concerns\HasComments;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

trait ManagesComments
{
    use AuthorizesRequests;

    public bool $managingComment = false;
    public ?Comment $comment = null;

    public function rules(): array
    {
        return [
            'comment.comment' => ['required', 'string']
        ];
    }

    /**
     * @return HasComments
     */
    public abstract function commentable();

    public function manageComment(Comment $comment): void
    {
        $this->clearValidation();
        $this->comment = $comment;
        $this->authorizeModel($this->comment);

        $this->managingComment = true;
    }

    public function saveComment(): void
    {
        if (is_null($this->comment)) {
            return;
        }

        $this->authorizeModel($this->comment);
        $this->validate();

        $this->commentable()->comments()->save($this->comment->forceFill([
            'author_id' => Auth::id(),
            'type' => Comment::TYPE_NOTE
        ]));

        $this->emitModelCreated();

        $this->managingComment = false;
    }

    protected function authorizeModel(Comment $comment): void
    {
        $comment->exists ?
            $this->authorize('update', $comment) :
            $this->authorize('create', Comment::class);
    }

    protected function emitModelCreated(): void
    {
        $this->emit('commentSaved');
    }
}
