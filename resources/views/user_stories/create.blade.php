@section('title',  trans('gitscrum.create-user-story'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.user-story', ['route' => 'user_stories.store'])

@endsection
