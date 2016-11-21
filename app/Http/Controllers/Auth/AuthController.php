<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */
namespace GitScrum\Http\Controllers\Auth;

use GitScrum\Http\Requests\AuthRequest;
use GitScrum\Models\User;
use GitScrum\Classes\UserClass;
use GitScrum\Http\Controllers\Controller;
use Carbon\Carbon;
use Socialite;
use Auth;

class AuthController extends Controller
{
    protected $redirectTo = '/home';

    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(AuthRequest $request)
    {
    }

    public function register()
    {
    }

    public function doRegister()
    {
    }

    public function redirectToProvider()
    {
        return Socialite::driver('github')->scopes(['repo', 'notifications', 'read:org'])->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
        $data = [
            'github_id' => $user->id,
            'username' => $user->nickname,
            'name' => $user->name,
            'token' => $user->token,
            'avatar' => $user->user['avatar_url'],
            'html_url' => $user->user['html_url'],
            'bio' => $user->user['bio'],
            'since' => Carbon::parse($user->user['created_at'])->toDateTimeString(),
            'location' => $user->user['location'],
            'blog' => $user->user['blog'],
            'email' => $user->email,
        ];
        $UserClass = new UserClass();
        Auth::loginUsingId($UserClass->save($data)->id);

        return redirect()->route('user.dashboard');
    }
}
