@section('title',  trans('gitscrum.product-backlog'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>{{trans('gitscrum.product-backlog')}}</h3>
</div>
<div class="col-lg-6 text-right">
    @include('partials.lnk-favorite', ['favorite' => $productBacklog->favorite, 'type' => 'product_backlogs',
        'id' => $productBacklog->id, 'btnSize' => 'btn-sm font-bold', 'text' => trans('gitscrum.favorite')])

    <a href="{{route('product_backlogs.edit', ['slug' => $productBacklog->slug])}}"
        class="btn btn-sm btn-primary"
        data-toggle="modal" data-target="#modalLarge">
        <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('gitscrum.edit-product-backlog')}}</a>
</div>
@endsection

@section('main-title')
<span>{{$productBacklog->title}}</span>
@endsection

@section('content')
<div class="col-lg-4">

    <a href="{{route('user_stories.create', ['slug_product_backlog' => $productBacklog->slug])}}"
        class="btn btn-block btn-primary"
        data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.create-user-story')}}</a>
    <a href="{{route('sprints.create', ['slug_product_backlog' => $productBacklog->slug])}}"
        class="btn  btn-block btn-primary"
        data-toggle="modal" data-target="#modalLarge">
        {{trans('gitscrum.create-sprint')}}</a>

    <hr />

    @include('partials.boxes.note', [ 'list' => $productBacklog, 'type'=> 'product_backlogs',
        'title' => 'Notes', 'percentage' => Helper::percentage($productBacklog, 'notes')])

    @include('partials.boxes.attachment', ['id'=>$productBacklog->id, 'type'=>'product_backlogs', 'list' => $productBacklog->attachments])

</div>

<div class="col-lg-8">

    <div class="well">
        <h6>{{trans('gitscrum.clone-using-ssh-or-https')}}</h6>
        <p><strong>SSH</strong>: {{$productBacklog->ssh_url}}</p>
        <p><strong>HTTPS</strong>: {{$productBacklog->clone_url}}</p>
    </div>

    @if(!empty($productBacklog->description))
    <p class="description">
        <small>{{trans('gitscrum.description')}}</small>
        <span>{!! nl2br(e($productBacklog->description)) !!}</span>
    </p>
    @endif

    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-userStories">{{trans('gitscrum.user-stories')}}
                    ({{$productBacklog->userStories->count()}})</a></li>
            <li class=""><a data-toggle="tab" href="#tab-sprints">{{trans('gitscrum.sprint-backlogs')}}
                    ({{$productBacklog->sprints->count()
            }})</a></li>
            <li class=""><a data-toggle="tab" href="#tab-comments">{{trans('gitscrum.comments')}}
                    ({{$productBacklog->comments->count
            ()}})</a></li>
            <li class=""><a data-toggle="tab" href="#tab-branches">{{trans('gitscrum.branches')}}
                    ({{$productBacklog->branches->count
            ()}})</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-userStories" class="tab-pane active">
                <div class="panel-body">

                    @include('partials.boxes.search-min', [ 'query' => 'user_story', 'search' => $search,
                        'route' => route('product_backlogs.show', ['slug' => $productBacklog->slug]), 'txtSearch' =>
                        trans('gitscrum.search-by-user-stories') ])
                    @include('partials.boxes.user-story', [ 'list' => $userStories ])

                </div>
            </div>
            <div id="tab-sprints" class="tab-pane">
                <div class="panel-body">
                    @include('partials.boxes.search-min', ['txtSearch' => trans('gitscrum.search-by-sprint-backlogs')])
                    @include('partials.boxes.sprint', [ 'list' => $sprints ])
                </div>
            </div>
            <div id="tab-comments" class="tab-pane">
                <div class="panel-body">
                    @include('partials.forms.comment', ['id'=>$productBacklog->id, 'type'=>'product_backlogs'])
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
