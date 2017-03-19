@section('page-title',  trans('gitscrum.profile') . ' - ' . $user->username)

@extends('layouts.master')

@section('content')
<h2 class="ui header dividing padding-bottom-20px">
    <img src="{{$user->avatar}}" class="ui circular image">
    {{$user->name}}
</h2>

<div class="ui four statistics">
    <div class="statistic">
        <div class="value">
            <i class="trophy icon"></i> 22
        </div>
        <div class="label">{{trans('gitscrum.effort')}}</div>
    </div>
    <div class="statistic">
        <div class="value">
            <i class="puzzle icon"></i> 5
        </div>
        <div class="label">{{trans('gitscrum.cooperation')}}</div>
    </div>
    <div class="statistic">
        <div class="value">
            <i class="check square icon"></i> 5
        </div>
        <div class="label">{{trans('gitscrum.issues-done')}}</div>
    </div>
    <div class="statistic">
        <div class="value">
            <i class="{{strtolower(Auth::user()->provider)}} icon"></i>
            42
        </div>
        <div class="label">{{trans('gitscrum.commits')}}</div>
    </div>
</div>

@endsection
