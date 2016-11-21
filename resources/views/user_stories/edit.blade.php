@section('title',  _('Edit User Story'))

@extends('layouts.modal')

@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="jumbotron">
            <h1>{{_('Edit')}} <strong>{{_('User Story')}}</strong></h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.</p>
        </div>
    </div>

    @include('partials.forms.user-story', ['route' => 'user_stories.update', 'userStory' => $userStory])

</div>

@endsection
