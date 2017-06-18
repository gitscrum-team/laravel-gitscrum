@if(isset($notification['message']))
    <div class="col-lg-12 {{$notification['class'] or ''}}">
        <div class="alert alert-{{$notification['alert']}} alert-errors">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
         {!! $notification['message'] !!}
        </div>
    </div>
@endif
