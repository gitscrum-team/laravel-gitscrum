@if(isset($notification['message']))
    <div class="col-lg-12 {{$notification['class'] or ''}}">
        <div class="alert alert-{{$notification['alert']}} alert-errors">
         {!! $notification['message'] !!}
        </div>
    </div>
@endif
