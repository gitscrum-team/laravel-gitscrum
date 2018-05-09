<?php

namespace GitScrum\Http\Controllers\Web;

use GitScrum\Http\Requests\AuthRequest;
use GitScrum\Models\User;
use GitScrum\Classes\Gitea;
use Socialite;
use Auth;
use SocialiteProviders\Manager\Exception\InvalidArgumentException;
use Session;

class AuthGiteaController extends Controller
{
    public function handleProviderCallback(AuthRequest $request)
    {
        $provider = 'gitea';
        $giteaUser = Gitea::login($request->post("username"), $request->post("passwd"));

        if (!$giteaUser) {
            return redirect()->route('auth.login');
        }

        $data = app(ucfirst($provider))->tplUser($giteaUser);

        $user = User::updateOrCreate(['provider_id' => $data['provider_id']], $data);

        Auth::loginUsingId($user->id);

        return redirect()->route('user.dashboard');
    }
}
