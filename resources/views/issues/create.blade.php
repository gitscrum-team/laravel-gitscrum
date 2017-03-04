@section('title',  trans('gitscrum.create-issue'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.issue', ['route' => 'issues.store'])

@endsection
