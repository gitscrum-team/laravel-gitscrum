<form action="{{route('notes.store')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="noteable_type" value="{{$type}}">
    <input type="hidden" name="noteable_id" value="{{$id}}">

    <div class="form-group">
        <div class="input-group">
            <input class="form-control" name="title" type="text" autocomplete="off">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">{{trans('Add')}}</button>
            </span>
        </div>
    </div>

</form>
