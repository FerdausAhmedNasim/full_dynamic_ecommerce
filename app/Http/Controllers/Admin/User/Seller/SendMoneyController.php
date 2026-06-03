<?php

namespace App\Http\Controllers\Admin\User\Seller;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\User\SendMoneyService;
use App\Http\Requests\Admin\User\Seller\ReceiveMoney\CreateRequest;
use App\Models\BalanceHistory;

class SendMoneyController extends Controller
{
    use ApiResponse;

    private $sendMoneyService;

    public function __construct(SendMoneyService $sendMoneyService)
    {
        $this->sendMoneyService = $sendMoneyService;
    }

    public function index(User $user, Request $request)
    {
        if ($request->ajax()) {
            return $this->sendMoneyService->dataTable($user->id);
        }

        return view('admin.pages.user.seller.send_money.index', compact('user'));
    }

    public function create(User $user): View
    {
        return view('admin.pages.user.seller.send_money.create', [
            'user' => $user,
        ]);
    }

    public function store(CreateRequest $request, User $user): RedirectResponse
    {
        $result = $this->sendMoneyService->store($request->validated(), $user->id);

        if ($result) {
            return redirect(route('admin.user.seller.send.money.index', $user->id))->with('success', $this->sendMoneyService->message);
        }

        return back()->withInput($request->all())->with('error', $this->sendMoneyService->message);
    }

    public function show(User $user, BalanceHistory $balanceHistory)
    {
        return response($balanceHistory);
    }
}
