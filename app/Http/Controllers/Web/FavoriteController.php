<?php

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
