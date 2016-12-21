@section('title',  trans('Welcome to GitScrum - Step 1'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-12">
    <h3 class="text-center">
        @if($repositories->count())
            {{trans('Congratulations.')}}
            <span>{{trans('You have successfully added repositories for')}} {{trans('GitScrum')}}</span>
        @else
            {{trans(':( Choose at least one repository')}}
            <p class="small">{{trans('You can click')}} <a href="{{route('wizard.step1')}}">{{trans('here')}}</a> {{trans('and try again')}}</p>
        @endif
    </h3>
</div>
@endsection

@section('content')
<div class="col-lg-12">

    @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

    <div class="text-center">

        @if(count($repositories))
        <a href="{{route('wizard.step3')}}" class="btn btn-lg btn-success">{{trans('Import my')}}
            <strong>{{Auth::user()->provider}} {{trans('Issues')}}</strong></a>
        <span>&nbsp;&nbsp;&nbsp;<strong>{{trans('or')}}</strong>&nbsp;&nbsp;&nbsp;</span>
        @endif

        <a href="{{route('product_backlogs.index')}}" class="btn btn-lg btn-default">{{trans('Continue using')}} <strong>{{trans('GitScrum')}}</strong></a>
    </div>

</div>
@endsection
