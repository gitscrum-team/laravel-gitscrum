@section('title',  _('Create Product Backlog'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.product-backlog', ['route' => 'product_backlogs.store'])

@endsection
