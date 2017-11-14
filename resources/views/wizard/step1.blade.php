@section('title',  trans('gitscrum.welcome-to-gitScrum-step-1'))

@extends('layouts.master-fluid', ['hideNavbar' => true, 'bodyClass' => 'body-wizard-step1'])

@section('content')

<div class="authentication__left-screen white">

    <div class="aligner">

        <div class="content-area">

            <div class="text-center">
                <h4>{{trans('gitscrum.you-can-import-the-repositories-to-GitScrum')}}</h4>
                <h5>{{trans('gitscrum.you-have')}} {{$repositories->count()}} {{trans('gitscrum.repositories')}}</h5>
            </div>

            <form action="{{route('wizard.step2')}}" method="post">

                {{ csrf_field() }}

                <div class="content-middle gs-card">

                    <div class="gs-card-content">

                        @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

                    </div>

                </div>

                <div class="text-center">
                    <button class="btn btn-lg btn-success btn-loader">{{trans('gitscrum.confirm-to-add-repositories-into-the')}} <strong>{{config('app.name')
                    }}</strong></button>
                </div>

            </form>

        </div>

    </div>

</div>

<div class="authentication__right-screen">

    <div class="aligner">
        <div class="content">

            <h1>GitScrum</h1>
            <h2>be faster</h2>

        </div>
    </div>

</div>
@endsection
