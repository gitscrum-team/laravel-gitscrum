@section('title',  trans('Create Issue'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.issue', ['route' => 'issues.store'])

@endsection
