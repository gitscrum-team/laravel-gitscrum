@section('page-title', trans('gitscrum.welcome-to-gitScrum-step-1'))

@section('header-title', trans('gitscrum.welcome-to') .' ' . trans('GitScrum') . ' - ' .
    $repositories->count() . ' ' . trans('gitscrum.repositories') )

@section('header-subtitle', trans('gitscrum.you-can-import-the-repositories-to-GitScrum') )

@extends('layouts.master')

@section('content')

<div class="ui last container">
    <div class="ui three steps">
        <div class="active step">
            <div class="content">
                <div class="title">{{trans('gitscrum.step1')}}</div>
                <div class="description">Choose your shipping options</div>
            </div>
        </div>
        <div class="disabled step">
            <div class="content">
                <div class="title">{{trans('gitscrum.step2')}}</div>
                <div class="description">Enter billing information</div>
            </div>
        </div>
        <div class="disabled step">
            <div class="content">
                <div class="title">{{trans('gitscrum.finish')}}</div>
                <div class="description">Review your order details</div>
            </div>
        </div>
    </div>

    <form action="{{route('wizard.step2')}}" method="post">
        {{ csrf_field() }}

        @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

        <button class="ui button green right">{{trans('gitscrum.confirm-to-add-repositories-into-the')}} <strong>{{trans
        ('GitScrum')
        }}</strong></button>

    </form>

</div>
@endsection
