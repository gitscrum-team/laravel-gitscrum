<li class="list-group-item" data-id="{{$note->id}}">
    <a href="{{route('notes.destroy', ['id' => $note->id])}}" class="pull-right"><i class="fa fa-trash" aria-hidden="true"></i></a>
    @if($note->closed_at)
        <a href="{{route('notes.update', ['slug'=>$note->slug])}}">
            <i class="fa fa-check-square" aria-hidden="true"></i></a>
        <span class="todo-completed">{{$note->title}}</span>
        <p><small><a href="{{route('user.profile', ['username'=>$note->closedUser->username])}}">
        {{$note->closedUser->username}}</a> {{trans('closed')}}</small></p>
    @else
        <a href="{{route('notes.update', ['slug'=>$note->slug])}}"><i class="fa fa-square-o" aria-hidden="true"></i></a>
        <span>{{$note->title}}</span>
    @endif
</li>
