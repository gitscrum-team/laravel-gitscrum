@section('page-title',  trans('gitscrum.welcome-to-gitScrum-step-2'))

@section('header-title', trans('gitscrum.welcome-to') .' ' . trans('GitScrum') . ' - ' .
    $repositories->count() . ' ' . trans('gitscrum.repositories') )

@if($repositories->count())
    @section('header-subtitle', trans('Congratulations') . '! ' .
    trans('gitscrum.you-have-successfully-added-repositories-for') . ' ' . trans('GitScrum'))
@else
    @section('header-subtitle', trans('gitscrum.choose-at-least-one-repository') . ' ' .
    trans('gitscrum.you-can-click').'<a href="'.route('wizard.step1').'">' . trans('gitscrum.here').'</a>' .
    trans('gitscrum.to-try-again'))
@endif

@extends('layouts.master')

@section('content')

<div class="ui last container">
    <div class="ui three steps">
        <div class=" step">
            <div class="content">
                <div class="title">{{trans('gitscrum.step1')}}</div>
                <div class="description">Choose your shipping options</div>
            </div>
        </div>
        <div class="active step">
            <div class="content">
                <div class="title">{{trans('gitscrum.step2')}}</div>
                <div class="description">Enter billing information</div>
            </div>
        </div>
        <div class="disabled step">
            <div class="content">
                <div class="title">{{trans('gitscrum.finish')}}</div>
                <div class="description">Review your order details</div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">

    @include('partials.boxes.repositories', ['list'=>$repositories])

    <div class="padding-top-20px">
        <div class="ui middle aligned center aligned grid" >

            <div class="row">
                <div class="column main-column">

                    <div class="ui two column grid">
                        @if(count($repositories))
                        <div class="column button-column">
                            <a href="{{route('wizard.step3')}}" class="ui huge left labeled icon button">
                                {{trans('gitscrum.import-my')}}
                                <strong>{{Auth::user()->provider}} {{trans('gitscrum.issues')}}</strong>
                                <i class="browser icon"></i>
                            </a>
                        </div>
                        @endif
                        <div class="divider-column">
                            <div class="ui vertical divider">
                                Or
                            </div>
                        </div>
                        <div class="column button-column">
                            <a href="{{route('product_backlogs.index')}}" class="ui huge right labeled icon button">
                                {{trans('gitscrum.continue-using')}}
                                <strong>{{trans('GitScrum')}}</strong>
                                <i class="browser icon"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
