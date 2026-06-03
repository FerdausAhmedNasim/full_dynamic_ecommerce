<?php

namespace App\Http\Controllers\Seller;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\NotificationService;

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
            return $this->notification_service->dataTableForSeller();
        }

        return view('seller.pages.notification.index');
    }

    public function show(Notification $notification)
    {
        return $notification->message;
    }
}
