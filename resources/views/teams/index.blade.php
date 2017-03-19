@section('page-title', trans('gitscrum.team'))

@section('header-title', trans('gitscrum.team'))

@extends('layouts.master')

@section('breadcrumb')
@endsection

@section('content')
    <div class="ui link cards">
        @each('partials.lists.users', $list, 'list', 'partials.lists.no-items')
    </div>
@endsection
