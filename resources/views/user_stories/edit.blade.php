@section('title',  trans('gitscrum.edit-user-story'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.user-story', ['route' => 'user_stories.update', 'userStory' => $userStory])

@endsection
