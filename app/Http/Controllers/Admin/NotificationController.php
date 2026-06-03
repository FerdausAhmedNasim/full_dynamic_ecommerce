<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Library\Enum;
use App\Library\Response;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\NotificationRecipient;
use App\Events\Notification\CreateEvent;
use App\Events\Notification\DeleteEvent;
use App\Library\Services\Admin\NotificationService;
use App\Http\Requests\Admin\Notification\CreateRequest;

class NotificationController extends Controller
{
    use ApiResponse;

    private $notification_service;

    public function __construct(NotificationService $notification_service)
    {
        $this->notification_service = $notification_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filterRequest = $request->only(['is_for_emp', 'is_for_member']);

            return $this->notification_service->dataTable($filterRequest);
        }

        return view('admin.pages.notification.index');
    }

    public function showCreateForm()
    {
        return view('admin.pages.notification.create', [
            'notification_types' => getDropdown(Enum::CONFIG_DROPDOWN_NOTIFICATION_TYPE),
            'user_types'         => Enum::getUserType(),
            'user_status'        => Enum::getUserStatus(),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $result = $this->notification_service->createNotification($request->validated());

        event(new CreateEvent($this->notification_service->data));

        if ($result) {
            return redirect()->route('admin.notification.index')->with('success', $this->notification_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->notification_service->message);
    }

    public function show(Notification $notification, Request $request)
    {
        if ($request->ajax()) {

            return $this->notification_service->recipientDataTable($notification);
        }

        return view('admin.pages.notification.show', [
            'notification' => $notification,
        ]);
    }

    public function resend(NotificationRecipient $recipient)
    {
        try {
            $recipient->update(['is_try' => 0]);

            return Response::success(__('Successfully Sent In Email Queue'));
        } catch (Throwable $e) {

            return Response::error(__('Something went wrong! please try again.'));
        }
    }

    public function deleteApi(Request $request, Notification $notification)
    {
        $result = $this->notification_service->deleteNotification($notification);
        event(new DeleteEvent($this->notification_service->data));

        if ($result && $request->ajax()) {
            return $this->response($result, $this->notification_service->message);
        } elseif($result && !$request->ajax()) {
            return redirect()->route('admin.notification.index')->with('success', $this->notification_service->message);
        }

        return redirect()->route('admin.notification.index')->with('error', 'Something went wrong.');
    }
}
