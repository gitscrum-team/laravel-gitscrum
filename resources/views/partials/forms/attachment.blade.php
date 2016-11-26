<form action="{{ route('attachments.store') }}" enctype="multipart/form-data" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="attachmentable_type" value="{{$type}}">
    <input type="hidden" name="attachmentable_id" value="{{$id}}">

        <div class="btn btn-default btn-file btn-block">

            {{_('Browse ')}}

            <input type="file" class="btn-file-attachment" name="attachment" size="40"  onchange=''>
        </div>

        <span class='label label-info' id="file-attachment"></span>

        <div class="mtm mbl">

            <button type="submit" class="btn btn-sm btn-success hidden" id="btn-file-attachment-upload">{{_('Upload file')}}</button>

        </div>

</form>
