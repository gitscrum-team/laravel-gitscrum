<form action="{{route('labels.store')}}" method="post" class="form-group">
    <div class="input-group">
        {{ csrf_field() }}
        <input type="hidden" name="labelable_type" value="{{$type}}">
        <input type="hidden" name="labelable_id" value="{{$id}}">
        <input class="form-control input-sm" name="title" type="text">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary btn-sm">{{_('Add')}}</button>
        </span>
    </div>
</form>
