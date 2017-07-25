<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Services;

use Config;
use GitScrum\Http\Requests\LabelRequest;
use GitScrum\Models\Label;

class LabelService extends Service
{
    public function create(LabelRequest $request)
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

        $relation = Config::get('database.relation');

        $result = $relation[$request->labelable_type]::where('id', $request->labelable_id)->first();

        if (!$result->labels()->where('label_id', $label->id)->first()) {
            $result->labels()->attach([$label->id]);
        }

        return $label;
    }
}
