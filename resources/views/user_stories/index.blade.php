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
    @include('partials.boxes.user-story', [ 'list' => $userStories])
</div>
@endsection
