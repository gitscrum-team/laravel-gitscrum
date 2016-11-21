<form action="{{route('comments.store')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="commentable_type" value="{{$type}}">
    <input type="hidden" name="commentable_id" value="{{$id}}">
    <a href="{{route('user.profile', ['username'=>Auth::user()->username])}}" class="pull-left">
        <img alt="{{Auth::user()->username}}" class="img-rounded" src="{{Auth::user()->avatar}}">
    </a>
    <div class="media-body">
        <textarea class="form-control" name="comment" placeholder="{{_('Write comment...')}}"></textarea>
    </div>
    <div class="m-t-sm">
        <button type="submit" class="btn btn-success btn-xs pull-right">{{_('Comment')}}</button>
        <div class="clearfix"></div>
    </div>
</form>
