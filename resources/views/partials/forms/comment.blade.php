<div class="frm-comment">

    @if(isset($route))
        <form action="{{route($route, ['id'=>$comment->id, '#tab-comments'])}}" method="post">
    @else
        <form action="{{route('comments.store', ['#tab-comments'])}}" method="post">
    @endif

        {{ csrf_field() }}
        <input type="hidden" name="commentable_type" value="{{$type}}">
        <input type="hidden" name="commentable_id" value="{{$id}}">
        <div class="media-body">
            <textarea class="form-control" name="comment" placeholder="{{trans('Write comment...')}}">{{@$comment->comment}}</textarea>
        </div>
        <div class="mtm">
            <button type="submit" class="btn btn-success btn-xs pull-right btn-loader">{{trans('Comment')}}</button>
            <div class="clearfix"></div>
        </div>
    </form>
</div>
