@section('title',  trans('Dashboard'))

@extends('layouts.master', ['bodyClass' => 'body-dashboard'])

@section('breadcrumb')

<div class="col-lg-6">
    <h3>{{trans('Dashboard')}}</h3>
</div>

<div class="col-lg-6 text-right">
    <div class="btn-group">
        <a href="{{route('wizard.step1')}}" class="btn btn-sm btn-primary">
            {{trans('Update Repositories')}}</a>
    </div>
</div>

@endsection

@section('content')


<div class="col-md-4">

    <div class="row">
        <div class="col-lg-12">
            @include('partials.boxes.team', ['list'=>$user->team(), 'title'=>trans('My Team')])
        </div>

        <div class="col-lg-6 col-sm-12 mtl">
            <div class="tile">
                <i class="fa fa-trophy fa-4x" aria-hidden="true"></i>
                <h3 class="tile-title mtm">62</h3>
                <p>Effort</p>
                <a class="btn btn-primary btn-large btn-block" href="#">My Activities</a>
            </div>
        </div>

        <div class="col-lg-6 col-sm-12 mtl">
            <div class="tile">
                <i class="fa fa-th fa-4x" aria-hidden="true"></i>
                <h3 class="tile-title mtm">{{$user->issues()->count()}}</h3>
                <p>{{trans('Issues')}}</p>
                <a class="btn btn-primary btn-large btn-block"
                    href="{{route('issues.index',['slug' => 0])}}">
                    {{trans('My Planning')}}</a>
            </div>
        </div>

        <div class="col-lg-12">

            <div class="tile tile-sprint">
                <h3 class="tile-title mtm">{{trans('Sprints')}}</h3>
                @foreach ($sprints as $key => $sprint)
                <div class="">
                    <a href="{{route('sprints.show', ['slug'=>$sprint->slug])}}">
                        <strong>{{$sprint->title}}</strong>
                        <span>{{$sprint->timebox}}
                        ({{Helper::percentage($sprint, 'issues')}}% {{trans('completed')}})</span></a>
                    <div class="progress">
                        <div class="progress-bar" style="width: {{Helper::percentage($sprint, 'issues')}}%;"></div>
                    </div>
                </div>
                @endforeach
            </div>

            @include('partials.boxes.note', [ 'list' => Auth::user(),
                'type'=> 'user', 'title' => trans('My Notes'),
                'percentage' => Helper::percentage($user, 'notes')])

        </div>
    </div>
</div>

<div class="col-lg-8">

    @include('partials.boxes.burndown', ['title' => trans('My'), 'list' => Helper::burndown($user, 5)])

    <div class="mtl">
        <table class="table table-hover issue-tracker">
            <tbody>
            @each('partials.lists.issues', $user->issues->where('closed_at', null), 'list', 'partials.lists.no-items')
            </tbody>
        </table>
    </div>
</div>

@endsection
