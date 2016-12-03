@section('title',  _('Team'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>{{_('Team')}}</h3>
</div>
<div class="col-lg-6 text-right"></div>
@endsection

@section('content')

    @each('partials.lists.users', $list, 'list', 'partials.lists.no-items')

@endsection
