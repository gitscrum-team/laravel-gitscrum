@section('title',  _('Create User Story'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.user-story', ['route' => 'user_stories.store'])

@endsection
