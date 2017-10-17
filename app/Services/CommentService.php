<?php

namespace GitScrum\Services;

use GitScrum\Http\Requests\CommentRequest;
use GitScrum\Models\Comment;

class CommentService
{
    public function create(CommentRequest $request)
    {
        $data = [
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'comment' => $request->comment,
        ];

        if ( ! $comment = Comment::create($data) ) {
            return ;
        }

        return $comment;
    }

    public function update(CommentRequest $request)
    {
        $comment = Comment::find($request->id)->userActive()->firstOrFail();
        $comment->comment = $request->comment;
        return $comment->save();
    }
}