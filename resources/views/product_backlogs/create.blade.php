@section('title',  trans('gitscrum.create-product-backlog'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.product-backlog', ['route' => 'product_backlogs.store'])

@endsection
