@section('title',  trans('Edit User Story'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.user-story', ['route' => 'user_stories.update', 'userStory' => $userStory])

@endsection
