<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\WithdrawService;
use App\Http\Requests\Admin\Withdraw\WithdrawStoreRequest;
use App\Http\Requests\Admin\Withdraw\WithdrawUpdateRequest;

class WithdrawController extends Controller
{
    use ApiResponse;

    private $withdraw_service;

    public function __construct(WithdrawService $withdraw_service)
    {
        $this->withdraw_service = $withdraw_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->withdraw_service->dataTable();
        }

        return view('admin.pages.withdraw.index');
    }

    public function create()
    {
        return view('admin.pages.withdraw.create', [
            'branches' => Branch::with('withdraws')->get(),
        ]);
    }

    public function store(WithdrawStoreRequest $request)
    {
        $result = $this->withdraw_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.withdraw.index')->with('success', $this->withdraw_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->withdraw_service->message);
    }

    public function edit(Withdraw $withdraw)
    {
        abort_unless($withdraw, 404);

        return view('admin.pages.withdraw.edit', [
            'withdraw' => $withdraw,
            'branches' => Branch::with('balance')->get(),
        ]);
    }

    public function update(Withdraw $withdraw, WithdrawUpdateRequest $request)
    {
        abort_unless($withdraw, 404);
        $result = $this->withdraw_service->update($withdraw, $request->validated());

        if ($result) {
            return redirect()->route('admin.withdraw.index', $withdraw->id)->with('success', $this->withdraw_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->withdraw_service->message);
    }

    public function destroy(Withdraw $withdraw)
    {
        abort_unless($withdraw, 404);
        // if (count($withdraw->children)) {
        //     return redirect()->back()->with('error', "Could not deleted! This withdraw has child withdraw.");
        // }
        $withdraw->delete();

        return redirect()->route('admin.withdraw.index')->with('success', __('Successfully Deleted'));
    }
}
