<?php

namespace GitScrum\Classes;

use GitScrum\Models\User;

class UserClass
{
    public function save($data)
    {
        $userReturn = $user = User::where('provider_id', '=', $data['provider_id'])->first();

        if ($user === null) {
            return User::create($data);
        } else {
            return $userReturn;
        }
    }
}
