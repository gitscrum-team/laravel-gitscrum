@section('title',  trans('gitscrum.product-backlog'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>{{trans('gitscrum.user-story-list')}}</h3>
</div>
<div class="col-lg-6 text-right">
    <a href="{{route('user_stories.create')}}"
        class="btn btn-sm btn-primary"
        data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.create-user-story')}}</a>
</div>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="gs-card">
        <h4 class="gs-card-title">
            {{trans('gitscrum.user-story-list')}}

            <a href="{{route('user_stories.create')}}" class="btn btn-default btn-sm pull-right"
               data-toggle="modal" data-target="#modalLarge" role="button">{{trans('gitscrum.create-user-story')}}</a>
        </h4>

        <div class="gs-card-content">
            @include('partials.boxes.user-story', [ 'list' => $userStories])
        </div>
    </div>
</div>
@endsection
