<?php

namespace GitScrum\Services;

use Illuminate\Http\Request;
use GitScrum\Models\ConfigStatus;

class ConfigStatusService
{
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

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
