<?php

namespace App\Http\Controllers\Public;

use Mail;
use Throwable;
use App\Mail\ContactMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Contact\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.pages.contactUs.index');
    }


    public function store(ContactRequest $request)
    {
        $email = ! empty(settings('email')) ? settings('email') : 'info@websolutionfirm.com'; // Update it later
        $mailData = $request->all();

        ContactMessage::create($mailData);

        try {
            Mail::to($email)->send(new ContactMail($mailData));

            session()->flash('success', 'Your mail sent successfully.');

            return back();
        } catch (Throwable $t) {
            Log::error($t->getMessage());

            session()->flash('error', 'Sorry, Something Went Wrong.');

            return back();
        }
    }
}
