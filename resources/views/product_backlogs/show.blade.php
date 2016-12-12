@section('title',  trans('Product Backlog'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>{{trans('Product Backlog')}}</h3>
</div>
<div class="col-lg-6 text-right">
    @include('partials.lnk-favorite', ['favorite' => $productBacklog->favorite, 'type' => 'product_backlog',
        'id' => $productBacklog->id, 'btnSize' => 'btn-sm font-bold', 'text' => trans('Favorite')])
    &nbsp;&nbsp;
    <div class="btn-group">
        <a href="{{route('product_backlogs.edit', ['slug' => $productBacklog->slug])}}"
            class="btn btn-sm btn-primary"
            data-toggle="modal" data-target="#modalLarge">
            <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('Edit Product Backlog')}}</a>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-4">

    <a href="{{route('user_stories.create', ['slug_user_story' => $productBacklog->slug])}}"
        class="btn btn-block btn-primary"
        data-toggle="modal" data-target="#modalLarge">{{trans('Create User Story')}}</a>
    <a href="{{route('sprints.create', ['slug_product_backlog' => $productBacklog->slug])}}"
        class="btn  btn-block btn-primary"
        data-toggle="modal" data-target="#modalLarge">
        {{trans('Create Sprint')}}</a>

    <hr />

    @include('partials.boxes.note', [ 'list' => $productBacklog, 'type'=> 'product_backlog',
        'title' => 'Notes', 'percentage' => Helper::percentage($productBacklog, 'notes')])

    @include('partials.boxes.attachment', ['id'=>$productBacklog->id, 'type'=>'product_backlog', 'list' => $productBacklog->attachments])

</div>

<div class="col-lg-8">

    <h3 class="lead mtn ptn pbl">{{$productBacklog->title}}</h3>

    <div class="well">
        <h6>{{trans('Clone using ssh or https')}}</h6>
        <p><strong>SSH</strong>: {{$productBacklog->ssh_url}}</p>
        <p><strong>HTTPS</strong>: {{$productBacklog->clone_url}}</p>
    </div>

    <p class="mtn ptn pbl">{!! nl2br(e($productBacklog->description)) !!}</p>

    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-userStories">{{trans('User Stories')}} ({{$productBacklog->userStories->count()}})</a></li>
            <li class=""><a data-toggle="tab" href="#tab-sprints">{{trans('Sprint Backlogs')}} ({{$productBacklog->sprints->count()}})</a></li>
            <li class=""><a data-toggle="tab" href="#tab-comments">{{trans('Comments')}} ({{$productBacklog->comments->count()}})</a></li>
            <li class=""><a data-toggle="tab" href="#tab-branches">{{trans('Branches')}} ({{$productBacklog->branches->count()}})</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-userStories" class="tab-pane active">
                <div class="panel-body">

                    @include('partials.boxes.search-min', [ 'query' => 'user_story', 'search' => $search,
                        'route' => route('product_backlogs.show', ['slug' => $productBacklog->slug]), 'txtSearch' => 'Search by user stories' ])
                    @include('partials.boxes.user-story', [ 'list' => $userStories ])

                </div>
            </div>
            <div id="tab-sprints" class="tab-pane">
                <div class="panel-body">
                    @include('partials.boxes.search-min', ['txtSearch' => 'Search by sprint backlogs'])
                    @include('partials.boxes.sprint', [ 'list' => $sprints ])
                </div>
            </div>
            <div id="tab-comments" class="tab-pane">
                <div class="panel-body">
                    @include('partials.forms.comment', ['id'=>$productBacklog->id, 'type'=>'product_backlog'])
                    @each('partials.lists.comments', $productBacklog->comments, 'comment', 'partials.lists.no-items')
                </div>
            </div>
            <div id="tab-branches" class="tab-pane">
                <div class="panel-body">

                    @include('partials.boxes.branch', [ 'list' => $productBacklog->branches ])

                </div>
            </div>
        </div>


    </div>

</div>
@endsection
