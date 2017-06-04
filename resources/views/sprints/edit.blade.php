@section('title',  trans('gitscrum.edit-sprint'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.sprint', ['route' => 'sprints.update', 'sprint' => $sprint ])

@endsection
