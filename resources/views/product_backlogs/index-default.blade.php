@section('page-title',  trans('gitscrum.product-backlog'))

@section('header-title',  trans('gitscrum.product-backlog'))

@extends('layouts.master')

@section('content')

<div class="ui menu">
    <a href="{{route('product_backlogs.create')}}" class="item"
       data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.create-product-backlog')}}</a>
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
            <th colspan="3">{{trans('gitscrum.product-backlog')}}</th>
            <th colspan="2">{{trans('gitscrum.issues')}}</th>
            <th rowspan="2">{{trans('gitscrum.organization')}}</th>
            <th rowspan="2">{{trans('gitscrum.type')}}</th>
            <th rowspan="2" style="width:10px"></th>
        </tr>
        <tr>
            <th></th>
            <th>{{trans('gitscrum.user-stories')}}</th>
            <th>{{trans('gitscrum.sprints')}}</th>
            <th>{{trans('gitscrum.open')}}</th>
            <th>{{trans('gitscrum.closed')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $backlogs->sortByDesc('favorite') as $backlog )
        <tr>
            <td style="width:10px">
                @include('partials.lnk-favorite', ['favorite' => $backlog->favorite,
                'type' => 'product_backlogs', 'id' => $backlog->id, 'btnSize' => 'circular ui icon button red mini' ])
            </td>
            <td><a href="{{route('product_backlogs.show', ['slug' => $backlog->slug])}}">
                    <strong>{{$backlog->title}}</strong></a></td>
            <td>{{$backlog->userStories->count()}}</td>
            <td>{{$backlog->sprints->where('closed_at', NULL)->count()}}
                / {{$backlog->sprints->where('closed_at', '!=', NULL)->count()}}</td>
            <td class="center aligned">
                {{$backlog->issues->where('closed_at', NULL)->count()}}
            </td>
            <td>
                {{$backlog->issues->where('closed_at', '!=', NULL)->count()}}
            </td>
            <td>{{$backlog->organization->title}}</td>
            <td class="right aligned">{{$backlog->visibility}}</td>
            <td style="width:10px">
                <a href="{{$backlog->html_url}}" target="_blank" class="circular ui icon button mini"
                   title="{{trans('gitscrum.go-to-gitHub')}}" alt="{{trans('gitscrum.go-to-gitHub')}}">
                    <i class="icon github" aria-hidden="true"></i></a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

</div>

{{$backlogs->setPath('')->links()}}


@endsection
