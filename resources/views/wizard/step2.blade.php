@section('title',  trans('gitscrum.welcome-to-gitScrum-step-2'))

@extends('layouts.master')

@section('breadcrumb')
    <div class="nav-wizard">
        <div class="col-lg-6">
            <h3>{{trans('gitscrum.welcome-to')}} {{trans('GitScrum')}}</h3>
        </div>
        <div class="col-lg-6">
            <h3 class="ptn mtn mbn pbn pull-right">{{$repositories->count()}} {{trans('gitscrum.repositories')}}</h3>
        </div>
    </div>
@endsection

@section('main-title')
<p class="font-bold text-center">
    @if($repositories->count())
        {{trans('Congratulations')}}.
        <span>{{trans('gitscrum.you-have-successfully-added-repositories-for')}} {{trans('GitScrum')}}</span>
    @else
        {{trans('gitscrum.choose-at-least-one-repository')}}.
        <span>{{trans('gitscrum.you-can-click')}} <a href="{{route('wizard.step1')}}">{{trans('gitscrum.here')}}</a>
            {{trans('gitscrum.to-try-again')}}</span>
    @endif
</p>
@endsection

@section('content')
<div class="col-lg-12">

    @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

    <div class="text-center">

        @if(count($repositories))
        <a href="{{route('wizard.step3')}}" class="btn btn-lg btn-success btn-loader">{{trans('gitscrum.import-my')}}
            <strong>{{Auth::user()->provider}} {{trans('gitscrum.issues')}}</strong></a>
        <span>&nbsp;&nbsp;&nbsp;<strong>{{trans('gitscrum.or')}}</strong>&nbsp;&nbsp;&nbsp;</span>
        @endif

        <a href="{{route('product_backlogs.index')}}" class="btn btn-lg btn-default">{{trans('gitscrum.continue-using')}}
            <strong>{{trans('GitScrum')}}</strong></a>
    </div>

</div>
@endsection
