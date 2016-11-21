@section('title',  _('Sprints'))

@extends('layouts.master')

@section('breadcrumb')


<div class="page-heading">
    <div class="col-lg-6">
        <h2>{{_('Sprint Backlog - Calendar')}}</h2>
    </div>
    <div class="col-lg-6 text-right">
        <div class="btn-group">
            <a href="{{route('sprints.index', ['mode'=>'default'])}}"
                class="btn btn-sm btn-outline btn-primary font-bold">
                {{_('Mode List')}}</a>
            <a href="{{route('sprints.create')}}"
                class="btn btn-sm btn-outline btn-primary font-bold"
                data-toggle="modal" data-target="#gs-modal">{{_('Create Sprint Backlog')}}</a>
        </div>
    </div>
</div>

@endsection

@section('content')

<div class="row">

    <div class="col-lg-12">

        <div class="ibox">
            <div class="ibox-content">
                <div id="calendar"></div>
            </div>
        </div>

    </div>

</div>

<script>

$(function(){

    $('#calendar').fullCalendar({
        header: {
            right: 'prev,next',
            left: 'title'
        },
        editable: false,
        events: [
            @foreach ($sprints as $sprint)
            {
                title: '{{$sprint->title}}',
                start: new Date({{Carbon\Carbon::parse($sprint->date_start)->format('Y')}},
                                {{Carbon\Carbon::parse($sprint->date_start)->format('m')}},
                                {{Carbon\Carbon::parse($sprint->date_start)->format('d')}}),
                end: new Date(  {{Carbon\Carbon::parse($sprint->date_finish)->format('Y')}},
                                {{Carbon\Carbon::parse($sprint->date_finish)->format('m')}},
                                {{Carbon\Carbon::parse($sprint->date_finish)->format('d')}}),
                allDay: true,
                color: '#{{$sprint->color}}',
                url: '{{route('sprints.show',['slug'=>$sprint->slug])}}'
            },
            @endforeach
        ]
    });

});

</script>

@endsection
