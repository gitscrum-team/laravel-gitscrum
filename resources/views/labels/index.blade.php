@section('title',  trans('Sprints'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-8">
    <h3>{{trans('Label')}}: <span class="">{{$label->title}}</span></h3>
</div>
<div class="col-lg-4 text-right">

</div>
@endsection

@section('content')
<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-content">

            <div class="m-b-lg">

                <div class="input-group">
                    <input type="text" placeholder="Search issue by name..." class=" form-control">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-white"> Search</button>
                    </span>
                </div>

            </div>

            <div class="table-responsive">
                <table class="table table-hover issue-tracker">
                    <tbody>
                    @each('partials.lists.issues', $list, 'list', 'partials.lists.no-items')
                    </tbody>
                </table>
            </div>

            {{ $list->links() }}

        </div>

    </div>
</div>
@endsection
