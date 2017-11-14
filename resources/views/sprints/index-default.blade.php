@section('title',  trans('gitscrum.sprints'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>{{trans('gitscrum.sprint-backlog-list')}}</h3>
</div>
<div class="col-lg-6 text-right">
    <div class="btn-group">
        <a href="{{route('sprints.index', ['mode'=>'calendar'])}}" class="btn btn-sm btn-primary">
            {{trans('gitscrum.mode-calendar')}}</a>
        <a href="{{route('sprints.create')}}"
            class="btn btn-sm btn-primary"
            data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.create-sprint-backlog')}}</a>
    </div>
</div>
@endsection

@section('content')

<div class="col-lg-12">
    <div class="gs-card">

        <h4 class="gs-card-title">
            {{trans('gitscrum.sprint-backlog-list')}}

            <a href="{{route('sprints.create')}}" class="btn btn-default btn-sm pull-right"
               data-toggle="modal" data-target="#modalLarge" role="button">{{trans('gitscrum.create-sprint-backlog')}}</a>
        </h4>

        <div class="gs-card-content">
            @include('partials.boxes.sprint', [ 'list' => $sprints ])
        </div>
    </div>
</div>

@endsection
