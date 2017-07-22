<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers\Web;

class FavoriteController extends Controller
{
    public function store($type, $id)
    {
        resolve('FavoriteService')->create($type, $id);
        return back()->with('success', trans('gitscrum.favorited-successfully'));
    }

    public function destroy($type, $id)
    {
        resolve('FavoriteService')->delete($type, $id);
        return back()->with('success', trans('gitscrum.unfavorited-successfully'));
    }
}
