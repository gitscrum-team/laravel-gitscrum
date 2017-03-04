@section('title',  trans('gitscrum.profile') . ' - ' . $user->username)

@extends('layouts.master')

@section('breadcrumb')

<div class="col-lg-6">
    <h3>{{trans('gitscrum.profile')}}</h3>
</div>

<div class="col-lg-6 text-right">
    <div class="btn-group">

    </div>
</div>

@endsection

@section('content')

<div class="col-md-12 user-profile">
    <div class="row">

        <div class="col-lg-3 information">

            @each('partials.lists.users', [$user], 'list', 'partials.lists.no-items')

            <div class="clearfix"></div>

            @each('partials.lists.activities-complete', $activities, 'activity', 'partials.lists.no-items')

        </div>

        <div class="col-lg-9">

            <div class="row">
                <div class="col-lg-3 col-sm-4">
                    <div class="tile mbn pbn">
                        <i class="fa fa-trophy fa-4x" aria-hidden="true"></i>
                        <h3 class="tile-title mtm">62</h3>
                        <p class="pbm">Effort</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-4">
                    <div class="tile mbn pbn">
                        <i class="fa fa-list fa-4x" aria-hidden="true"></i>
                        <h3 class="tile-title mtm">{{$user->sprints()->count()}}</h3>
                        <p class="pbm">{{trans('gitscrum.cooperation')}}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-4">
                    <div class="tile mbn pbn">
                        <i class="fa fa-th fa-4x" aria-hidden="true"></i>
                        <h3 class="tile-title mtm">{{$user->issues()->count()}}</h3>
                        <p class="pbm">{{trans('gitscrum.issues-done')}}</p>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-4">
                    <div class="tile mbn pbn">
                        <i class="fa fa-list fa-4x" aria-hidden="true"></i>
                        <h3 class="tile-title mtm">{{$user->sprints()->count()}}</h3>
                        <p class="pbm">{{trans('gitscrum.commits')}}</p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
