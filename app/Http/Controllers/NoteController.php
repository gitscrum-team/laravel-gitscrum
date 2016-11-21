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

        $closed_at = is_null($note->closed_at) ? Carbon::now() : null;
        $closed_user_id = is_null($note->closed_at) ? Auth::user()->id : null;

        $note->closed_user_id = $closed_user_id;
        $note->closed_at = $closed_at;
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
