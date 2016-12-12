@section('title',  trans('GitScrum Login'))

@extends('layouts.master', ['hideNavbar' => true])

@section('content')
<script async defer src="https://buttons.github.io/buttons.js"></script>

<a href="https://github.com/renatomarinho/laravel-gitscrum"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/e7bbb0521b397edbd5fe43e7f760759336b5e05f/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f677265656e5f3030373230302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png"></a>

<div class="row">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="middle-box text-center loginscreen">
                <h5 class="lead">{{trans('Welcome to')}} <strong>GitScrum</strong></h5>

                <a href="{{route('auth.github')}}" class="btn btn-hg btn-info">
                        <i class="fa fa-github" aria-hidden="true"></i>&nbsp;&nbsp;Login with <strong>GitHub</strong></a>

                <div class="text-center">
                    <a class="github-button" href="https://github.com/renatomarinho/laravel-gitscrum" data-icon="octicon-star" data-style="mega" data-count-href="/renatomarinho/laravel-gitscrum/stargazers" data-count-api="/repos/renatomarinho/laravel-gitscrum#stargazers_count" data-count-aria-label="# stargazers on GitHub" aria-label="Star renatomarinho/laravel-gitscrum on GitHub">Star</a>
                </div>

                <p class="small">The GitScrum is licensed under the <a href="http://opensource.org/licenses/GPL-3.0" target="_blank">GPL v3 license</a></p>
        </div>
    </div>
</div>

@endsection
