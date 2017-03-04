@section('title',  trans('gitscrum.team'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>{{trans('gitscrum.team')}}</h3>
</div>
<div class="col-lg-6 text-right"></div>
@endsection

@section('content')

    @each('partials.lists.users', $list, 'list', 'partials.lists.no-items')

@endsection
