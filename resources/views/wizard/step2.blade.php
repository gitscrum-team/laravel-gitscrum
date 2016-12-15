@section('title',  trans('Welcome to GitScrum - Step 1'))

@extends('layouts.master')

@section('breadcrumb')
<div class="nav-wizard">
    <div class="col-lg-12">
        <h3>

            @if($repositories->count())
                {{trans('Congratulations.')}}
                <p class="small">
                {{trans('You have successfully added repositories for')}} {{trans('GitScrum')}}
                </p>
            @else
                {{trans(':( Choose at least one repository')}}
                <p class="small">{{trans('You can click')}} <a href="{{route('wizard.step1')}}">
                    {{trans('here')}}</a> {{trans('and try again')}}</p>
            @endif

        </h3>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">

    @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

    <div class="text-center">

        @if(count($repositories))
        <a href="{{route('wizard.step3')}}" class="btn btn-lg btn-success btn-loader">{{trans('Import my')}}
            <strong>{{trans('GitHub Issues')}}</strong></a>
        <span class="mll mrl"><strong>{{trans('or')}}</strong></span>
        @endif

        <a href="{{route('product_backlogs.index')}}" class="btn btn-lg btn-default btn-loader">
            {{trans('Continue using')}} <strong>{{trans('GitScrum')}}</strong></a>
    </div>

</div>
@endsection
