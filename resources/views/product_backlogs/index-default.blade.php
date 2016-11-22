@section('title',  _('Product Backlogs'))

@extends('layouts.master')

@section('breadcrumb')

<div class="row page-heading">
    <div class="col-lg-6">
        <h2>{{_('Product Backlog List')}}</h2>
    </div>
    <div class="col-lg-6 text-right">
        <a href="{{route('product_backlogs.create')}}" class="btn btn-sm btn-outline
            btn-primary font-bold"
            data-toggle="modal" data-target="#modalLarge">{{_('Create Product Backlog')}}</a>
    </div>
</div>

@endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                @include('partials.boxes.product-backlog', [ 'list' => $backlogs->sortByDesc('favorite') ])
            </div>
        </div>
    </div>
</div>

@endsection
