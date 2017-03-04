<form action="{{ route('attachments.store') }}" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="attachmentable_type" value="{{$type}}">
    <input type="hidden" name="attachmentable_id" value="{{$id}}">
    <div class="btn btn-default btn-file btn-block">
        {{trans('Browse ')}}
        <input type="file" class="btn-file-attachment" name="attachment" autocomplete="off">
    </div>
    <span class='label label-info' id="file-attachment"></span>
    <div class="mtm mbl">
        <button type="submit" class="btn btn-sm btn-success hidden btn-loader" id="btn-file-attachment-upload">{{trans('Upload file')}}</button>
    </div>
</form>
