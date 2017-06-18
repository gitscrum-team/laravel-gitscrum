<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers;

use GitScrum\Models\Favorite;

class FavoriteController extends Controller
{
    public function store($type, $id)
    {
        $data = [
            'favoriteable_id' => $id,
            'favoriteable_type' => $type,
        ];
        Favorite::create($data);

        return back()->with('success', trans('gitscrum.favorited-successfully'));
    }

    public function destroy($type, $id)
    {
        $favorite = Favorite::where('favoriteable_id', $id)
            ->where('favoriteable_type', $type)->userActive()->first();

        $favorite->delete();

        return back()->with('success', trans('gitscrum.unfavorited-successfully'));
    }
}
