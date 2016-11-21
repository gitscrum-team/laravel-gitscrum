<?php namespace GitScrum\Classes;

class Helper {

    public function arrayDateRange($between, $value=0)
    {
        $arr = [];

        for ( $i = strtotime($between[0]); $i <= strtotime($between[1]); $i=$i+86400 ) {
            $date=date('Y-m-d', $i);
            $arr[$date] = $value;
        }

        return $arr;
    }

    public static function slug($value)
    {
        return str_slug(substr($value,0,40) . '-' . uniqid());
    }

}
