<div class="ui segment">

    <h3 class="ui header">{{ $title or trans('gitscrum.small-notes')}}</h3>

    @if(isset($percentage))
        @include('partials.boxes.progress-bar', [ 'percentage' => $percentage, 'title' => trans('gitscrum.completed')])
    @endif

    <div class="ui list">
        @foreach( $list->notes as $item )
        <div class="item">
            <img class="ui avatar image" src="{{$item->user->avatar}}">
            <div class="content">
                <a class="header">{{$item->user->username}}</a>
                <div class="description">{{$item->title}}</div>
            </div>
        </div>
        @endforeach
    </div>

    <br>

    <form action="{{route('notes.store')}}" method="post" id="frm_notes_title">
        {{ csrf_field() }}
        <input type="hidden" name="noteable_type" value="{{$type}}">
        <input type="hidden" name="noteable_id" value="{{$list->id}}">

        <div class="ui mini form">
            <div class="field">
                <input placeholder="{{trans('gitscrum.write')}}..." name="frm_notes_title" autocomplete="off"
                       type="text">
            </div>
            <button type="submit" class="mini ui button yellow">{{trans('gitscrum.add')}}</button>
        </div>

    </form>

    {{--
    <div class="dd" id="nestable">
        <ul class="list-group">

            <li class="list-group-item" data-id="{{$note->id}}">
                <a href="{{route('notes.destroy', ['id' => $note->id])}}" class="pull-right"><i class="fa fa-trash" aria-hidden="true"></i></a>
                @if($note->closed_at)
                    <a href="{{route('notes.update', ['slug'=>$note->slug])}}">
                        <i class="fa fa-check-square" aria-hidden="true"></i></a>
                    <span class="todo-completed">{{$note->title}}</span>
                    <p><small><a href="{{route('user.profile', ['username'=>$note->closedUser->username])}}">
                                {{$note->closedUser->username}}</a> {{trans('gitscrum.closed')}}</small></p>
                @else
                    <a href="{{route('notes.update', ['slug'=>$note->slug])}}"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                    <span>{{$note->title}}</span>
                @endif
            </li>

            @each('partials.lists.notes-min', $list->notes, 'note')
        </ul>
    </div>

    @include('partials.forms.note', ['id'=> $list->id, 'type'=> $type])
    --}}

</div>
