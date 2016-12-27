<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Controllers;

use Illuminate\Http\Request;
use GitScrum\Http\Requests\LabelRequest;
use GitScrum\Models\Label;

class LabelController extends Controller
{
    public function index($model, $slug_label)
    {
        $label = Label::slug($slug_label)->first();

        return view('labels.index')
            ->with('label', $label)
            ->with('list', $label->$model()->paginate(env('APP_PAGINATE')));
    }

    public function store(LabelRequest $request)
    {
        $data = [
            'labelable_id' => $request->labelable_id,
            'labelable_type' => $request->labelable_type,
            'title' => $request->title,
        ];

        try {
            $label = Label::create($data);
        } catch (\Exception $e) {
            $label = Label::where('title', $request->title)->first();
        }

        $relation = \Config::get('database.relation');

        $result = $relation[$request->labelable_type]::where('id', $request->labelable_id)->first();

        if (!$result->labels()->where('label_id', $label->id)->first()) {
            $result->labels()->attach([$label->id]);
        }

        return back()->with('success', trans('Label added successfully'));
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
