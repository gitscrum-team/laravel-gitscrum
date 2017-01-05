@section('title',  trans('Welcome to GitScrum - Step 1'))

@extends('layouts.master')

@section('breadcrumb')
    <div class="nav-wizard">
        <div class="col-lg-6">
            <h3>{{trans('Welcome to')}} {{trans('GitScrum')}}</h3>
        </div>
        <div class="col-lg-6">
            <h3 class="ptn mtn mbn pbn pull-right">{{$repositories->count()}} {{trans('repositories')}}</h3>
        </div>
    </div>
@endsection

@section('main-title')
<p class="font-bold text-center">
    @if($repositories->count())
        {{trans('Congratulations')}}.
        <span>{{trans('You have successfully added repositories for')}} {{trans('GitScrum')}}</span>
    @else
        {{trans(':( Choose at least one repository')}}.
        <span>{{trans('You can click')}} <a href="{{route('wizard.step1')}}">{{trans('here')}}</a> {{trans('to try again')}}</span>
    @endif
</p>
@endsection

@section('content')
<div class="col-lg-12">

    @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

    <div class="text-center">

        @if(count($repositories))
        <a href="{{route('wizard.step3')}}" class="btn btn-lg btn-success btn-loader">{{trans('Import my')}}
            <strong>{{Auth::user()->provider}} {{trans('Issues')}}</strong></a>
        <span>&nbsp;&nbsp;&nbsp;<strong>{{trans('or')}}</strong>&nbsp;&nbsp;&nbsp;</span>
        @endif

        <a href="{{route('product_backlogs.index')}}" class="btn btn-lg btn-default">{{trans('Continue using')}} <strong>{{trans('GitScrum')}}</strong></a>
    </div>

</div>
@endsection
