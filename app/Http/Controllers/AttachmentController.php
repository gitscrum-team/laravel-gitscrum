<?php

namespace GitScrum\Http\Controllers;

use GitScrum\Http\Requests\AttachmentRequest;
use GitScrum\Models\Attachment;

class AttachmentController extends Controller
{
    public function store(AttachmentRequest $request)
    {
        $imageName = time().'.'.$request->attachment->getClientOriginalExtension();

        $data = [
            'attachmentable_id' => $request->attachmentable_id,
            'attachmentable_type' => $request->attachmentable_type,
            'filename_original' => $request->attachment->getClientOriginalName(),
            'filename_new' => $imageName,
            'mimetype' => $request->attachment->getMimeType(),
            'size' => $request->attachment->getSize(),
        ];

        $request->attachment->move(public_path('attachments'), $imageName);

        Attachment::create($data);

        return back()->with('success', trans('File uploaded successfully'));
    }
}
