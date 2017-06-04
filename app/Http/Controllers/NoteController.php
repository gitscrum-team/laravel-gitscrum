<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers;

use Illuminate\Http\Request;
use GitScrum\Http\Requests\NoteRequest;
use GitScrum\Models\Note;
use Carbon\Carbon;
use Auth;

class NoteController extends Controller
{
    public function store(NoteRequest $request)
    {
        $data = [
            'noteable_id' => $request->noteable_id,
            'noteable_type' => $request->noteable_type,
            'title' => $request->title,
        ];

        Note::create($data);

        return back()->with('success', trans('gitscrum.added-successfully'));
    }

    public function update(Request $request, $slug)
    {
        $note = Note::slug($slug)->first();

        $note->closed_user_id = Auth::id();
        $note->closed_at = Carbon::now();
        $note->save();

        return back()->with('success', trans('gitscrum.updated-successfully'));
    }

    public function destroy($id)
    {
        $note = Note::find($id)
            //->where('user_id', Auth::user()->id)
            ->firstOrFail();
        $note->delete();

        return back()->with('success', trans('gitscrum.deleted-successfully'));
    }
}
