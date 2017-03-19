@section('page-title',  trans('gitscrum.sprints'))

@section('header-title',  trans('gitscrum.sprint-backlog'))

@extends('layouts.master')

@section('content')

<div class="ui menu">
    <a href="{{route('sprints.create')}}" class="item"
       data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.create-sprint-backlog')}}</a>
    <a href="{{route('sprints.index', ['mode'=>'calendar'])}}" class="item"
       data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.mode-calendar')}}</a>

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
            <th colspan="3">{{trans('gitscrum.sprint-backlog')}}</th>
            <th colspan="2">{{trans('gitscrum.issues')}}</th>
            <th rowspan="2"></th>
            <th rowspan="2">{{trans('gitscrum.product-backlog')}}</th>
        </tr>
        <tr>
            <th></th>
            <th>{{trans('gitscrum.type')}}</th>
            <th>{{trans('gitscrum.timebox')}}</th>
            <th>{{trans('gitscrum.open')}}</th>
            <th>{{trans('gitscrum.closed')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sprints as $sprint)
        <tr>
            <td>@include('partials.lnk-favorite', ['favorite' => $sprint->favorite, 'type' => 'sprints',
    'id' => $sprint->id, 'btnSize' => 'btn-xs'])</td>
            <td><a href="{{route('sprints.show', ['slug'=>$sprint->slug])
            }}"><strong>{{$sprint->title}}</strong></a></td>
            <td>
                <div class="ui button mini">{{$sprint->visibility}}</div>
                <div class="ui button mini" style="background-color:#{{$sprint->status->color}};">
            {{$sprint->status->title}}</div>
            </td>
            <td>
                <div class="content">
                    <div class="header">{{$sprint->timebox}}</div>
                    <small class="description">( {{$sprint->weeks()}} {{str_plural( trans('gitscrum.week') ,
                    $sprint->weeks())
                    }} )</small>
                </div>
            </td>
            <td>{{$sprint->issues->where('closed_at',NULL)->count()}}</td>
            <td>{{$sprint->issues->where('closed_at', '!=', NULL)->count()}}</td>
            <td>@include('partials.boxes.progress-bar', [ 'percentage' => Helper::percentage($sprint, 'issues')])</td>
            <td><a href="{{route('product_backlogs.show',['slug'=>$sprint->productBacklog->slug])}}">
                {{$sprint->productBacklog->title}}</td>
        </tr>
            @endforeach
        </tbody>
    </table>

</div>

@if(!empty($sprints->links))
    {{ $sprints->links() }}
@endif

@endsection
