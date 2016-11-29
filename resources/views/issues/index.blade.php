@section('title',  _('Sprints'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3 class="ptn mtn mbn pbn">{{_('Sprint Planning')}}</h3>
</div>
<div class="col-lg-6 text-right">
    @if( !is_null($sprint) )
        @include('partials.lnk-favorite', ['favorite' => $sprint->favorite, 'type' => 'sprint',
            'id' => $sprint->id, 'btnSize' => 'btn-sm font-bold', 'text' => _('Favorite')])
        &nbsp;&nbsp;
        <div class="btn-group">
            <a href="{{route('issues.create', ['slug'=>$sprint->slug])}}"
                class="btn btn-sm btn-primary"
                data-toggle="modal" data-target="#modalLarge">
                <i class="fa fa-plus" aria-hidden="true"></i> {{_('Create Issue')}}</a>
            <a href="{{route('sprints.edit', ['slug'=>$sprint->slug])}}"
                class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalLarge">
                <i class="fa fa-pencil" aria-hidden="true"></i> {{_('Edit Sprint')}}</a>
            <form action="{{route('sprints.delete')}}" method="POST" class="form-delete pull-right">
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
<div class="col-lg-12">
    <div class="row">

            @foreach ($configStatus as $status)
            <div class="col-lg-3">
                <h5>{{$status->title}}</h5>
                <ul class="sortable-list connectList agile-list"
                    data-value="{{$status->id}}" data-endpoint="{{route('issues.status.update')}}">
                    @if(isset($issues[$status->id]))
                        @each('partials.lists.agile-cards', $issues[$status->id], 'card', 'partials.lists.no-items')
                    @endif
                </ul>
            </div>
            @endforeach
        </div>

    </div>

</div>

@endsection
