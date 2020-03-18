<?php

namespace GitScrum\Http\Controllers\Web;

use GitScrum\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use GitScrum\Models\User;
use Socialite;
use Auth;
use Dotenv\Validator;
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



    public function authenticate(Request $request)
    {


        $request->validate([
            'email' => 'email|required',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            // The user is active, not suspended, and exists.
            return redirect()->route('user.dashboard');
        }else{
            return redirect()->back()->withInput()->withErrors(['warning', 'usuario não cadastrado']);
        }



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
            case 'bitbucket':
                return Socialite::driver('bitbucket')->redirect();
                break;

            // case 'gogs':  someday, maybe
            case 'gitea':
               return view('gitea.login');


            default:
                throw new InvalidArgumentException(trans('gitscrum.provider-was-not-set'));
                break;
        }
    }

    public function handleProviderCallback($provider)
    {
        $providerUser = Socialite::driver($provider)->user();

        $data = app(ucfirst($provider))->tplUser($providerUser);

        $user = User::updateOrCreate(['provider_id' => $data['provider_id']], $data);

        Auth::loginUsingId($user->id);

        return redirect()->route('user.dashboard');
    }
}
