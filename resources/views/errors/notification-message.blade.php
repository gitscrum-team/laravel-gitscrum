@if(isset($notification['message']))
    <div class="col-lg-12">
        <div class="alert alert-{{$notification['alert']}} alert-errors small font-bold">
         {{ $notification['message'] }}
        </div>
    </div>
@endif
