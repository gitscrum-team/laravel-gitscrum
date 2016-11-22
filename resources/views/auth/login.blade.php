@section('title',  _('Login'))

@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="middle-box text-center loginscreen">
            <div>
                <h3>{{_('Welcome to')}} Git<strong>Scrum</strong></h3>

                <br />

                <div class="row">
                    <a href="{{route('auth.github')}}" class="btn btn-lg btn-success btn-block">
                        <i class="fa fa-github" aria-hidden="true"></i>&nbsp;&nbsp;Login with <strong>Github</strong></a>
                </div>

                <br />

                <!--
                <div class="hr-line-dashed"></div>

                <form class="form-horizontal m-t" role="form" method="POST" action="{{route('auth.dologin')}}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <input type="email" name="username" value="{{old('username')}}" class="form-control" placeholder="username" required autofocus>
                        @if ($errors->has('username'))
                            <span class="help-block">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('passwd') ? ' has-error' : '' }}">
                        <input type="password" name="passwd" class="form-control" placeholder="Password" required>
                        @if ($errors->has('passwd'))
                            <span class="help-block">
                                <strong>{{ $errors->first('passwd') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="row">
                        <button type="submit" class="btn btn-primary btn-outline block full-width m-b">Login</button>
                    </div>

                    <a href="#"><small>Forgot password?</small></a>
                    <p class="text-muted text-center"><small>Do not have an account?</small></p>

                    <div class="row">
                        <a class="btn btn-sm btn-white btn-block" href="">Create an account</a>
                    </div>

                </form>
                -->
                <p class="m-t"> <small>The GitScrum is licensed under the <a href="http://opensource.org/licenses/GPL-3.0" target="_blank">GPL v3 license</a>.</small> </p>
            </div>
        </div>
    </div>
</div>

@endsection
