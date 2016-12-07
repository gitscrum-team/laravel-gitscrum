@section('title',  _('Create Sprint'))

@extends('layouts.modal')

@section('content')

@include('partials.forms.sprint', ['route' => 'sprints.store'])

@endsection
