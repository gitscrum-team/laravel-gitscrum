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

    <a href="{{route('issues.edit', ['slug' => $issue->slug])}}"
        class="btn btn-sm btn-primary"
        data-toggle="modal" data-target="#modalLarge">
        <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('Edit Issue')}}</a>

    <form action="{{route('issues.destroy')}}" method="POST" class="form-delete pull-right">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE" />
        <input type="hidden" name="slug" value="{{$issue->slug}}" />
        <button class="btn btn-sm btn-default" type="submit">
            <i class="fa fa-trash" aria-hidden="true"></i></a>
        </button>
    </form>
</div>
@endsection

@section('main-title')

<span class="label label-warning mrm">
    Effort: {{$issue->configEffort->title}}</span>
<span @if ( $issue->closed_at ) style="text-decoration: line-through;" @endif>
    {{$issue->title}}</span>
<a href="{{route('issue_types.index', ['sprint_slug' => $issue->sprintSlug,
    'type_slug' => $issue->type->slug])}}" class="pull-right">
    <span class="label" style="background-color:#{{$issue->type->color}}">
    {{$issue->type->title}}</span></a>

@endsection

@section('content')

<div class="col-lg-4">

    @if(is_null($issue->sprintClosed))
        <ul class="mb20 list-issue-config-status">
        @foreach ($issue->statusAvailable as $status)
            <li>
                <a href="{{route('issues.status.update', ['slug' => $issue->slug,
                    'status' => $status->id])}}" class="font-bold btn
                    @if($status->id==$issue->config_status_id) btn-success @else btn-default @endif
                        btn-block" style="border-left:10px solid #{{$status->color}}"
                        type="button">{{$status->title}}</a>
            </li>
        @endforeach
        </ul>
    @else
        <div class="mb20">
            <button class="font-bold btn btn-success btn-block" style="border-left:10px solid #{{$issue->status->color}}"
                    type="button">{{$issue->status->title}}</button>
        </div>

        @include('errors.notification-message', ['notification' => ['message' => trans('This issue is in a sprint that is ').
            '<strong>'.$issue->sprint->status->title.'</strong>.'.
            '<p><a href="'.route('sprints.show', ['slug'=>$issue->sprint->slug]).'" class="font-bold"></p>'.
            trans('Change Sprint Status') . '</a>',
            'alert' => 'info', 'class' => 'padding-none show-sprint-issue']])
    @endif

    @if ( $issue->closed_at )
        <a href="{{route('issues.create', ['slug_sprint'=>0, 'slug_user_story'=>0, 'parent_id' => $issue->id])}}"
            class="btn btn-block btn-danger mb20"
            data-toggle="modal" data-target="#modalLarge"
            type="button">{{trans('Defect Detected')}}</a>
    @endif

    <div class="mtl">

        @include('partials.boxes.label', ['title' => 'Assign Labels', 'route' => 'user_issue.update',
            'slug' => $issue->slug, 'list' => $issue->labels, 'type' => 'issue', 'id' => $issue->id ])

        @include('partials.boxes.note', [ 'list' => $issue,
            'type'=> 'issue', 'title' => trans('Definition of Done Checklist'),
            'percentage' => Helper::percentage($issue, 'notes')])

        @include('partials.boxes.attachment', ['id'=>$issue->id, 'type'=>'issue', 'list' => $issue->attachments])

        <h4>{{trans('Assigned to')}}
            <span class="pull-right">
                <a href="" class="btn btn-primary btn-xs">{{trans('Add Member')}}</a>
            </span>
        </h4>

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
        <div class="user-friends">
            @each('partials.lists.users-min', $issue->users, 'user', 'partials.lists.no-items')
        </div>

    </div>
</div>

<div class="col-lg-8">

    <div class="well">
        @if($issue->number)
        <h6 class="text-muted pbn">{{trans('Use this code on commit')}}: <strong>#{{$issue->number}}</strong></h6>
        @endif

        <p>
            {{trans('Author')}}: <a href="{{route('user.profile', ['username' => $issue->user->username])}}">
                <strong>{{$issue->user->username}}</strong></a>
        </p>

        <p>
            {{trans('Sprint Backlog')}}:
            @if( isset($issue->sprint->title) )
                <a href="{{route('sprints.show', ['slug' => @$issue->sprint->slug])}}">
                {{$issue->sprint->title}}</a>
            @else
                <span class="text-muted">{{trans('Undefined')}}</span>
            @endif
        </p>

        <p>
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

    </div>

    @if(!empty($issue->description))
    <p class="description">
        <small>{{trans('Description')}}</small>
        <span>{!! nl2br(e($issue->description)) !!}<span>
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
