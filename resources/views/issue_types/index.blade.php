@section('title',  trans('Sprints'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-8">
    <h3>{{trans('Issue Type')}}: <span class="">{{$issues->first()->type->title}}</span></h3>
</div>
<div class="col-lg-4 text-right">

</div>
@endsection

@section('content')
<div class="col-lg-12">

    <div class="form-group">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="{{trans('Search issue type by name...')}}">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover issue-tracker">
            <tbody>
            @each('partials.lists.issues', $issues, 'list', 'partials.lists.no-items')
            </tbody>
        </table>
    </div>

    {{ $issues->links() }}

</div>
@endsection
