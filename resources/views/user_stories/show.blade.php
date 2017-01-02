@section('title',  trans('User Story'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>
        @if(isset($userStory->productBacklog->slug))
        <a href="{{route('product_backlogs.show', ['slug'=>$userStory->productBacklog->slug])}}">{{trans('Product Backlog')}}</a> &raquo;
        @endif
        {{trans('User Story')}}</h3>
</div>
<div class="col-lg-6 text-right">
    @include('partials.lnk-favorite', ['favorite' => $userStory->favorite, 'type' => 'user_story',
        'id' => $userStory->id, 'btnSize' => 'btn-sm font-bold', 'text' => trans('Favorite')])

    <a href="{{route('user_stories.edit', ['slug' => $userStory->slug])}}"
        class="btn btn-sm btn-primary"
        data-toggle="modal" data-target="#modalLarge">
        <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('Edit User Story')}}</a>

    <form action="{{route('user_stories.destroy')}}" method="POST" class="form-delete pull-right">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE" />
        <input type="hidden" name="slug" value="{{$userStory->slug}}" />
        <button class="btn btn-sm btn-default" type="submit">
            <i class="fa fa-trash" aria-hidden="true"></i></a>
        </button>
    </form>
</div>
@endsection

@section('main-title')
<span class="label label-danger"
     style="background-color:#{{$userStory->priority->color}}">
        {{$userStory->priority->title}}</span>
<span>{{$userStory->title}}</span>
@endsection

@section('content')
<div class="col-lg-4">

    <div class="mb20">
        <a href="{{route('issues.create', ['slug_sprint' => '0', 'slug_user_story' => $userStory->slug])}}"
            class="btn btn-block btn-primary"
            data-toggle="modal" data-target="#modalLarge">
            {{trans('Create Issue')}}</a>
    </div>

    <div class="">
        @include('partials.boxes.chart-donut', ['list'=>$userStory->issueStatus()])
    </div>

    @include('partials.boxes.label', ['title' => 'Assign Labels', 'route' => 'user_issue.update',
        'slug' => $userStory->slug, 'list' => $userStory->labels, 'type' => 'user_story', 'id' => $userStory->id ])

    @include('partials.boxes.note', [ 'list' => $userStory,
        'type'=> 'user_story', 'title' => trans('Definition of Done Checklist'),
        'percentage' => Helper::percentage($userStory, 'notes')])

    @include('partials.boxes.team', ['title' => 'Team Members', 'list' => $userStory->issuesHasUsers(12)])

</div>

<div class="col-lg-8">

    <div class="well">
        <p>
            {{trans('Product Backlog')}}: <a href="{{route('product_backlogs.show', ['slug' => $userStory->productBacklog->slug])}}">
                <strong>{{$userStory->productBacklog->title}}</strong></a>
        </p>
    </div>

    @if(!empty($productBacklog->description))
    <p class="description">
        <small>{{trans('Additional information')}}</small>
        <span>{!! nl2br(e($userStory->description)) !!}<span>
    </p>
    @endif

    @if ( $userStory->acceptance_criteria )
    <p class="description">
        <small>{{trans('Acceptance criteria')}}</small>
        <span>{!! nl2br(e($userStory->acceptance_criteria)) !!}</span>
    </p>
    @endif

    <div class="mb35">
        @include('partials.boxes.progress-bar', [ 'percentage' => Helper::percentage($userStory, 'issues')])
    </div>

<div class="tabs-container">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#tab-issues"> {{trans('Issues')}} ({{$userStory->issues->count()}}) </a></li>
        <li class=""><a data-toggle="tab" href="#tab-comments"> {{trans('Comments')}} ({{$userStory->comments->count()}}) </a></li>
        <li class=""><a data-toggle="tab" href="#tab-activities"> {{trans('Activities')}} </a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-issues" class="tab-pane active">
            <div class="panel-body">
                @include('partials.boxes.issue', ['list' => $userStory->issues, 'messageEmpty' => trans('This does not have any issue yet')])
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
