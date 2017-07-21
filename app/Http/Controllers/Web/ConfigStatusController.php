<?php
/**
 * Laravel GitScrum <https://github.com/GitScrum-Community/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Http\Controllers\Web;

use Illuminate\Http\Request;
use GitScrum\Models\ConfigStatus;

class ConfigStatusController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePosition(Request $request)
    {
        try {
            $position = 1;
            foreach ($request->columns as $id) {
                $configStatus = ConfigStatus::find($id);
                $configStatus->position = $position;
                $configStatus->save();
                ++$position;
            }

            return response()->json([
                'success' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
