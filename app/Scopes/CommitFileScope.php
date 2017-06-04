<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Scopes;

trait CommitFileScope
{
    public function scopeTotalLines($query)
    {
        $total = preg_split('/\R/', $this->raw);

        return count($total);
    }

    public function scopeTotalPHPCS($query, $type = 'ERROR')
    {
        return $this->filePhpcs()->where('type', '=', $type)->groupBy('type')->count();
    }
}
