@section('title',  trans('gitscrum.edit-comment'))

@extends('layouts.modal')

@section('content')

    <div class="comment-edit">
        @include('partials.forms.comment', ['route' => 'comments.update', 'comment' => $comment])
    </div>

@endsection
