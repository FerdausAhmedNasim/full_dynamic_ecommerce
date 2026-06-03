<?php

namespace App\Http\Controllers\Public\Dashboard;

use App\Models\Payment;
use App\Models\MembershipPlan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AccountsController extends Controller
{
    public function payments()
    {
        $payment_history = Payment::where('payment_by', auth()->user()->member->id)->orderBy('id', 'desc')->get();

        return view('public.member_dashboard.accounts.index', [
            'payment_history' => $payment_history
        ]);
    }

    public function paymentShow(Payment $payment)
    {
        abort_unless($payment->payment_by == auth()->user()->member->id, 404);

        return view('public.member_dashboard.accounts.show', [
            'payment' => $payment->load('memberSubscriptions.member.user', 'memberSubscriptions.subscription', 'team.teamAnglers.member.user'),
        ]);
    }

    public function payNow()
    {
        $membership_types = MembershipPlan::whereIsActive(1)->get();
        $due = Auth::user() ? Auth::user()->membership->amount : 0;

        return view('public.member_dashboard.accounts.pay', [
            'membership_types' => $membership_types,
            'due'              => $due,
        ]);
    }
}
