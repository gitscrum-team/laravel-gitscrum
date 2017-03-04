<form action="{{route('notes.store')}}" method="post" id="frm_notes_title">
    {{ csrf_field() }}
    <input type="hidden" name="noteable_type" value="{{$type}}">
    <input type="hidden" name="noteable_id" value="{{$id}}">

    <div class="form-group">
        <div class="input-group">
            <input class="form-control" name="frm_notes_title" type="text" autocomplete="off">
            <span class="input-group-btn">
                <button id="frm_notes_submit" class="btn btn-default btn-loader" type="submit">{{trans('gitscrum.add')
                }}</button>
            </span>
        </div>
    </div>

</form>
