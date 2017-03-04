@section('title',  trans('Edit Sprint'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.sprint', ['route' => 'sprints.update', 'sprint' => $sprint ])

@endsection
