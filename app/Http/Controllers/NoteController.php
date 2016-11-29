<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
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

        return back()->with('success', _('Added successfully'));
    }

    public function update(Request $request, $slug)
    {
        $note = Note::where('slug', $slug)->first();

        $note->closed_user_id = Auth::id();
        $note->closed_at = Carbon::now();
        $note->save();

        return back()->with('success', _('Updated successfully'));
    }

    public function destroy($id)
    {
        $note = Note::where('id', $id)
            //->where('user_id', Auth::user()->id)
            ->firstOrFail();
        $note->delete();

        return back()->with('success', _('Note deleted successfully'));
    }
}
