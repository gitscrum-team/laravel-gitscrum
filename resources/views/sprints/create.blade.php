@section('title',  _('Create Sprint'))

@extends('layouts.modal')

@section('content')

<div class="row">
    <div class="col-lg-4">
        <div class="jumbotron">
            <h1>{{_('New')}} <strong>{{_('Sprint')}}</strong></h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan.</p>
        </div>
    </div>

    @include('partials.forms.sprint', ['route' => 'sprints.store'])

</div>

<script>
$(function(){
    $('input[name="daterange"]').daterangepicker();

    $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });
});
</script>

@endsection
