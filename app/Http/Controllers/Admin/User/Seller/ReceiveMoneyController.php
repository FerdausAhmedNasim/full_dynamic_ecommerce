<?php

namespace App\Http\Controllers\Admin\User\Seller;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\User\ReceiveMoneyService;
use App\Http\Requests\Admin\User\Seller\ReceiveMoney\CreateRequest;
use App\Models\BalanceHistory;

class ReceiveMoneyController extends Controller
{
    use ApiResponse;

    private $receiveMoneyService;

    public function __construct(ReceiveMoneyService $receiveMoneyService)
    {
        $this->receiveMoneyService = $receiveMoneyService;
    }

    public function index(User $user, Request $request)
    {
        if ($request->ajax()) {
            return $this->receiveMoneyService->dataTable($user->id);
        }

        return view('admin.pages.user.seller.receive_money.index', compact('user'));
    }

    public function create(User $user): View
    {
        return view('admin.pages.user.seller.receive_money.create', [
            'user' => $user,
        ]);
    }

    public function store(CreateRequest $request, User $user): RedirectResponse
    {
        $result = $this->receiveMoneyService->store($request->validated(), $user->id);

        if ($result) {
            return redirect(route('admin.user.seller.receive.money.index', $user->id))->with('success', $this->receiveMoneyService->message);
        }

        return back()->withInput($request->all())->with('error', $this->receiveMoneyService->message);
    }

    public function show(User $user, BalanceHistory $balanceHistory)
    {
        return response($balanceHistory);
    }

    public function balanceHistory(User $user, Request $request)
    {
        if ($request->ajax()) {
            return $this->receiveMoneyService->balanceHistory($user->id);
        }

        return view('admin.pages.user.seller.balance_history.index', compact('user'));
    }
}
