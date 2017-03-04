@section('title',  trans('Edit Product Backlog'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.product-backlog', ['route' => 'product_backlogs.update'])

@endsection
