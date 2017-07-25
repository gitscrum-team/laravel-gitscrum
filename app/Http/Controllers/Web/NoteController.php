<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers\Web;

use Illuminate\Http\Request;
use GitScrum\Http\Requests\NoteRequest;
use GitScrum\Models\Note;
use Carbon\Carbon;
use Auth;

class NoteController extends Controller
{
    public function store(NoteRequest $request)
    {
        resolve('NoteService')->create($request);

        return back()->with('success', trans('gitscrum.added-successfully'));
    }

    public function update(Request $request, $slug)
    {
        $request->request->add([
            'slug' => $slug
        ]);
        
        resolve('NoteService')->update($request);

        return back()->with('success', trans('gitscrum.updated-successfully'));
    }

    public function destroy($id)
    {
        $note = Note::find($id);
        //->where('user_id', Auth::user()->id)->firstOrFail();
        $note->delete();

        return back()->with('success', trans('gitscrum.deleted-successfully'));
    }
}
