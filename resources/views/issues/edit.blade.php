@section('title',  trans('gitscrum.edit-issue'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.issue', ['route' => 'issues.update'])

@endsection
