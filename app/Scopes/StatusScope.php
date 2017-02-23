<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Scopes;

use GitScrum\Models\ConfigStatus;

trait StatusScope
{
    public function scopeTrack($query, $alias, $model, $id = null)
    {
        if (!isset($model->config_status_id)) {
            if (is_null($id)) {
                $status = ConfigStatus::type($alias)->default();
            } else {
                $status = ConfigStatus::find($id);
            }

            $model->config_status_id = $status->first()->id;
        }

        $this->create([
            'statusesable_type' => $alias,
            'statusesable_id' => $model->id,
            'config_status_id' => $model->config_status_id,
            'user_id' => $model->user_id, ]);
    }
}
