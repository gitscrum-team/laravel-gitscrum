@section('title',  trans('Sprints'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>{{trans('Sprint Backlog - List')}}</h3>
</div>
<div class="col-lg-6 text-right">
    <div class="btn-group">
        <a href="{{route('sprints.index', ['mode'=>'calendar'])}}" class="btn btn-sm btn-primary">
            {{trans('Mode Calendar')}}</a>
        <a href="{{route('sprints.create')}}"
            class="btn btn-sm btn-primary"
            data-toggle="modal" data-target="#modalLarge">{{trans('Create Sprint Backlog')}}</a>
    </div>
</div>
@endsection

@section('content')

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-content">
            @include('partials.boxes.sprint', [ 'list' => $sprints ])
        </div>
    </div>
</div>

@endsection
