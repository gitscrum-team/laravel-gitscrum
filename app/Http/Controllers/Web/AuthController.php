<?php
/**
 * GitScrum v0.1.
 *
 * @author  Renato Marinho <renato.marinho@s2move.com>
 * @license http://opensource.org/licenses/GPL-3.0 GPLv3
 */

namespace GitScrum\Http\Controllers\Web;

use GitScrum\Http\Requests\AuthRequest;
use GitScrum\Models\User;
use Socialite;
use Auth;
use SocialiteProviders\Manager\Exception\InvalidArgumentException;
use Session;

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
        Session::flush();
        return redirect()->route('home');
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
                throw new InvalidArgumentException(trans('gitscrum.provider-was-not-set'));
                break;
        }
    }

    public function handleProviderCallback($provider)
    {
        $providerUser = Socialite::driver($provider)->user();
        $data = app(ucfirst($provider))->tplUser($providerUser);

        $user = User::where('provider_id', '=', $data['provider_id'])->first();

        if (!isset($user)) {
            $user = User::create($data);
        }

        Auth::loginUsingId($user->id);

        return redirect()->route('user.dashboard');
    }
}
