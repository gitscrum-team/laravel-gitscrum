@section('title',  _('Edit Issue'))

@extends('layouts.modal')

@section('content')

    @include('partials.forms.issue', ['route' => 'issues.update', 'issue_types' => $issue_types])

@endsection
