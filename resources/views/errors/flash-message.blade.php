@if(Session::has('success'))
    <div class="ui success message">
        <i class="close icon"></i>
        <div class="header">
            {{ Session::get('success') }}
        </div>
    </div>
@endif
