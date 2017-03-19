@section('page-title',  trans('gitscrum.product-backlog'))

@section('header-title',  $productBacklog->title )

@extends('layouts.master')

@section('breadcrumb')
<a href="{{route('user.dashboard')}}" class="section">{{trans('gitscrum.dashboard')}}</a>
<i class="right chevron icon divider"></i>
<a href="{{route('product_backlogs.index')}}" class="section">{{trans('gitscrum.product-backlog-list')}}</a>
<i class="right chevron icon divider"></i>
<div class="active section">{{trans('gitscrum.product-backlog')}}</div>
@endsection


@section('content')

<div class="ui menu">
    <div class="ui dropdown icon item">
        <i class="wrench icon"></i>&nbsp;
        {{trans('gitscrum.settings')}}
        <div class="menu">
            <div class="item">
                <i class="dropdown icon"></i>
                <span class="text">New</span>
                <div class="menu">
                    <div class="item">Document</div>
                    <div class="item">Image</div>
                </div>
            </div>
            <div class="item">
                Open...
            </div>
            <div class="item">
                Save...
            </div>
            <a href="{{route('product_backlogs.edit', ['slug' => $productBacklog->slug])}}"
               class="item" data-toggle="modal" data-target="#modalLarge">
                <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('gitscrum.edit-product-backlog')}}</a>
            <div class="item">Edit Permissions</div>
            <div class="divider"></div>
            <div class="header">
                Export
            </div>
            <div class="item">
                Share...
            </div>
        </div>
    </div>

    <a href="{{route('user_stories.create')}}" class="item"
       data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.create-user-story')}}</a>
    <a href="{{route('sprints.create', ['slug_product_backlog' => $productBacklog->slug])}}" class="item"
       data-toggle="modal" data-target="#modalLarge">
        {{trans('gitscrum.create-sprint')}}</a>

    <div class="right menu">
        @include('partials.lnk-favorite', ['favorite' => $productBacklog->favorite, 'type' => 'product_backlogs',
        'id' => $productBacklog->id, 'btnSize' => 'item ', 'text' => trans('gitscrum.favorite')])
    </div>
</div>

<div class="ui grid padding-top-20px">
    <div class="two column row">
        <div class="four wide column">
            <div class="ui segment">
            six wide column computer only
            </div>
        </div>
        <div class="twelve wide column">

            <!--
            <div class="ui message">
                <div class="header">{{trans('gitscrum.clone-using-ssh-or-https')}}</div>
                <p><strong>SSH</strong>: {{$productBacklog->ssh_url}}
                <br><strong>HTTPS</strong>: {{$productBacklog->clone_url}}</p>
            </div>
            -->

            <div class="ui segment">
                @if(!empty($productBacklog->description))
                <div class="ui container">
                    <small>{{trans('gitscrum.description')}}</small>
                    <div><span>{!! nl2br(e($productBacklog->description)) !!}</span></div>
                </div>
                @endif
            </div>

            <div class="ui top attached tabular menu">
                <a class="item active" data-tab="first">{{trans('gitscrum.user-stories')}}
                    ({{$productBacklog->userStories->count()}})</a>
                <a class="item" data-tab="second">{{trans('gitscrum.sprint-backlogs')}}
                    ({{$productBacklog->sprints->count()}})</a>
                <a class="item" data-tab="third">{{trans('gitscrum.comments')}}
                    ({{$productBacklog->comments->count()}})</a>
                <a class="item" data-tab="fourth">{{trans('gitscrum.branches')}}
                    ({{$productBacklog->branches->count
            ()}})</a>
            </div>
            <div class="ui bottom attached tab segment active" data-tab="first">
                First
            </div>
            <div class="ui bottom attached tab segment" data-tab="second">
                Second
            </div>
            <div class="ui bottom attached tab segment" data-tab="third">

                <div class="ui comments">

                </div>

                @include('partials.forms.comment', ['id'=>$productBacklog->id, 'type'=>'product_backlogs'])
                @each('partials.lists.comments', $productBacklog->comments, 'comment', 'partials.lists.no-items')


            </div>
            <div class="ui bottom attached tab segment" data-tab="fourth">
                Fourth
            </div>


        </div>
    </div>
</div>



<div class="col-lg-4">



    <hr />

    @include('partials.boxes.note', [ 'list' => $productBacklog, 'type'=> 'product_backlogs',
        'title' => 'Notes', 'percentage' => Helper::percentage($productBacklog, 'notes')])

    @include('partials.boxes.attachment', ['id'=>$productBacklog->id, 'type'=>'product_backlogs', 'list' => $productBacklog->attachments])

</div>

<div class="col-lg-8">

    <div class="well">
        <h6></h6>

    </div>



    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"></li>
            <li class=""></li>
            <li class=""></li>
            <li class=""></li>
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
