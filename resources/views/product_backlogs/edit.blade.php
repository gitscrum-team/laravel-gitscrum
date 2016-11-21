@section('title',  _('Edit Product Backlog'))

@extends('layouts.modal')

@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="jumbotron">
            <h1>{{_('Edit')}} <strong>{{_('Product Backlog')}}</strong></h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.</p>
        </div>
    </div>

    @include('partials.forms.product-backlog', ['route' => 'product_backlogs.update'])

</div>

@endsection
