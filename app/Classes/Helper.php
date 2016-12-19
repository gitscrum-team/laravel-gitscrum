<?php

namespace GitScrum\Classes;

use Carbon\Carbon;

class Helper
{
    public static function arrayDateRange($between, $value = 0)
    {
        $arr = [];

        for ($i = strtotime($between[0]); $i <= strtotime($between[1]); $i = $i + 86400) {
            $date = date('Y-m-d', $i);
            $arr[$date] = $value;
        }

        return $arr;
    }

    public static function slug($value)
    {
        return str_slug(substr($value, 0, 40).'-'.uniqid());
    }

    public static function percentage($model, $feature)
    {
        if (isset($model->{$feature})) {
            $total = $model->{$feature}->count();
            $totalClosed = $model->{$feature}->where('closed_at', '!=', null)->count();

            return ($totalClosed) ? ceil(($totalClosed * 100) / $total) : 0;
        }

        return 0;
    }

    public static function burndown($obj, $subDays = null)
    {
        $total = $obj->issues->count();
        $arr = [];
        if ($total) {
            if (is_null($subDays)) {
                $started = $obj->date_start;
                $finished = (Carbon::now() > $obj->date_finish) ?
                    (is_null($obj->closed_at) ? Carbon::now() : $obj->closed_at) : $obj->date_finish;
            } else {
                $dt = Carbon::now();
                $started = $dt->subDays($subDays)->toDateString();
                $finished = $dt->addDays($subDays + 1)->toDateString();
            }

            $dates = self::arrayDateRange([$started, $finished], $total);

            $previous = $started;
            $arr[$previous] = $total;

            foreach ($dates as $date => $value) {
                $closed = $obj->issues()->whereDate('closed_at', '=', $date)->get()->count();
                $totalPrevious = $total - $arr[$previous];
                $arr[$date] = $total - ($closed + $totalPrevious);
                $previous = $date;
            }
        }

        return $arr;
    }
}
