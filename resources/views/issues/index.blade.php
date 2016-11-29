@section('title',  _('Sprints'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3 class="ptn mtn mbn pbn">{{_('Sprint Planning')}}</h3>
</div>
<div class="col-lg-6 text-right">
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
        <a href="{{route('user_stories.edit', ['slug' => $sprint->slug])}}"
            class="btn btn-sm btn-default">
            <i class="fa fa-trash" aria-hidden="true"></i></a>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">

    @foreach ($configStatus as $status)
        <div class="col-lg-3">
            <h3>{{$status->title}}</h3>
            <p class="small"><i class="fa fa-hand-o-up"></i> Drag task between list</p>
            <ul class="sortable-list connectList agile-list" id="{{$status->slug}}" data-value="{{$status->id}}">
                @if(isset($issues[$status->id]))
                    @each('partials.lists.agile-cards', $issues[$status->id], 'card', 'partials.lists.no-items')
                @endif
            </ul>
        </div>
    @endforeach

    <div class="clearfix"></div>

</div>

<script>
    $(document).ready(function(){

        $(".agile-list").sortable({
            connectWith: ".connectList",
            update: function( event, ui ) {

                var todo = $( "#todo" ).sortable( "toArray" );
                var inprogress = $( "#inprogress" ).sortable( "toArray" );
                var completed = $( "#completed" ).sortable( "toArray" );
                $('.output').html("ToDo: " + window.JSON.stringify(todo) + "<br/>" + "In Progress: " + window.JSON.stringify(inprogress) + "<br/>" + "Completed: " + window.JSON.stringify(completed));
            }
        }).disableSelection();

    });
</script>

@endsection
