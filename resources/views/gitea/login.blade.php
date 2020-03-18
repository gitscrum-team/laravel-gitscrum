@section('title',  trans('gitscrum.title-login'))

@extends('layouts.master-fluid', ['hideNavbar' => true, 'bodyClass' => 'body-login'])

@section('content')
  <div class="authentication__left-screen">

        <div class="aligner">

            <div class="text-center">

                <div class="authentication__logo">
                    <img src="{{ asset('img/gitscrum-circle.png') }}">
                </div>

                <h3 class="">
                    {{trans('gitscrum.welcome-to')}}
                    <a href="https://github.com/gitscrum-community-edition" target="_blank"><strong>GitScrum</strong></a>
                </h3>

                <form action="{{route('auth.gitea')}}" method="post">
                   <p>
                   Gitea login: <input type="text" name="username"/>
                   </p>
                   <p>
                   Gitea passwd: <input type="password" name="passwd"/>
                   </p>
                   <input type="submit"/>
                </form>


                <p class="small">The GitScrum Community is licensed under the
                    <a href="https://github.com/gitscrum-community-edition/laravel-gitscrum/blob/master/LICENSE.md" target="_blank">MIT license</a></p>

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
