@section('title',  trans('Dashboard'))

@extends('layouts.master', ['bodyClass' => 'body-dashboard'])

@section('breadcrumb')

<div class="col-lg-6">
    <h3>{{trans('Dashboard')}}</h3>
</div>

<div class="col-lg-6 text-right">
    <div class="btn-group">
        <a href="{{route('wizard.call', ['provider' => \Session::get('provider'), 'step' => 'step1'])}}" class="btn btn-sm btn-primary">
            {{trans('Update Repositories')}}</a>
    </div>
</div>

@endsection

@section('content')

<div class="col-lg-3">

    <div class="shortcuts">
        <h4>{{trans('Shortcuts')}}</h4>
        <a href="{{route('issues.index',['slug' => 0])}}">{{trans('My Planning')}}</a>
        <a href="{{route('wizard.call', ['provider' => \Session::get('provider'), 'step' => 'step1'])}}">{{trans('Sync Repos/Issues')}}</a>
    </div>

    @include('partials.boxes.team', ['list'=>$user->team(), 'title'=>trans('Team')])

    @include('partials.boxes.note', [ 'list' => $user,
        'type'=> 'user', 'title' => trans('Quick Notes'),
        'percentage' => Helper::percentage($user, 'notes')])
</div>


<div class="col-lg-7">

    @include('partials.boxes.burndown', ['list' => Helper::burndown($user, 5), 'height' => 220])

    <h4>{{trans('Current Sprints Backlog')}} <a href="{{route('sprints.create')}}"
         class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#modalLarge"
         role="button">{{trans('Create Sprint Backlog')}}</a></h4>
    @include('partials.boxes.sprint', [ 'list' => $sprints, 'column' => $sprintColumns ])

</div>

<div class="col-lg-2">
    <div class="activities">
        <h4>{{trans('Lastest Activities')}}</h4>
        @each('partials.lists.activities-complete', $user->activities(null, 7), 'activity', 'partials.lists.no-items')
    </div>
</div>


@endsection
