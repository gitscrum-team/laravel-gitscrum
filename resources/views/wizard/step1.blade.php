@section('title',  _('Welcome to GitScrum - Step 1'))

@extends('layouts.master', ['hideNavbar' => true])

@section('breadcrumb')
<div class="nav-wizard">
    <div class="col-lg-6">
        <h3 class="ptn mtn mbn pbn">{{_('Welcome to')}} {{_('GitScrum')}}</h3>
    </div>
    <div class="col-lg-6">
        <h3 class="ptn mtn mbn pbn pull-right">{{_('Choose repositories')}}</h3>
    </div>
</div>
@endsection

@section('content')
<div class="col-lg-12">

    <form action="{{route('wizard.step2')}}" method="post">
        {{ csrf_field() }}

        @include('partials.boxes.repositories', ['list'=>$repositories, 'columns'=>$columns])

        <div class="text-center">
            <button class="btn btn-lg btn-success">{{_('Confirm to add repositories into the')}} <strong>{{_('GitScrum')}}</strong></button>
        </div>

    </form>

</div>
@endsection
