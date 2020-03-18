@section('title',  trans('gitscrum.title-login'))

@extends('layouts.master-fluid', ['hideNavbar' => true, 'bodyClass' => 'body-login'])

@section('content')

    <div class="authentication__left-screen">

        <div class="aligner">

            <div class="text-center">
<div class="row">


    <div class="authentication__logo">
        <img src="{{ asset('img/gitscrum-circle.png') }}">
    </div>

    <h3 class="">
        {{trans('gitscrum.welcome-to')}}
        <a href="https://github.com/gitscrum-community-edition" target="_blank"><strong>GitScrum</strong></a>
    </h3>





    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="col-md-4 control-label">Password</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>

                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            </div>
        </div>
    </form>



        </div>

<div class="row">


    <!-- a href="{{route('auth.provider', ['provider' => 'github'])}}" class="btn btn-lg btn-default btn-loader">
        <i class="fa fa-github" aria-hidden="true"></i>&nbsp;&nbsp;<strong>GitHub</strong>
    </a -->

    <a href="{{route('auth.provider', ['provider' => 'gitlab'])}}" class="btn btn-lg btn-default btn-loader">
        <i class="fa fa-gitlab" aria-hidden="true"></i>&nbsp; <strong>GitLab</strong>
    </a>

    <!-- a href="{{route('auth.provider', ['provider' => 'bitbucket'])}}" class="btn btn-lg btn-default btn-loader">
        <i class="fa fa-bitbucket" aria-hidden="true"></i>&nbsp; <strong>Bitbucket</strong>
    </a>

    <a href="{{route('auth.provider', ['provider' => 'gitea'])}}" class="btn btn-lg btn-default btn-loader">
        <i class="fa" aria-hidden="true"></i>&nbsp; <strong>Gitea</strong>
    </a>
    <p class="small">The GitScrum Community is licensed under the
        <a href="https://github.com/gitscrum-community-edition/laravel-gitscrum/blob/master/LICENSE.md" target="_blank">MIT license
        </a>
    </p -->
</div>

            </div>

        </div>
    </div>

    <div class="authentication__right-screen">

        <div class="aligner">
            <div class="content">
                <h1>GitScrum</h1>
                <h2>be faster</h2>

                <p>{{trans('gitscrum.slogan')}}</p>
            </div>
        </div>

    </div>

@endsection
