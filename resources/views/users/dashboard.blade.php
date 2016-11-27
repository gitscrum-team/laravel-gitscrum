@section('title',  _('Dashboard'))

@extends('layouts.master')

@section('breadcrumb')

<div class="page-heading">
    <div class="col-lg-6">
        <h3 class="ptn mtn mbn pbn">{{_('Dashboard')}}</h3>
    </div>

    <div class="col-lg-6 text-right">
        <div class="btn-group">
            <a href="{{route('repositories.update')}}" class="btn btn-sm btn-primary">
                {{_('Update Repositories')}}</a>
        </div>
    </div>
</div>

@endsection

@section('content')

<div class="row">

    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-9 m-b-xs">
                        <div data-toggle="buttons" class="btn-group">
                            <label class="btn btn-sm btn-white"> <input type="radio" id="option1" name="options"> Day </label>
                            <label class="btn btn-sm btn-white active"> <input type="radio" id="option2" name="options"> Week </label>
                            <label class="btn btn-sm btn-white"> <input type="radio" id="option3" name="options"> Month </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                        <button type="button" class="btn btn-sm btn-sm btn-primary"> Go!</button> </span></div>
                    </div>
                </div>
                <div class="table-responsive">

                    <div class="project-list">

                        <table class="table table-hover issue-tracker">
                            <tbody>
                            @each('partials.lists.issues', $user->issues, 'list', 'partials.lists.no-items')
                            </tbody>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

@endsection
