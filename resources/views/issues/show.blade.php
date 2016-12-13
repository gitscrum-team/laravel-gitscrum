@section('title',  trans('Issue - ') . $issue->title)

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>
        @include('partials.includes.breadcrumb-sprint', ['obj'=>$issue->sprint])
        @if(isset($issue->userStory->slug))
        <a href="{{route('user_stories.show', ['slug'=>$issue->userStory->slug])}}">{{trans('User Story')}}</a> &raquo;
        @endif
        {{trans('Issue')}}</h3>
</div>
<div class="col-lg-6 text-right">
    @include('partials.lnk-favorite', ['favorite' => $issue->favorite, 'type' => 'issue',
        'id' => $issue->id, 'btnSize' => 'btn-sm font-bold', 'text' => trans('Favorite')])
    &nbsp;&nbsp;
    <div class="btn-group">
        <a href="{{route('issues.edit', ['slug' => $issue->slug])}}"
            class="btn btn-sm btn-primary"
            data-toggle="modal" data-target="#modalLarge">
            <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('Edit Issue')}}</a>
        <a href="{{route('issues.destroy', ['slug' => $issue->slug])}}"
            class="btn btn-sm btn-default">
            <i class="fa fa-trash" aria-hidden="true"></i></a>
    </div>
</div>
@endsection

@section('content')
    <div class="col-lg-4">

        <div class="">
        @foreach ($configStatus as $status)
            <a href="{{route('issues.status.update', ['slug' => $issue->slug,
                'status' => $status->id])}}" class="font-bold btn btn-w-m
                @if($status->id==$issue->config_status_id) btn-success @else btn-default @endif
                    btn-block" style="border-left:10px solid #{{$status->color}}"
                    type="button">{{$status->title}}</a>
        @endforeach
        </div>

        @if ( $issue->closed_at )
            <a href="{{route('issues.create', ['slug' => $issue->slug])}}"
                class="mtl mbl btn btn-block btn-danger"
                type="button">{{trans('Defect Detected')}}</a>
        @endif

        <div class="mtl">

            @include('partials.boxes.label', ['title' => 'Assign Labels', 'route' => 'user_issue.update',
                'slug' => $issue->slug, 'list' => $issue->labels, 'type' => 'issue', 'id' => $issue->id ])

            @include('partials.boxes.note', [ 'list' => $issue,
                'type'=> 'issue', 'title' => trans('Definition of Done Checklist'),
                'percentage' => Helper::percentage($issue, 'notes')])

            @include('partials.boxes.attachment', ['id'=>$issue->id, 'type'=>'issue', 'list' => $issue->attachments])

            <h6>{{trans('Assigned to')}}
                <span class="pull-right">
                    <a href="" class="btn btn-primary btn-xs">{{trans('Add Member')}}</a>
                </span>
            </h6>

            <div class="form-group">
                <form action="{{route('user_issue.update', ['slug'=>$issue->slug])}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-lg-12">
                        <div class="row">
                            @include('partials.select-issue-assigned', ['usersByOrganization' => $usersByOrganization])
                            <div class="">
                                <button type="submit" class="btn btn-xs btn-primary pull-right" role="button">{{trans('Confirm')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="clearfix"></div>
            <div class="user-friends m-t-sm">
                @each('partials.lists.users-min', $issue->users, 'user', 'partials.lists.no-items')
            </div>

        </div>
    </div>

    <div class="col-lg-8">

        <h3 class="lead mtn ptn">
            @if( isset($issue->sprint->slug) )
            <a href="{{route('issue_types.index', ['sprint_slug' => $issue->sprint->slug,
                'type_slug' => $issue->type->slug])}}">
            @else
            <a href="{{route('issue_types.index', ['sprint_slug' => '0',
                    'type_slug' => $issue->type->slug])}}">
            @endif

                <span class="label label-danger pull-right"
                    style="font-size:16px;margin-top:3px;background-color:#{{$issue->type->color}}">
                    {{$issue->type->title}}</span></a>

                <span class="label label-warning pull-right mrm"
                    style="font-size:16px;margin-top:3px;">
                    Effort: {{$issue->configEffort->title}}</span>

                <span @if ( $issue->closed_at ) style="text-decoration: line-through;" @endif>
                    {{$issue->title}}</span>

        </h3>

        @if($issue->number)
        <h6 class="text-muted pbn">{{trans('Use this code on commit')}}: <strong>#{{$issue->number}}</strong></h6>
        @endif

        <p class="mbl">{!! nl2br(e($issue->description)) !!}</p>

        <p class="mbn pbn">
            {{trans('Author')}}: <a href="{{route('user.profile', ['username' => $issue->user->username])}}">
                <strong>{{$issue->user->username}}</strong></a>
        </p>

        <p class="mbn pbn">
            {{trans('Sprint Backlog')}}:
            @if( isset($issue->sprint->title) )
                <a href="{{route('sprints.show', ['slug' => @$issue->sprint->slug])}}">
                {{$issue->sprint->title}}</a>
            @else
                <span class="text-muted">{{trans('Undefined')}}</span>
            @endif
        </p>

        <p class="">
            {{trans('User Story')}}:
            @if( isset($issue->userStory) )
            <a href="{{route('user_stories.show', ['slug' => $issue->userStory->slug])}}">
                {{$issue->userStory->title}}</a>
            @else
                <span class="text-muted">{{trans('Undefined')}}</span>
            @endif
        </p>

        @if ( $issue->closed_at )
        <p class="text-danger">
            <strong>{{trans('Closed')}} {{trans('by')}}
                <a href="{{route('user.profile', ['username' => $issue->closedUser->username])}}">
                {{$issue->closedUser->username}}</a>: {{$issue->dateforhumans('closed_at')}}</strong>
        </p>
        @endif

        <div class="clearfix"></div>

        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-comments">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    {{trans('Comments')}} ({{$issue->comments->count()}})</a></li>
                <li class=""><a data-toggle="tab" href="#tab-commits"> {{trans('Commits')}} ({{$issue->commits->count()}})</a></li>
                <li class=""><a data-toggle="tab" href="#tab-activities">
                    <i class="fa fa-rss" aria-hidden="true"></i>
                    {{trans('Activities')}}</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-comments" class="tab-pane active">
                    <div class="panel-body">
                        @include('partials.forms.comment', ['id'=>$issue->id, 'type'=>'issue'])
                        @each('partials.lists.comments', $issue->comments, 'comment', 'partials.lists.no-items')
                    </div>
                </div>
                <div id="tab-commits" class="tab-pane">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Message</th>
                                <th>Branch</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @each('partials.lists.table-commits', $issue->commits, 'commit', 'partials.lists.no-items')
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="tab-activities" class="tab-pane">
                    <div class="panel-body">
                        <div class="feed-activity-list">
                            @each('partials.lists.activities', $issue->statuses, 'activity', 'partials.lists.no-items')
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
