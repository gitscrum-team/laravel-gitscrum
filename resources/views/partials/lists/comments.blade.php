<div class="feed-element">
    <a href="{{route('user.profile', ['username'=>$comment->user->username])}}" class="pull-left">
        <img alt="{{$comment->user->username}}" class="img-rounded avatar-min" src="{{$comment->user->avatar}}">
    </a>
    <div class="media-body ">
        <small class="pull-right comment-dateforhumans">{{$comment->dateforhumans}}</small>
        <a href="{{route('user.profile', ['username'=>$comment->user->username])}}"><strong>{{$comment->user->username}}</strong></a> {{_('commented')}} <br>
        <small class="text-muted"></small>
        <div class="well mbn pbn">{!! nl2br(e($comment->comment)) !!}</div>
        <div>
            <a href="{{route('comments.destroy', ['id' => $comment->id])}}" class="font-bold">
                <i class="fa fa-trash" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
