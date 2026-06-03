<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use Illuminate\View\View;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\AttachmentService;
use App\Http\Requests\Admin\Attachments\AttachmentStoreRequest;
use App\Http\Requests\Admin\Attachments\AttachmentUpdateRequest;

class AttachmentController extends Controller
{
    use ApiResponse;

    private $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function index(Request $request, Employee $employee)
    {
        if ($request->ajax()) {
            return $this->attachmentService->dataTable($employee);
        }

        return view('admin.pages.user.employee.attachment.index');
    }

    public function create(Request $request, Employee $employee)
    {
        return view('admin.pages.user.employee.attachment.create', compact('employee'));
    }

    public function store(AttachmentStoreRequest $request, Employee $employee)
    {
        $result = $this->attachmentService->store($request->validated(), $employee);

        if($result) {
            return redirect(route('admin.user.employee.show', $employee->id) . '#tab-attachment')->with('success', $this->attachmentService->message);
        }

        return back()->withInput($request->all())->with('error', $this->attachmentService->message);
    }

    public function show(Request $request, Attachment $attachment): View
    {
        return view('attachment.show', compact('attachment'));
    }

    public function edit(Request $request, Attachment $attachment): View
    {
        abort_unless($attachment, 404);

        return view('admin.pages.user.employee.attachment.edit', compact('attachment'));
    }

    public function update(AttachmentUpdateRequest $request, Attachment $attachment): RedirectResponse
    {
        abort_unless($attachment, 404);
        $result = $this->attachmentService->update($request->validated(), $attachment);

        if($result) {
            return redirect(route('admin.user.employee.show', $attachment->attachable_id) . '#tab-attachment')->with('success', $this->attachmentService->message);
        }

        return back()->withInput($request->all())->with('error', $this->attachmentService->message);
    }

    public function destroy(Attachment $attachment): RedirectResponse
    {
        abort_unless($attachment, 404);

        deleteFile($attachment->attachment);
        $attachment->delete();

        return redirect(route('admin.user.employee.show', $attachment->attachable_id) . '#tab-attachment')->with('success', 'Successfully Deleted');
    }
}
