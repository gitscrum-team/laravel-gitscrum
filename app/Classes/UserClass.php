<?php namespace GitScrum\Classes;

use Auth;
use GitScrum\Models\User;

class UserClass {

    public function save($data)
    {

        $userReturn= $user = User::where('github_id','=', $data['github_id'])->first();
        
        if($user === null){
            return User::create($data);
        } else {
            return $userReturn;
        }

    }

}
