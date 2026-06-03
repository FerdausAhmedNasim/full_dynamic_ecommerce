<?php

namespace App\Http\Controllers\Public\Dashboard;

use Exception;
use App\Library\Enum;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\MembershipPlan;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        return view('public.member_dashboard.accounts.stripe', [
            'data' => $request->all(),
        ]);
    }

    public function buyNow(Subscription $subscription)
    {
        $data['user_id'] = auth()->id();
        $data['subscription_id'] = $subscription->id;
        $data['expired_date'] = now()->addMonths($subscription->available_time);
        $data['amount'] = $subscription->discount_price;
        $data['token'] = '123456789';

        DB::beginTransaction();

        try {
            UserSubscription::create($data);
            Auth::user()->status = Enum::USER_STATUS_PAID;
            Auth::user()->save();

            DB::commit();

            return redirect()->route('public.member.dashboard.index')->with('success', __('Payment Completed Successfully'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $membership_type = MembershipPlan::whereId($request->membership_id)->first();

        $reqData = $request->all();
        $reqData['amount'] = $membership_type->amount;

        DB::beginTransaction();

        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $stripe->charges->create([
                "amount"      => $reqData['amount'] * 100,
                "currency"    => "NZD",
                "source"      => $request->stripeToken,
                "description" => "Payment Completed Successfully",
            ]);

            Payment::stripePayment($reqData);

            DB::commit();

            return redirect()->route('public.member.dashboard.index')->with('success', __('Payment Completed Successfully'));

        } catch (Exception $e) {
            return redirect()->route('public.member.dashboard.payment.index')->with('error', $e->getMessage());
        } catch (\Stripe\Exception\CardException $e) {
            error_log("A payment error occurred: {$e->getError()->message}");

            return back()->withInput(request()->all())->with('error', 'A payment error occurred.');
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            error_log("An invalid request occurred.");

            return back()->withInput(request()->all())->with('error', 'An invalid request occurred.');
        }
    }

}
