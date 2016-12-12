@section('title',  trans('Create Sprint'))

@extends('layouts.modal')

@section('content')

@include('partials.forms.sprint', ['route' => 'sprints.store'])

@endsection
