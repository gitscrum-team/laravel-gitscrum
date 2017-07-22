<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Services;


use GitScrum\Models\Favorite;

class FavoriteService
{
    public function create($type, $resource_id)
    {
        $data = [
            'favoriteable_id' => $resource_id,
            'favoriteable_type' => $type,
        ];

        return Favorite::create($data);
    }

    public function delete($type, $resource_id)
    {
        $favorite = Favorite::where('favoriteable_id', $resource_id)
            ->where('favoriteable_type', $type)->userActive()->first();

        $favorite->delete();
    }
}