@section('title',  trans('gitscrum.sprint-backlog'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>
        @if(isset($sprint->productBacklog->slug))
        <a href="{{route('product_backlogs.show', ['slug'=>$sprint->productBacklog->slug])}}">{{trans('gitscrum.product-backlog')}}</a> &raquo;
        @endif
        <span>{{trans('gitscrum.sprint-backlog')}}</span></h3>
</div>
<div class="col-lg-6 text-right">
    @include('partials.lnk-favorite', ['favorite' => $sprint->favorite, 'type' => 'sprints',
        'id' => $sprint->id, 'btnSize' => 'btn-sm font-bold', 'text' => trans('gitscrum.favorite')])
    <a href="{{route('sprints.edit', ['slug'=>$sprint->slug])}}"
        class="btn btn-sm btn-primary"
        data-toggle="modal" data-target="#modalLarge">
        <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('gitscrum.edit-sprint-backlog')}}</a>
    <form action="{{route('sprints.destroy')}}" method="POST" class="form-delete pull-right">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE" />
        <input type="hidden" name="slug" value="{{$sprint->slug}}" />
        <button class="btn btn-sm btn-default" type="submit">
            <i class="fa fa-trash" aria-hidden="true"></i>
        </button>
    </form>
</div>
@endsection

@section('main-title')
<span class="label label-default">{{$sprint->visibility}}</span>
<span @if( isset($sprint->closed_at) ) style="text-decoration: line-through;" @endif>
    {{$sprint->title}}</span>

<div class="btn-group pull-right">
        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" style="background-color:#{{$sprint->status->color}}">
            <strong>{{$sprint->status->title}}</strong>
            &nbsp;
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            @foreach ($configStatus as $value)
                @if($value->is_closed)
                    <li role="separator" class="divider"></li>
                @endif
            <li><a href="{{route('sprints.status.update', ['slug'=>$sprint->slug, 'status'=>$value->id])}}">
                {{$value->title}}</a></li>
            @endforeach
        </ul>
</div>
@endsection

@section('content')
<div class="col-lg-4">

    <a href="{{route('issues.index', ['slug'=>$sprint->slug])}}"
        class="btn btn-lg btn-block btn-warning"><strong>{{trans('gitscrum.sprint-planning')}}</strong></a>

    <a href="{{route('issues.create', ['scope' => 'Sprint', 'slug' => $sprint->slug])}}"
        class="btn btn-block btn-primary"
        data-toggle="modal" data-target="#modalLarge"><strong>{{trans('gitscrum.create-issue')}}</strong></a>

    @include('partials.boxes.chart-donut', ['list' => $sprint->issueStatus()])

    <div class="">
        @include('partials.boxes.progress-bar', [ 'percentage' => Helper::percentage($sprint, 'issues')])
    </div>

    <table class="table small m-b-xs">
        <tbody>
        <tr>
            <td width="50%">
                <h6>{{$sprint->effort()->sum('effort')}} {{trans('gitscrum.effort')}}</h6>
            </td>
            <td width="50%">
                <h6>{{$sprint->effort()->avg('effort')}} {{trans('gitscrum.effort-avg')}}</h6>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <h6>{{$sprint->issues->count()}} {{trans('gitscrum.issues')}}</h6>
            </td>
            <td width="50%"></td>
        </tr>
        </tbody>
    </table>

    @include('partials.boxes.issue-type', ['list' => $sprint->issueTypes()])

    @include('partials.boxes.note', [ 'list' => $sprint,
        'type'=> 'sprints', 'title' => trans('gitscrum.definition-of-done-checklist'),
        'percentage' => Helper::percentage($sprint, 'notes')])

    @include('partials.boxes.attachment', ['id' => $sprint->id, 'type' => 'sprints', 'list' => $sprint->attachments])

    @include('partials.boxes.team', ['title' => 'Team Members', 'list' => $sprint->issuesHasUsers()])

</div>

<div class="col-lg-8">

    <div class="well">

        <h4>{{trans('gitscrum.date')}}: {{$sprint->date_start}} {{trans('gitscrum.to')}} {{$sprint->date_finish}}</h4>

        <p>{{$sprint->scopeWorkingDays(date('Y-m-d'))}} {{trans('gitscrum.missing-day')}} /
            {{$sprint->scopeWorkingDays(date('Y-m-d'))}} {{trans('gitscrum.workdays')}}
            ( {{$sprint->scopeWeeks(date('Y-m-d'))}} {{trans('gitscrum.week')}} )</p>

        <p class="">
            {{trans('gitscrum.product-backlog')}}: <a href="{{route('product_backlogs.show', ['slug' =>
            $sprint->productBacklog->slug])}}">
            <strong>{{$sprint->productBacklog->title}}</strong></a>
        </p>

    </div>

    @if(!empty($sprint->description))
    <p class="description">
        <small>{{trans('gitscrum.description')}}</small>
        <span>{!! nl2br(e($sprint->description)) !!}</span>
    </p>
    @endif

    @include('partials.boxes.burndown', ['title' => ('Burndown Chart'), 'list' => Helper::burndown($sprint)])

    <div class="clearfix"></div>

    <div class="tabs-container mtl">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-issues">
                <i class="fa fa-list-alt" aria-hidden="true"></i>
                {{trans('gitscrum.issues')}} ({{$sprint->issues->count()}})</a></li>
            <li class=""><a data-toggle="tab" href="#tab-comments">
                <i class="fa fa-comments" aria-hidden="true"></i>
                {{trans('gitscrum.comments')}} ({{$sprint->comments->count()}})</a></li>
            <li><a data-toggle="tab" href="#tab-activities">
                <i class="fa fa-rss" aria-hidden="true"></i>
                {{trans('gitscrum.activities')}}</a></li>
        </ul>

        <div class="tab-content">
            <div id="tab-issues" class="tab-pane active">
                <div class="panel-body">
                    @include('partials.boxes.search-min')
                    @include('partials.boxes.issue', ['list' => $sprint->issues, 'messageEmpty' => trans('gitscrum.this-does-not-have-any-issue-yet')])
                </div>
            </div>
            <div id="tab-comments" class="tab-pane">
                <div class="panel-body">
                    @include('partials.forms.comment', ['id'=>$sprint->id, 'type'=>'sprints'])
                    @each('partials.lists.comments', $sprint->comments, 'comment', 'partials.lists.no-items')
                </div>
            </div>
            <div id="tab-activities" class="tab-pane ">
                <div class="panel-body">
                    <div class="feed-activity-list">
                        @each('partials.lists.activities-complete', $sprint->activities(), 'activity', 'partials.lists.no-items')
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
