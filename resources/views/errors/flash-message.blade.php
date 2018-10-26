@if(Session::has('success') || Session::has('error'))
    <div class="col-lg-12">
        <div class="alert alert-{{ Session::has('success') ? 'success' : 'danger' }} alert-errors">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
         	{{ Session::has('success') ? Session::get('success') : Session::get('error') }}
        </div>
    </div>
@endif
