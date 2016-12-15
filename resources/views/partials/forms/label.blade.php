<form action="{{route('labels.store')}}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="labelable_type" value="{{$type}}">
    <input type="hidden" name="labelable_id" value="{{$id}}">

    <div class="form-group mbx pbx">
        <div class="input-group">
            <input class="form-control" name="title" type="text" autocomplete="off">
            <span class="input-group-btn">
                <button class="btn btn-default btn-loader" type="submit">{{trans('Add')}}</button>
            </span>
        </div>
    </div>

</form>
