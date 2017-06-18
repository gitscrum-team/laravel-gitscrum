<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers;

use GitScrum\Http\Requests\CommentRequest;
use GitScrum\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $data = [
            'commentable_id' => $request->commentable_id,
            'commentable_type' => $request->commentable_type,
            'comment' => $request->comment,
        ];
        Comment::create($data);

        return back()->with('success', trans('gitscrum.comment-added-successfully'));
    }

    public function edit($id)
    {
        $comment = Comment::find($id);

        return view('comments.edit')
            ->with('route', 'comments.update')
            ->with('id', $comment->commentable_id)
            ->with('type', $comment->commentable_type)
            ->with('comment', $comment);
    }

    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::find($id)->userActive()->firstOrFail();
        $comment->comment = $request->comment;
        $comment->save();

        return back()->with('success', trans('gitscrum.comment-updated-successfully'));
    }

    public function destroy($id)
    {
        $comment = Comment::find($id)->userActive()->firstOrFail();

        $comment->delete();

        return back()->with('success', trans('gitscrum.comment-deleted-successfully'));
    }
}
