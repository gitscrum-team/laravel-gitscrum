@section('page-title',  trans('gitscrum.dashboard'))

@section('header-title',  trans('gitscrum.dashboard'))

@extends('layouts.master', ['bodyClass' => 'body-dashboard'])

@section('content')

    <div class="ui grid">
        <div class="four wide column">
            <div class="ui segment">
                <div class="ui list">
                    <h3 class="ui header">{{trans('gitscrum.shortcuts')}}</h3>
                    <a href="{{route('issues.index',['slug' => 0])}}" class="item">{{trans('gitscrum.my-planning')}}</a>
                    <a href="{{route('wizard.step1')}}" class="item">{{trans('gitscrum.sync-repos-issues')}}</a>
                </div>
            </div>

            @include('partials.boxes.note', [ 'list' => $user,
                'type'=> 'users', 'title' => trans('gitscrum.quick-notes'),
                'percentage' => Helper::percentage($user, 'notes')])

            @include('partials.boxes.team', ['list'=>$user->team(), 'title'=>trans('gitscrum.team')])

        </div>
        <div class="nine wide computer three wide tablet six wide mobile column">
            <div class="ui segment">Content</div>
        </div>
        <div class="three wide computer nine wide tablet six wide mobile column">
            <div class="ui segment">Content</div>
        </div>
    </div>

<div class="col-lg-3">




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
