@section('title',  _('Login'))

@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="middle-box text-center loginscreen">
            <div>
                <h3>{{_('Welcome to')}} Git<strong>Scrum</strong></h3>

                <div class="row">
                    <a href="{{route('auth.github')}}" class="btn btn-lg btn-success btn-block">
                        <i class="fa fa-github" aria-hidden="true"></i>&nbsp;&nbsp;Login with <strong>Github</strong>
                    </a>
                </div>

                <p class="m-t"> <small>The GitScrum is licensed under the <a href="http://opensource.org/licenses/GPL-3.0" target="_blank">GPL v3 license</a>.</small> </p>
            </div>
        </div>
    </div>
</div>

@endsection
