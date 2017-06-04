@section('title',  trans('gitscrum.dashboard'))

@extends('layouts.master', ['bodyClass' => 'body-dashboard'])

@section('breadcrumb')

<div class="col-lg-6">
    <h3>{{trans('gitscrum.dashboard')}}</h3>
</div>

<div class="col-lg-6 text-right">
    <div class="btn-group">
        <a href="{{route('wizard.step1')}}" class="btn btn-sm btn-primary">
            {{trans('gitscrum.update-repositories')}}</a>
    </div>
</div>

@endsection

@section('content')

<div class="col-lg-3">

    <div class="shortcuts">
        <h4>{{trans('gitscrum.shortcuts')}}</h4>
        <a href="{{route('issues.index',['slug' => 0])}}">{{trans('gitscrum.my-planning')}}</a>
        <a href="{{route('wizard.step1')}}">{{trans('gitscrum.sync-repos-issues')}}</a>
    </div>

    @include('partials.boxes.team', ['list'=>$user->team(), 'title'=>trans('gitscrum.team')])

    @include('partials.boxes.note', [ 'list' => $user,
        'type'=> 'users', 'title' => trans('gitscrum.quick-notes'),
        'percentage' => Helper::percentage($user, 'notes')])
</div>


<div class="col-lg-7">

    @include('partials.boxes.burndown', ['list' => Helper::burndown($user, 5), 'height' => 220])

    <h4>{{trans('gitscrum.current-sprints-backlog')}} <a href="{{route('sprints.create')}}"
         class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#modalLarge"
         role="button">{{trans('gitscrum.create-sprint-backlog')}}</a></h4>
    @include('partials.boxes.sprint', [ 'list' => $sprints, 'column' => $sprintColumns ])

</div>

<div class="col-lg-2">
    <div class="activities">
        <h4>{{trans('gitscrum.lastest-activities')}}</h4>
        @each('partials.lists.activities-complete', $user->activities(null, 7), 'activity', 'partials.lists.no-items')
    </div>
</div>


@endsection
