@section('title',  _('Welcome to GitScrum - Step 1'))

@extends('layouts.master', ['hideNavbar' => true])

@section('breadcrumb')
<div class="nav-wizard">
    <div class="col-lg-12">
        <h3 class="ptn mtn mbn pbn">{{_('Congratulations.')}} <p class="small">{{_('You have successfully imported repositories for')}} {{_('GitScrum')}}</p></h3>
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
