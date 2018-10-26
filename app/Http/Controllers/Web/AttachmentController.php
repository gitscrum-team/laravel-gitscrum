<?php

namespace GitScrum\Http\Controllers\Web;

use GitScrum\Http\Requests\AttachmentRequest;
use GitScrum\Models\Attachment;

class AttachmentController extends Controller
{
    public function store(AttachmentRequest $request)
    {
        resolve('AttachmentService')->upload($request);
        return back()->with('success', trans('gitscrum.file-uploaded-successfully'));
    }
}
