@section('title',  _('Issue - ') . $issue->title)

@extends('layouts.master')

@section('breadcrumb')

<div class="page-heading">
    <div class="col-lg-6">
        <h2>{{_('Issue')}}</h2>
    </div>
    <div class="col-lg-6 text-right">
        @include('partials.lnk-favorite', ['favorite' => $issue->favorite, 'type' => 'issue',
            'id' => $issue->id, 'btnSize' => 'btn-sm font-bold', 'text' => _('Favorite')])
        &nbsp;&nbsp;
        <div class="btn-group">
            <a href="{{route('issues.edit', ['slug' => $issue->slug])}}"
                class="btn btn-sm btn-outline btn-primary font-bold" 
                data-toggle="modal" data-target="#modalLarge">
                <i class="fa fa-pencil" aria-hidden="true"></i> {{_('Edit Issue')}}</a>
            <a href="{{route('issues.destroy', ['slug' => $issue->slug])}}"
                class="btn btn-sm btn-outline btn-primary font-bold">
                <i class="fa fa-trash" aria-hidden="true"></i></a>
        </div>
    </div>
</div>

@endsection

@section('content')

<div class="row">

    <div class="col-lg-4">

        <div class="ibox">

            <div class="ibox-content">
                <div class="m-t-sm">
                @foreach ($configStatus as $status)
                    <a href="{{route('issues.status.update', ['slug' => $issue->slug,
                        'status' => $status->id])}}" class="font-bold btn btn-w-m
                        @if($status->id==$issue->config_status_id) btn-success @else btn-default @endif
                            btn-block" style="border-left:10px solid #{{$status->color}}"
                            type="button">{{$status->title}}</a>
                @endforeach
                </div>
            </div>

            @if ( $issue->closed_at )
            <div class="ibox-content">
                <a href="{{route('issues.create', ['slug' => $issue->slug])}}"
                    class="font-bold btn btn-w-m btn-block btn-danger"
                    type="button">{{_('Defect Detected')}}</a>
            </div>
            @endif

            @include('partials.boxes.label', ['title' => 'Assign Labels', 'route' => 'user_issue.update',
                'slug' => $issue->slug, 'list' => $issue->labels, 'type' => 'issue', 'id' => $issue->id ])

            @include('partials.boxes.note', [ 'list' => $issue,
                'type'=> 'issue', 'title' => _('Definition of Done Checklist'),
                'percentage' => $issue->notesPercentComplete()])

            @include('partials.boxes.attachment', ['id'=>$issue->id, 'type'=>'issue', 'list' => $issue->attachments])


            <div class="ibox-content">
                <h3>{{_('Assigned to')}}
                    <span class="pull-right">
                        <a href="" class="btn btn-primary btn-xs">{{_('Add Member')}}</a>
                    </span>
                </h3>
                <div class="form-group">
                    <form action="{{route('user_issue.update', ['slug'=>$issue->slug])}}" method="post">
                        {{ csrf_field() }}
                        <div class="col-lg-12">
                            <div class="row">
                                @include('partials.select-issue-assigned', ['usersByOrganization' => $usersByOrganization])
                                <div class="m-t-sm">
                                    <button type="submit" class="btn btn-xs btn-primary pull-right" role="button">{{_('Confirm')}}</button>
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

    </div>

    <div class="col-lg-8">

        <div class="ibox-content">
            <h2 class="m-b-sm">
                <a href="{{route('issue_types.index', ['sprint_slug' => @$issue->sprint->slug,
                    'type_slug' => $issue->type->slug])}}">
                <span class="label label-danger pull-right"
                style="font-size:16px;margin-top:3px;background-color:#{{$issue->type->color}}">
                {{$issue->type->title}}</span></a>
                <span @if ( $issue->closed_at ) style="text-decoration: line-through;" @endif>
                {{$issue->title}}</span>
            </h2>

            <h5 class="text-muted m-b-md">{{_('Use this code on commit')}}: <strong>#{{$issue->code}}-{{$issue->id}}</strong></h5>

            <p class="m-b-xs small">
                {{_('Author')}}: <a href="{{route('user.profile', ['username' => $issue->user->username])}}">
                    <strong>{{$issue->user->username}}</strong></a>
            </p>

            <p class="m-b-xs small">
                {{_('Sprint Backlog')}}: <a href="{{route('sprints.show', ['slug' => @$issue->sprint->slug])}}">
                    {{@$issue->sprint->title}}</a>
            </p>

            <p class="m-b-xs small">
                {{_('User Story')}}:
                @if( isset($issue->userStory) )
                <a href="{{route('user_stories.show', ['slug' => $issue->userStory->slug])}}">
                    {{$issue->userStory->title}}</a>
                @else
                    <span class="text-muted">{{_('Undefined')}}</span>
                @endif
            </p>

            @if ( $issue->closed_at )
            <p class="m-b-xs text-danger">
                <strong>{{_('Closed')}} {{_('by')}}
                    <a href="{{route('user.profile', ['username' => $issue->closedUser->username])}}">
                        {{$issue->closedUser->username}}</a>: {{$issue->dateforhumans('closed_at')}}</strong>
            </p>
            @endif

            <p class=" m-t-md m-b-none">{!! nl2br(e($issue->description)) !!}</p>

        </div>

        <div class="clearfix"></div>

        <div class="tabs-container m-t-md">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-comments">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    {{_('Comments')}} ({{$issue->comments->count()}})</a></li>
                <li class=""><a data-toggle="tab" href="#tab-commits"> {{_('Commits')}} ({{$issue->commits->count()}})</a></li>
                <li class=""><a data-toggle="tab" href="#tab-activities">
                    <i class="fa fa-rss" aria-hidden="true"></i>
                    {{_('Activities')}}</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-comments" class="tab-pane active">
                    <div class="panel-body">
                        <div class="row">
                            <div class="social-footer">
                                <div class="social-comment">
                                    @include('partials.forms.comment', ['id'=>$issue->id, 'type'=>'issue'])
                                </div>
                            </div>
                        </div>
                        <div class="m-t-md feed-activity-list">
                            @each('partials.lists.comments', $issue->comments, 'comment', 'partials.lists.no-items')
                        </div>
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

</div>

@endsection
