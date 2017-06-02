@section('title',  trans('gitscrum.welcome-to-gitScrum-step-1'))

@extends('layouts.master')

@section('breadcrumb')
<div class="nav-wizard">
    <div class="col-lg-6">
        <h3>{{trans('gitscrum.welcome-to')}} {{config('app.name')}}</h3>
    </div>
    <div class="col-lg-6">
        <h3 class="ptn mtn mbn pbn pull-right">{{$repositories->count()}} {{trans('gitscrum.repositories')}}</h3>
    </div>
</div>
@endsection

@section('main-title')
<p class="font-bold text-center">{{trans('gitscrum.you-can-import-the-repositories-to-GitScrum')}}</p>
@endsection

@section('content')
<div class="col-lg-12">

    <form action="{{route('wizard.step2')}}" method="post">
        {{ csrf_field() }}

        @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

        <div class="text-center">
            <button class="btn btn-lg btn-success btn-loader">{{trans('gitscrum.confirm-to-add-repositories-into-the')}} <strong>{{config('app.name')
            }}</strong></button>
        </div>

    </form>

</div>
@endsection
