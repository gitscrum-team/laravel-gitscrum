<form action="{{route('comments.store', ['#tab-comments'])}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="commentable_type" value="{{$type}}">
    <input type="hidden" name="commentable_id" value="{{$id}}">
    <div class="media-body">
        <textarea class="form-control" name="comment" placeholder="{{_('Write comment...')}}"></textarea>
    </div>
    <div class="mtm">
        <button type="submit" class="btn btn-success btn-xs pull-right">{{_('Comment')}}</button>
        <div class="clearfix"></div>
    </div>
</form>
