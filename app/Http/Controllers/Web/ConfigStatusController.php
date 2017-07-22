<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers\Web;

use Illuminate\Http\Request;

class ConfigStatusController extends Controller
{
    public function updatePosition(Request $request)
    {
        if ( resolve('ConfigStatusService')->updatePosition($request) ) {

            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
                'success' => false,
        ]);

    }
}
