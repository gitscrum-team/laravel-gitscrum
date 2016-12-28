<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
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

        return back()->with('success', trans('Comment added successfully'));
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

        return back()->with('success', trans('Comment updated successfully'));
    }

    public function destroy($id)
    {
        $comment = Comment::find($id)->userActive()->firstOrFail();

        $comment->delete();

        return back()->with('success', trans('Comment deleted successfully'));
    }
}
