<?php
/**
 * Laravel GitScrum <https://github.com/renatomarinho/laravel-gitscrum>
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 Renato Marinho <renato.marinho@s2move.com>
 */

namespace GitScrum\Scopes;

trait CommitScope
{
    public function scopeTotalLines($query)
    {
        $lines = $this->files->map(function ($file) {
            return count(preg_split('/\R/', $file->raw));
        });

        return array_sum($lines->all());
    }

    public function scopeTotalAdditions($query)
    {
        $additions = $this->files->map(function ($file) {
            return $file->additions;
        });

        return array_sum($additions->all());
    }

    public function scopeTotalChanges($query)
    {
        $changes = $this->files->map(function ($file) {
            return $file->changes;
        });

        return array_sum($changes->all());
    }

    public function scopeTotalDeletions($query)
    {
        $deletions = $this->files->map(function ($file) {
            return $file->deletions;
        });

        return array_sum($deletions->all());
    }

    public function scopeTotalPHPCS($query, $type = 'ERROR')
    {
        $errors = $this->files->map(function ($file) use ($type) {
            return $file->filePhpcs()->where('type', '=', $type)->groupBy('type')->count();
        });

        return array_sum($errors->all());
    }
}
