@section('title',  trans('gitscrum.edit-product-backlog'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.product-backlog', ['route' => 'product_backlogs.update'])

@endsection
