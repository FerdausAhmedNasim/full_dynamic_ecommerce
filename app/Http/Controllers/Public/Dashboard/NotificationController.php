<?php

namespace App\Http\Controllers\Public\Dashboard;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Models\NotificationRecipient;

class NotificationController extends Controller
{
    public function index()
    {
        // $notification_recipients = NotificationRecipient::with('notification', 'user')
        //                             ->where('user_id', authId())
        //                             ->whereHas('notification', function ($q) {
        //                                 $q->where('send_date', '<=', now());
        //                             })->paginate(10);

        //$notification_recipients = Notification::where('is_for_customer', 1)->latest()->paginate(10);

        $notification_recipients = Notification::with('user', 'recipients')
        ->whereHas('recipients', function ($q) {
            $q->where('user_id', authId());
        })
        ->paginate(10);

        return view('public.member_dashboard.notification.index', [
            'notification_recipients' => $notification_recipients,
        ]);
    }

    public function show(Notification $notification)
    {
        abort_unless($notification, 404);

        return view('public.member_dashboard.notification.show', [
            'notification_recipient' => $notification,
        ]);
    }

    private function statusHtml(NotificationRecipient $notification_recipient)
    {
        if ($notification_recipient->is_sent == 0 && $notification_recipient->is_try == 1) {
            $class = 'danger';
            $status = 'Failed';
        } elseif ($notification_recipient->is_sent == 1 && $notification_recipient->is_try == 1) {
            $class = 'success';
            $status = 'Sent';
        } else {
            $class = 'warning';
            $status = 'Unsent';
        }

        return '<label class="' . $class . '">' . $status . '</label>';
    }
}
