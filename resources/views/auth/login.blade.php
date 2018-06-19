@section('title',  trans('gitscrum.title-login'))

@extends('layouts.master-fluid', ['hideNavbar' => true, 'bodyClass' => 'body-login'])

@section('content')
<script async defer src="https://buttons.github.io/buttons.js"></script>


    <div class="authentication__left-screen">

        <div class="aligner">

            <div class="text-center">

                <div class="authentication__logo">
                </div>

                <h3 class="">
                    {{trans('gitscrum.welcome-to')}}
                    <a href="https://github.com/gitscrum-community-edition" target="_blank"><strong>GitScrum</strong></a>
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
