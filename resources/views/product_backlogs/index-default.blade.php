@section('title',  trans('gitscrum.product-backlog'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>{{trans('gitscrum.product-backlog-list')}}</h3>
</div>
<div class="col-lg-6 text-right">
    <a href="{{route('product_backlogs.create')}}" class="btn btn-sm btn-primary"
        data-toggle="modal" data-target="#modalLarge">{{trans('gitscrum.create-product-backlog')}}</a>
</div>
@endsection

@section('content')
<div class="col-lg-12">
    @include('partials.boxes.product-backlog', [ 'list' => $backlogs->sortByDesc('favorite') ])
</div>

{{$backlogs->setPath('')->links()}}

@endsection
