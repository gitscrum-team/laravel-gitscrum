@section('title',  trans('Edit Issue'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.issue', ['route' => 'issues.update'])

@endsection
