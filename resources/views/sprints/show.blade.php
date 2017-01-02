@section('title',  trans('Sprint Backlog'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>
        @if(isset($sprint->productBacklog->slug))
        <a href="{{route('product_backlogs.show', ['slug'=>$sprint->productBacklog->slug])}}">{{trans('Product Backlog')}}</a> &raquo;
        @endif
        <span>{{trans('Sprint Backlog')}}</span></h3>
</div>
<div class="col-lg-6 text-right">
    @include('partials.lnk-favorite', ['favorite' => $sprint->favorite, 'type' => 'sprint',
        'id' => $sprint->id, 'btnSize' => 'btn-sm font-bold', 'text' => trans('Favorite')])
    <a href="{{route('sprints.edit', ['slug'=>$sprint->slug])}}"
        class="btn btn-sm btn-primary"
        data-toggle="modal" data-target="#modalLarge">
        <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('Edit Sprint Backlog')}}</a>
    <form action="{{route('sprints.destroy')}}" method="POST" class="form-delete pull-right">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE" />
        <input type="hidden" name="slug" value="{{$sprint->slug}}" />
        <button class="btn btn-sm btn-default" type="submit">
            <i class="fa fa-trash" aria-hidden="true"></i></a>
        </button>
    </form>
</div>
@endsection

@section('main-title')
<span class="label label-default">{{$sprint->visibility}}</span>
<span @if ( $sprint->closed_at ) style="text-decoration: line-through;" @endif>
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
        class="btn btn-lg btn-block btn-warning"><strong>{{trans('Sprint Planning')}}</strong></a>

    <a href="{{route('issues.create', ['slug'=>$sprint->slug])}}"
        class="btn btn-block btn-primary"
        data-toggle="modal" data-target="#modalLarge"><strong>{{trans('Create Issue')}}</strong></a>

    @include('partials.boxes.chart-donut', ['list' => $sprint->issueStatus()])

    <div class="">
        @include('partials.boxes.progress-bar', [ 'percentage' => Helper::percentage($sprint, 'issues')])
    </div>

    <table class="table small m-b-xs">
        <tbody>
        <tr>
            <td width="50%">
                <h6>{{$sprint->getEffort()}} {{trans('effort')}}</h6>
            </td>
            <td width="50%">
                <h6>{{$sprint->getEffortAvg()}} {{trans('effort avg.')}}</h6>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <h6>{{$sprint->issues->count()}} {{trans('issues')}}</h6>
            </td>
            <td width="50%"></td>
        </tr>
        </tbody>
    </table>

    <!--
    <div class="row m-t-sm">
        <div class="col-xs-4">
            <small class="stats-label">Additions</small>
            <h4>{{$sprint->totalAdditions()}}</h4>
        </div>
        <div class="col-xs-4">
            <small class="stats-label">PSR-2 Errors</small>
            <h4>{{$sprint->getPSR2Errors()}}</h4>
        </div>
        <div class="col-xs-4">
            <small class="stats-label">Bugs %</small>
            <h4>76.43%</h4>
        </div>
    </div>
    -->

    @include('partials.boxes.issue-type', ['list' => $sprint->issueTypes()])

    @include('partials.boxes.note', [ 'list' => $sprint,
        'type'=> 'sprint', 'title' => trans('Definition of Done Checklist for Sprint'),
        'percentage' => Helper::percentage($sprint, 'notes')])

    @include('partials.boxes.attachment', ['id' => $sprint->id, 'type' => 'sprint', 'list' => $sprint->attachments])

    @include('partials.boxes.team', ['title' => 'Team Members', 'list' => $sprint->issuesHasUsers()])

</div>

<div class="col-lg-8">

    <div class="well">

        <h4>{{trans('Date')}}: {{$sprint->date_start}} {{trans('to')}} {{$sprint->date_finish}}</h4>

        <p>{{$sprint->workingDays(date('Y-m-d'))}} {{str_plural('missing day', $sprint->workingDays(date('Y-m-d')))}} /
            {{$sprint->workingDays()}} {{str_plural('workdays', $sprint->workingDays())}}
            ( {{$sprint->weeks()}} {{str_plural('week', $sprint->weeks())}} )</p>

        <p class="">
            {{trans('Product Backlog')}}: <a href="{{route('product_backlogs.show', ['slug' => $sprint->productBacklog->slug])}}">
            <strong>{{$sprint->productBacklog->title}}</strong></a>
        </p>

    </div>

    @if(!empty($sprint->description))
    <p class="description">
        <small>{{trans('Description')}}</small>
        <span>{!! nl2br(e($sprint->description)) !!}<span>
    </p>
    @endif

    @include('partials.boxes.burndown', ['title' => ('Burndown Chart'), 'list' => Helper::burndown($sprint)])

    <div class="clearfix"></div>

        <div class="tabs-container mtl">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-issues">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    {{trans('Issues')}} ({{$sprint->issues->count()}})</a></li>
                <li class=""><a data-toggle="tab" href="#tab-comments">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    {{trans('Comments')}} ({{$sprint->comments->count()}})</a></li>
                <li><a data-toggle="tab" href="#tab-activities">
                    <i class="fa fa-rss" aria-hidden="true"></i>
                    {{trans('Activities')}}</a></li>
            </ul>

            <div class="tab-content">
                <div id="tab-issues" class="tab-pane active">
                    <div class="panel-body">
                        @include('partials.boxes.search-min')
                        @include('partials.boxes.issue', ['list' => $sprint->issues, 'messageEmpty' => trans('This does not have any issue yet')])
                    </div>
                </div>
                <div id="tab-comments" class="tab-pane">
                    <div class="panel-body">
                        @include('partials.forms.comment', ['id'=>$sprint->id, 'type'=>'sprint'])
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
</div>

@endsection
