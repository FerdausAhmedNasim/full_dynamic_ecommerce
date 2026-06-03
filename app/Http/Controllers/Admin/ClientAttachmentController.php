<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;
use Illuminate\View\View;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\ClientAttachmentService;
use App\Http\Requests\Admin\Attachments\AttachmentStoreRequest;
use App\Http\Requests\Admin\Attachments\AttachmentUpdateRequest;

class ClientAttachmentController extends Controller
{
    use ApiResponse;

    private $attachmentService;

    public function __construct(ClientAttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function index(Request $request, Member $member)
    {
        if ($request->ajax()) {
            return $this->attachmentService->dataTable($member);
        }

        return view('admin.pages.member.attachment.index');
    }

    public function create(Request $request, Member $member)
    {
        return view('admin.pages.member.attachment.create', compact('member'));
    }

    public function store(AttachmentStoreRequest $request, Member $member)
    {
        $result = $this->attachmentService->store($request->validated(), $member);

        if($result) {
            return redirect(route('admin.member.show.attachment', $member->id))->with('success', $this->attachmentService->message);
        }

        return back()->withInput($request->all())->with('error', $this->attachmentService->message);
    }

    public function edit(Request $request, Attachment $attachment): View
    {
        abort_unless($attachment, 404);

        return view('admin.pages.member.attachment.edit', compact('attachment'));
    }

    public function update(AttachmentUpdateRequest $request, Attachment $attachment): RedirectResponse
    {
        abort_unless($attachment, 404);
        $result = $this->attachmentService->update($request->validated(), $attachment);

        if($result) {
            return redirect(route('admin.member.show.attachment', $attachment->attachable_id))->with('success', $this->attachmentService->message);
        }

        return back()->withInput($request->all())->with('error', $this->attachmentService->message);
    }

    public function destroy(Attachment $attachment): RedirectResponse
    {
        $member_id = $attachment->attachable_id;
        abort_unless($attachment, 404);
        $attachment->delete();

        return redirect(route('admin.member.show.attachment', $member_id))->with('success', 'Successfully Deleted');
    }
}
