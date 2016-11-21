<li class="dd-item" data-id="{{$note->id}}">
    <div class="dd-handle pull-left">
        <i class="fa fa-arrows" aria-hidden="true"></i>
    </div>
    <div class="pull-left" style="width:85%">
        @if($note->closed_at)
            <a href="{{route('notes.update', ['slug'=>$note->slug])}}">
                <i class="fa fa-check-square" aria-hidden="true"></i></a>
            <span class="m-l-xs todo-completed ">{{$note->title}}</span>
            <br>
            <small>{{_('Closed by')}} <a href="{{route('user.profile', ['username'=>$note->closedUser->username])}}">
            {{$note->closedUser->username}}</a></small>
        @else
            <a href="{{route('notes.update', ['slug'=>$note->slug])}}"><i class="fa fa-square-o" aria-hidden="true"></i></a>
            <span class="m-l-xs ">{{$note->title}}</span>
        @endif
    </div>
    <div class="pull-right">
        <a href="{{route('notes.destroy', ['id' => $note->id])}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
    </div>
    <div class="clearfix"></div>
</li>
