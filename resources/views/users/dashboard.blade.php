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

<div class="gs-card">

    <div class="gs-card-content-title">

    </div>

    <div class="col-lg-4">

        <div class="gs-card-content-title">
            <h5>Team Performance
            <small>+25pts last week</small></h5>
            <h6 class="high">High</h6>
        </div>

    </div>

    <div class="col-lg-4 border-right border-left">

        <div class="gs-card-content-title">
            <h5>Completed Tasks
                <small>vs. new tasks</small></h5>
            <h6>20 <small>/32</small></h6>
        </div>

    </div>

    <div class="col-lg-4">

        <div class="gs-card-content-title">
            <h5>New Bugs
                <small>vs. new tasks</small></h5>
            <h6 class="low">1%</h6>
        </div>

    </div>

</div>


<div class="col-lg-12 graph-main gs-card">
    <h4 class="gs-card-title">{{trans('gitscrum.burndown')}}</h4>
    @include('partials.boxes.burndown', ['list' => Helper::burndown($user, 5), 'height' => 240])
</div>

<div class="col-lg-3 gs-card flat">

    <div class="shortcuts">
        <h4 class="gs-card-title">{{trans('gitscrum.shortcuts')}}</h4>
        <div class="gs-card-content">
            <a href="{{route('issues.index',['slug' => 0])}}">{{trans('gitscrum.my-planning')}}</a>
            <a href="{{route('wizard.step1')}}">{{trans('gitscrum.sync-repos-issues')}}</a>
        </div>
    </div>

    @include('partials.boxes.team', ['list'=>$user->team(), 'title'=>trans('gitscrum.team')])

    @include('partials.boxes.note', [ 'list' => $user,
        'type'=> 'users', 'title' => trans('gitscrum.quick-notes'),
        'percentage' => Helper::percentage($user, 'notes')])
</div>


<div class="col-lg-9 gs-card flat">
    <div>
        <h4 class="gs-card-title">{{trans('gitscrum.current-sprints-backlog')}} <a href="{{route('sprints.create')}}"
             class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#modalLarge"
             role="button">{{trans('gitscrum.create-sprint-backlog')}}</a></h4>
        <div class="gs-card-content">
            @include('partials.boxes.sprint', [ 'list' => $sprints, 'column' => $sprintColumns ])
        </div>
    </div>

    <div>
        <div class="activities">
            <h4 class="gs-card-title">{{trans('gitscrum.lastest-activities')}}</h4>
            <div class="gs-card-content">
                @each('partials.lists.activities-complete', $user->activities(null, 7), 'activity', 'partials.lists.no-items')
            </div>
        </div>
    </div>

</div>

@endsection
