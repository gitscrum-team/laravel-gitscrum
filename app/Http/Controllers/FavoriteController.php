<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Http\Controllers;

use GitScrum\Models\Favorite;
use Auth;

class FavoriteController extends Controller
{
    public function store($type, $id)
    {
        $data = [
            'favoriteable_id' => $id,
            'favoriteable_type' => $type,
        ];
        Favorite::create($data);

        return back()->with('success', _('Favorited successfully'));
    }

    public function destroy($type, $id)
    {
        $favorite = Favorite::where('favoriteable_id', $id)
            ->where('favoriteable_type', $type)
            ->where('user_id', Auth::user()->id)->first();

        $favorite->delete();

        return back()->with('success', _('Unfavorited successfully'));
    }
}
