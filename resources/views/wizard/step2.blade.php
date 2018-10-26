@section('title',  trans('gitscrum.welcome-to-gitScrum-step-1'))

@extends('layouts.master-fluid', ['hideNavbar' => true, 'bodyClass' => 'body-wizard-step2'])

@section('content')


    <div class="authentication__left-screen white">

        <div class="aligner">

            <div class="content-area">

                <div class="text-center">
                    @if($repositories->count())
                        <h4>{{trans('Congratulations')}}</h4>
                        <h5>{{trans('gitscrum.you-have-successfully-added-repositories-for')}} {{config('app.name')}}</h5>
                    @else
                        <h4>{{trans('gitscrum.choose-at-least-one-repository')}}</h4>
                        <h5>{{trans('gitscrum.you-can-click')}} <a href="{{route('wizard.step1')}}">{{trans('gitscrum.here')}}</a>
                            {{trans('gitscrum.to-try-again')}}</h5>
                    @endif
                </div>

                @if( count($repositories) )

                    <div class="content-middle gs-card">

                        <div class="gs-card-content">

                        @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

                        </div>

                    </div>

                @else

                    <hr>

                @endif

                <div class="text-center">

                    @if(count($repositories))
                        <a href="{{route('product_backlogs.index')}}" class="btn btn-lg btn-default">{{trans('gitscrum.continue-using')}}
                            <strong>{{config('app.name')}}</strong></a>

                        <span>&nbsp;&nbsp;&nbsp;<strong>{{trans('gitscrum.or')}}</strong>&nbsp;&nbsp;&nbsp;</span>
                        <a href="{{route('wizard.step3')}}" class="btn btn-lg btn-success btn-loader">{{trans('gitscrum.import-my')}}
                            <strong>{{Auth::user()->provider}} {{trans('gitscrum.issues')}}</strong></a>

                    @else

                        <div class="text-left">
                            <h4 class="pb30">{{trans('gitscrum.create-your-first-repository')}}</h4>
                            @include('partials.forms.product-backlog', ['route' => 'product_backlogs.store'])
                        </div>

                    @endif

                </div>

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








<div class="col-lg-12">



</div>
@endsection
