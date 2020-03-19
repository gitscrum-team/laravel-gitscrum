<form action="{{route('notes.store')}}" method="post" id="frm_notes_title">

    {{ csrf_field() }}

    <input type="hidden" name="noteable_type" value="{{$type}}">
    <input type="hidden" name="noteable_id" value="{{$id}}">

    <div class="form-group">
        <input class="form-control" name="frm_notes_title" type="text" autocomplete="off" placeholder="{{ trans('gitscrum.title') }}">
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <input class="form-control" name="frm_notes_hours" type="number" min="1" max="8" autocomplete="off" value="1" placeholder="{{ trans('gitscrum.hours') }}">
            </div>
            <div class="col-xs-12 col-sm-4">
                <button id="frm_notes_submit" class="btn btn-default btn-block btn-loader" type="submit">{{ trans('gitscrum.add') }}</button>
            </div>
        </div>
    </div>

</form>
