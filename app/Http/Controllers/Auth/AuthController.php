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
use SocialiteProviders\Manager\Exception\InvalidArgumentException;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
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

    public function redirectToProvider($provider)
    {
        switch ($provider) {
            case 'gitlab':
                return Socialite::with('gitlab')->redirect();
                break;
            case 'github':
                return Socialite::driver('github')->scopes(['repo', 'notifications', 'read:org'])->redirect();
                break;
            default:
                throw new InvalidArgumentException('Provider was not set');
                break;
        }
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $data = [
            'provider_id' => $user->id,
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
