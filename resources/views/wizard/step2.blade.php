@section('title',  _('Welcome to GitScrum - Step 1'))

@extends('layouts.master', ['hideNavbar' => true])

@section('breadcrumb')
<div class="nav-wizard">
    <div class="col-lg-12">
        <h3>

            @if($repositories->count())
                {{_('Congratulations.')}}
                <p class="small">
                {{_('You have successfully added repositories for')}} {{_('GitScrum')}}
                </p>
            @else
                {{_(':( Choose at least one repository')}}
                <p class="small">{{_('You can click')}} <a href="{{route('wizard.step1')}}">{{_('here')}}</a> {{_('and try again')}}</p>
            @endif

        </h3>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">

    @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

    <div class="text-center">
        <a href="{{route('product_backlogs.index')}}" class="btn btn-lg btn-success">{{_('Continue using')}} <strong>{{_('GitScrum')}}</strong></a>
    </div>

</div>
@endsection
