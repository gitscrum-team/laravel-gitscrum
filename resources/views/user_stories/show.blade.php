@section('title',  _('User Story'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3 class="ptn mtn mbn pbn">{{_('User Story')}}</h3>
</div>
<div class="col-lg-6 text-right">
    @include('partials.lnk-favorite', ['favorite' => $userStory->favorite, 'type' => 'user_story',
        'id' => $userStory->id, 'btnSize' => 'btn-sm font-bold', 'text' => _('Favorite')])
    &nbsp;&nbsp;
    <div class="btn-group">
        <a href="{{route('user_stories.edit', ['slug' => $userStory->slug])}}"
            class="btn btn-sm btn-primary"
            data-toggle="modal" data-target="#modalLarge">
            <i class="fa fa-pencil" aria-hidden="true"></i> {{_('Edit User Story')}}</a>
        <a href="{{route('user_stories.edit', ['slug' => $userStory->slug])}}"
            class="btn btn-sm btn-default">
            <i class="fa fa-trash" aria-hidden="true"></i></a>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-4">

    <div class="">
        <a href="{{route('issues.create', ['slug_sprint' => '-', 'slug_user_story' => $userStory->slug])}}"
            class="btn btn-block btn-primary"
            data-toggle="modal" data-target="#modalLarge">
            {{_('Create Issue')}}</a>
    </div>

    <div class="">
        @include('partials.boxes.chart-donut', ['list'=>$userStory->issueStatus()])
    </div>

    @include('partials.boxes.label', ['title' => 'Assign Labels', 'route' => 'user_issue.update',
        'slug' => $userStory->slug, 'list' => $userStory->labels, 'type' => 'user_story', 'id' => $userStory->id ])

    @include('partials.boxes.note', [ 'list' => $userStory,
        'type'=> 'user_story', 'title' => _('Definition of Done Checklist'),
        'percentage' => $userStory->notesPercentComplete()])

    @include('partials.boxes.team', ['title' => 'Team Members', 'list' => $userStory->issuesHasUsers(12)])

</div>

<div class="col-lg-8">

    <h3 class="lead mtn ptn"><span class="label label-danger pull-right" style="font-size:16px;margin-top:3px;background-color:#{{$userStory->priority->color}}">
        {{$userStory->priority->title}}</span>{{$userStory->title}}</h3>
    <p class="m-b-md small">
        {{_('Product Backlog')}}: <a href="{{route('product_backlogs.show', ['slug' => $userStory->productBacklog->slug])}}">
            <strong>{{$userStory->productBacklog->title}}</strong></a>
    </p>
    <p class="">{!! nl2br(e($userStory->description)) !!}</p>

    @if ( $userStory->acceptance_criteria )
    <br />
    <h6 class="mbn pbn">{{_('Acceptance criteria')}}</h6>
    <p class="">{!! nl2br(e($userStory->acceptance_criteria)) !!}</p>
    @endif

    <div class="">
        @include('partials.boxes.progress-bar', [ 'percentage' => $userStory->getPercentcomplete()])
    </div>

<div class="tabs-container">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-issues"> {{_('Issues')}} ({{$userStory->issues->count()}}) </a></li>
        <li class=""><a data-toggle="tab" href="#tab-comments"> {{_('Comments')}} ({{$userStory->comments->count()}}) </a></li>
        <li class=""><a data-toggle="tab" href="#tab-activities"> {{_('Activities')}} </a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-issues" class="tab-pane active">
            <div class="panel-body">

                <div class="project-list">

                    <table class="table table-hover issue-tracker">
                        <tbody>
                        @each('partials.lists.issues', $userStory->issues, 'list', 'partials.lists.no-items')
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
        <div id="tab-comments" class="tab-pane">
            <div class="panel-body">
                <div class="row">
                    <div class="social-footer">
                        <div class="social-comment">
                            @include('partials.forms.comment', ['id'=>$userStory->id, 'type'=>'user_story'])
                        </div>
                    </div>
                </div>
                <div class="feed-activity-list">
                    @each('partials.lists.comments', $userStory->comments, 'comment', 'partials.lists.no-items')
                </div>
            </div>
        </div>
        <div id="tab-activities" class="tab-pane ">
            <div class="panel-body">
                <div class="feed-activity-list">
                    @each('partials.lists.activities-complete', $userStory->activities(), 'activity', 'partials.lists.no-items')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
