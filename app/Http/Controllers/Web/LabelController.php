<?php

namespace GitScrum\Http\Controllers\Web;

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
            ->with('listPartial',kebab_case($model))
            ->with('list', $label->$model()->paginate(env('APP_PAGINATE')));
    }

    public function store(LabelRequest $request)
    {
        resolve('LabelService')->create($request);

        return back()->with('success', trans('gitscrum.label-added-successfully'));
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
