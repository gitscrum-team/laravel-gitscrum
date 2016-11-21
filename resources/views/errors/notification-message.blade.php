@if(isset($notification['message']))
    <div class="alert alert-{{$notification['alert']}} alert-errors small font-bold">
     {{ $notification['message'] }}
    </div>
@endif
