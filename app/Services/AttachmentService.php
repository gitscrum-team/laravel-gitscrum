<?php

namespace GitScrum\Services;

use GitScrum\Http\Requests\AttachmentRequest;
use GitScrum\Models\Attachment;

class AttachmentService
{
    protected $folder = 'attachments';

    private function getAttachmentFolder()
    {
        return public_path($this->folder);
    }

    public function upload(AttachmentRequest $request)
    {
        $attachmentName = time().'.'.$request->attachment->getClientOriginalExtension();

        $data = [
            'attachmentable_id' => $request->attachmentable_id,
            'attachmentable_type' => $request->attachmentable_type,
            'filename_original' => $request->attachment->getClientOriginalName(),
            'filename_new' => $attachmentName,
            'mimetype' => $request->attachment->getMimeType(),
            'size' => $request->attachment->getSize(),
        ];

        $request->attachment->move($this->getAttachmentFolder(), $attachmentName);

        if (! $attachment = Attachment::create($data)) {
            return ;
        }

        return $attachment;
    }
}
