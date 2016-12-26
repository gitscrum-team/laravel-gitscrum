@if(isset($notification['message']))
    <div class="col-lg-12 {{$notification['class']}}">
        <div class="alert alert-{{$notification['alert']}} alert-errors">
         {!! $notification['message'] !!}
        </div>
    </div>
@endif
