@section('title',  _('Sprints'))

@extends('layouts.master')

@section('breadcrumb')

<div class="page-heading">
    <div class="col-lg-6">
        <h2>{{_('Label')}}: <span class="font-bold">{{$label->title}}</span></h2>
    </div>
    <div class="col-lg-6 text-right">

    </div>
</div>

@endsection

@section('content')

<div class="row">

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

</div>
@endsection
