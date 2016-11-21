@section('title',  _('Edit Issue'))

@extends('layouts.modal')

@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="jumbotron">
            <h1>{{_('Edit')}} <strong>{{_('Issue')}}</strong></h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.</p>
        </div>
    </div>

    @include('partials.forms.issue', ['route' => 'issues.update', 'issue_types' => $issue_types])

</div>

@endsection
