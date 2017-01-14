@section('title',  trans('Sprints'))

@extends('layouts.kanban')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>
        @include('partials.includes.breadcrumb-sprint', ['obj'=>$sprint])
        @if( !is_null($sprint) )
        {{trans('Sprint Planning')}}
        @else
        {{trans('My Planning')}}
        @endif
    </h3>
</div>
<div class="col-lg-6 text-right">
    @if( !is_null($sprint) )
        @include('partials.lnk-favorite', ['favorite' => $sprint->favorite, 'type' => 'sprint',
            'id' => $sprint->id, 'btnSize' => 'btn-sm font-bold', 'text' => trans('Favorite')])
        &nbsp;&nbsp;
        <div class="btn-group">
            <a href="{{route('issues.create', ['scope' => 'sprint', 'slug'=>$sprint->slug])}}"
                class="btn btn-sm btn-primary"
                data-toggle="modal" data-target="#modalLarge">
                <i class="fa fa-plus" aria-hidden="true"></i> {{trans('Create Issue')}}</a>
            <a href="{{route('sprints.edit', ['slug'=>$sprint->slug])}}"
                class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalLarge">
                <i class="fa fa-pencil" aria-hidden="true"></i> {{trans('Edit Sprint')}}</a>
            <form action="{{route('sprints.destroy')}}" method="POST" class="form-delete pull-right">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="DELETE" />
                <input type="hidden" name="slug" value="{{$sprint->slug}}" />
                <button class="btn btn-sm btn-default btn-submit-form" type="submit">
                    <i class="fa fa-trash" aria-hidden="true"></i></a>
                </button>
            </form>
        </div>
    @endif
</div>
@endsection

@section('content')
<div class="kanban-board">

    <div class="kanban-board-scroll">
        <div class="agile-column connectColumn" data-endpoint="{{route('api.configStatus.position.update')}}">
        @foreach ($configStatus as $status)
        <div style="float:left" class="row">
            <div class="agile" data-value="{{$status->id}}">
                <h5 class="handle">
                    <i class="fa fa-arrows-h" data-toggle="tooltip" titl="{{trans('Drag it')}}" aria-hidden="true"></i>
                    {{$status->title}}
                    (
                    @if(isset($issues[$status->id]))
                        <span>{{count($issues[$status->id])}}</span>
                    @else
                        <span>0</span>
                    @endif
                    )
                </h5>
                <div class="agile-list-scroll">
                    <ul class="sortable-list connectList agile-list"
                        data-color="{{$status->color}}" data-closed="{{$status->is_closed}}"
                        data-value="{{$status->id}}" data-endpoint="{{route('issues.status.update')}}">
                        @if(isset($issues[$status->id]))
                            @each('partials.lists.agile-cards', $issues[$status->id], 'card', 'partials.lists.no-items')
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
        </div>
    </div>
</div>

@endsection
