@if(Session::has('success'))
    <div class="col-lg-12">
        <div class="alert alert-success alert-errors">
         {{ Session::get('success') }}
        </div>
    </div>
@endif
