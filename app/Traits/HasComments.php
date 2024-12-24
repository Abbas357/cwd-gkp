<?php

namespace App\Traits;

use App\Models\Comment;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function addComment(array $data): Comment
    {
        $data['commentable_type'] = get_class($this);
        $data['commentable_id'] = $this->id;

        return $this->comments()->create($data);
    }

    public function getComments()
    {
        return $this->comments()->get();
    }

    public function getFirstComment()
    {
        return $this->comments()->orderBy('created_at', 'asc')->first();
    }

    public function getLastComment()
    {
        return $this->comments()->orderBy('created_at', 'desc')->first();
    }

    public function countComments(): int
    {
        return $this->comments()->count();
    }

    public function hasComments(): bool
    {
        return $this->comments()->exists();
    }

    public function getNestedComments()
    {
        return $this->comments()->with('replies')->get();
    }

    public function getCommentsByName(string $name)
    {
        return $this->comments()->where('name', $name)->get();
    }

    public function searchComments(string $keyword)
    {
        return $this->comments()->where('body', 'like', "%{$keyword}%")->get();
    }

    public function deleteComments()
    {
        $this->comments()->delete();
    }
}
