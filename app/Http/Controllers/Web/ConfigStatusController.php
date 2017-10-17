<?php

namespace GitScrum\Http\Controllers\Web;

use Illuminate\Http\Request;

class ConfigStatusController extends Controller
{
    public function updatePosition(Request $request)
    {
        if (resolve('ConfigStatusService')->updatePosition($request)) {
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
                'success' => false,
        ]);
    }
}
