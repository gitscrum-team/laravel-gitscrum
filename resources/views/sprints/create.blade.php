@section('title',  trans('gitscrum.create-sprint'))

@extends('layouts.modal')

@section('content')

@include('partials.forms.sprint', ['route' => 'sprints.store'])

@endsection
