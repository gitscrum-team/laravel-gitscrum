<?php

namespace GitScrum\Classes;

use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Auth;

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

    public static function request($url, $auth = true, $customRequest = null, $postFields = null)
    {
        $user = Auth::user();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if (env('PROXY_PORT')) {
            curl_setopt($ch, CURLOPT_PROXYPORT, env('PROXY_PORT'));
            curl_setopt($ch, CURLOPT_PROXYTYPE, env('PROXY_METHOD'));
            curl_setopt($ch, CURLOPT_PROXY, env('PROXY_SERVER'));
        }

        if (env('PROXY_USER')) {
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, env('PROXY_USER').':'.env('PROXY_USER'));
        }

        if (!is_null($postFields)) {
            $postFields = json_encode($postFields);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json',
                'Content-Length: '.strlen($postFields), ]);
        }

        //curl_setopt($ch, CURLOPT_HTTPHEADER,  ['Authorization: Bearer OAUTH-TOKEN']);

        if (!is_null($customRequest)) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $customRequest); //'PATCH'
        }

        if ($auth && isset($user->username)) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $user->username.':'.$user->token);
        }

        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public static function lengthAwarePaginator($collection, $page = 1)
    {
        $page = intval($page)?intval($page):1;
        return new LengthAwarePaginator($collection->forPage($page, env('APP_PAGINATE')),
            $collection->count(), env('APP_PAGINATE'));
    }
}
