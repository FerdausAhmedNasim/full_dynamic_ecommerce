<?php

namespace App\Library\Services\Admin;

use Exception;
use App\Models\Email;
use App\Library\Helper;
use App\Mail\DefaultMail;
use App\Models\EmailHistory;
use App\Models\EmailRecipient;
use Illuminate\Support\Facades\Mail;

class EmailService extends BaseService
{
    public static function createHistory(array $data): bool
    {
        try {
            EmailHistory::create($data);

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return false;
        }
    }

    public static function sendMail(array $data): bool
    {
       try {
            self::createHistory($data);

            if (isset($data['ticket_email']) && $data['ticket_email']) {
                Mail::to($data['ticket_email'])->send(new DefaultMail($data['subject'], $data['message']));
            }

            Mail::to($data['email'])->send(new DefaultMail($data['subject'], $data['message']));

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return false;
        }
    }

    public static function updateEmail(array $emailData, array $users, int $post_id): bool
    {
        try {
            EmailRecipient::where('post_id', $post_id)->delete();
            Email::insert($emailData, $users, $post_id);

            return true;
        } catch (Exception $e) {
            Helper::log($e);

            return false;
        }
    }
}
