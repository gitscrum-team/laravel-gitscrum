@if ( isset($favorite->id) )
    <a href="{{route('favorites.destroy', ['type'=>$type, 'id'=>$id])}}" class="btn btn-danger {{$btnSize}}">
        <i class="fa fa-heart" aria-hidden="true"></i> {{ $text or '' }} </a>
@else
    <a href="{{route('favorites.store', ['type'=>$type, 'id'=>$id])}}" class="btn btn-danger btn-outline {{$btnSize}}">
        <i class="fa fa-heart-o" aria-hidden="true"></i> {{ $text or '' }} </a>
@endif
