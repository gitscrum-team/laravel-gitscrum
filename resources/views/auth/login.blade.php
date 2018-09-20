@section('title',  trans('gitscrum.title-login'))

@extends('layouts.master-fluid', ['hideNavbar' => true, 'bodyClass' => 'body-login'])

@section('content')
<script async defer src="https://buttons.github.io/buttons.js"></script>

<a href="https://github.com/GitScrum-Community/laravel-gitscrum"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/e7bbb0521b397edbd5fe43e7f760759336b5e05f/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677265656e5f3030373230302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png"></a>

    <div class="authentication__left-screen">

        <div class="aligner">

            <div class="text-center">

                <div class="authentication__logo">
                    <img src="{{ asset('img/gitscrum-circle.png') }}">
                </div>

                <h3 class="">
                    {{trans('gitscrum.welcome-to')}}
                    <a href="https://github.com/gitscrum-community" target="_blank"><strong>GitScrum</strong></a>
                </h3>

                <a href="{{route('auth.provider', ['provider' => 'github'])}}" class="btn btn-lg btn-default btn-loader">
                    <i class="fa fa-github" aria-hidden="true"></i>&nbsp;&nbsp;<strong>GitHub</strong>
                </a>

                <a href="{{route('auth.provider', ['provider' => 'gitlab'])}}" class="btn btn-lg btn-default btn-loader">
                    <i class="fa fa-gitlab" aria-hidden="true"></i>&nbsp; <strong>GitLab</strong>
                </a>

                <a href="{{route('auth.provider', ['provider' => 'bitbucket'])}}" class="btn btn-lg btn-default btn-loader">
                    <i class="fa fa-bitbucket" aria-hidden="true"></i>&nbsp; <strong>Bitbucket</strong>
                </a>

                <a href="{{route('auth.provider', ['provider' => 'gitea'])}}" class="btn btn-lg btn-default btn-loader">
                    <i class="fa" aria-hidden="true"></i>&nbsp; <strong>Gitea</strong>
                </a>
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
