<?php

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
