@section('page-title',  trans('gitscrum.user-stories'))

@section('header-title',  trans('gitscrum.user-stories'))

@extends('layouts.master')

@section('content')
<div class="ui menu">
    <a href="{{route('user_stories.create')}}" class="item"
       data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.create-user-story')}}</a>

    <div class="right menu">
        <div class="item">
            <div class="ui action left icon input">
                <i class="search icon"></i>
                <input placeholder="Search" type="text">
                <button class="ui button">Submit</button>
            </div>
        </div>
    </div>
</div>


<div class="ui piled segments">

    <table class="ui celled structured table">
        <thead>
        <tr>
            <th rowspan="2" style="width:10px"></th>
            <th colspan="2">{{trans('gitscrum.user-story')}}</th>
            <th colspan="2">{{trans('gitscrum.issues')}}</th>
            <th rowspan="2"></th>
            <th rowspan="2">{{trans('gitscrum.product-backlog')}}</th>
        </tr>
        <tr>
            <th style="width:140px;">{{trans('gitscrum.priority')}}</th>
            <th></th>
            <th>{{trans('gitscrum.open')}}</th>
            <th>{{trans('gitscrum.closed')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($userStories->sortByDesc('favorite') as $list)
        <tr>
            <td style="width:10px">
                @include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'user_stories',
                    'id' => $list->id, 'btnSize' => 'btn-xs' ])
            </td>
            <td style="width:140px;"><div class="ui button mini"
                                          style="background-color:#{{$list->priority->color}}">
                    {{$list->priority->title}}</div></td>
            <td>
                <a href="{{route('user_stories.show', ['slug'=>$list->slug])}}">{{$list->title}}</a>
            </td>
            <td>{{$list->issues->where('closed_at',NULL)->count()}}</td>
            <td>{{$list->issues->where('closed_at', '!=', NULL)->count()}}</td>
            <td>@include('partials.boxes.progress-bar', [ 'percentage' => Helper::percentage($list, 'issues')])</td>
            <td>
                <a href="{{route('product_backlogs.show',
                    ['slug' => $list->productBacklog->slug])}}">{{$list->productBacklog->title}}</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

</div>

@if(!empty($userStories->links))
    {{ $userStories->links() }}
@endif

@endsection
