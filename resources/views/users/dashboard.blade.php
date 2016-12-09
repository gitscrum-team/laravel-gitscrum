@section('title',  _('Dashboard'))

@extends('layouts.master')

@section('breadcrumb')

<div class="col-lg-6">
    <h3>{{_('Dashboard')}}</h3>
</div>

<div class="col-lg-6 text-right">
    <div class="btn-group">
        <a href="{{route('wizard.step1')}}" class="btn btn-sm btn-primary">
            {{_('Update Repositories')}}</a>
    </div>
</div>

@endsection

@section('content')

<div class="dashboard-tile">

    <div class="col-lg-3 col-sm-6">
        <div class="tile">
            <i class="fa fa-trophy fa-4x" aria-hidden="true"></i>
            <h3 class="tile-title mtm">62</h3>
            <p>Effort</p>
            <a class="btn btn-primary btn-large btn-block" href="#">My Activities</a>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="tile">
            <i class="fa fa-th fa-4x" aria-hidden="true"></i>
            <h3 class="tile-title mtm">{{$user->issues()->count()}}</h3>
            <p>{{_('Issues')}}</p>
            <a class="btn btn-primary btn-large btn-block"
                href="{{route('issues.index',['slug' => 0])}}">
                {{_('My Planning')}}</a>
        </div>
    </div>

    <div class="col-lg-6 col-sm-12">
        <div class="tile tile-sprint">
            <h3 class="tile-title mtm">{{_('Sprints')}}</h3>
            @foreach ($sprints as $key => $sprint)
            <div class="">
                <a href="{{route('sprints.show', ['slug'=>$sprint->slug])}}">
                    <strong>{{$sprint->title}}</strong>
                    <span>{{$sprint->timebox}}
                    ({{Helper::percentage($sprint, 'issues')}}% {{_('completed')}})</span></a>
                <div class="progress">
                    <div class="progress-bar" style="width: {{Helper::percentage($sprint, 'issues')}}%;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<div class="col-lg-12">

    <table class="table table-hover issue-tracker">
        <tbody>
        @each('partials.lists.issues', $user->issues->where('closed_at', null), 'list', 'partials.lists.no-items')
        </tbody>
    </table>

</div>

@endsection
