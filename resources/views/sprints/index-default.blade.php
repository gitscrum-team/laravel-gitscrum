@section('title',  _('Sprints'))

@extends('layouts.master')

@section('breadcrumb')

<div class="page-heading">
    <div class="col-lg-6">
        <h2>{{_('Sprint Backlog - List')}}</h2>
    </div>
    <div class="col-lg-6 text-right">
        <div class="btn-group">
            <a href="{{route('sprints.index', ['mode'=>'calendar'])}}" class="btn btn-sm btn-outline btn-primary font-bold">
                {{_('Mode Calendar')}}</a>
            <a href="{{route('sprints.create')}}"
                class="btn btn-sm btn-outline btn-primary font-bold"
                data-toggle="modal" data-target="#modalLarge">{{_('Create Sprint Backlog')}}</a>
        </div>
    </div>
</div>

@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                @include('partials.boxes.sprint', [ 'list' => $sprints ])
            </div>
        </div>
    </div>
</div>

@endsection
