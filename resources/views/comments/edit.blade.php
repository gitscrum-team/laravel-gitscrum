@section('title',  trans('Edit Comment'))

@extends('layouts.modal')

@section('content')

    <div class="comment-edit">
        @include('partials.forms.comment', ['route' => 'comments.update', 'comment' => $comment])
    </div>

@endsection
