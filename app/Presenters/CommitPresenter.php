<?php

namespace GitScrum\Presenters;

trait CommitPresenter
{
    public function getTotalLinesAttribute()
    {
        $lines = $this->files->map(function ($file) {
            return count(preg_split('/\R/', $file->raw));
        });

        return array_sum($lines->all());
    }

    public function getTotalAdditionsAttribute()
    {
        $additions = $this->files->map(function ($file) {
            return $file->additions;
        });

        return array_sum($additions->all());
    }

    public function getTotalChangesAttribute()
    {
        $changes = $this->files->map(function ($file) {
            return $file->changes;
        });

        return array_sum($changes->all());
    }

    public function getTotalDeletionsAttribute()
    {
        $deletions = $this->files->map(function ($file) {
            return $file->deletions;
        });

        return array_sum($deletions->all());
    }

    public function totalPHPCS($type = 'ERROR')
    {
        $errors = $this->files->map(function ($file) use ($type) {
            return $file->filePhpcs()->where('type', '=', $type)->groupBy('type')->count();
        });

        return array_sum($errors->all());
    }
}
