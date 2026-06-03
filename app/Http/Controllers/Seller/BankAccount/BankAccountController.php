<?php

namespace App\Http\Controllers\Seller\BankAccount;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Seller\BankAccount\StoreRequest;
use App\Http\Requests\Seller\BankAccount\UpdateRequest;
use App\Library\Services\Seller\BankAccount\BankServices;

class BankAccountController extends Controller
{
    use ApiResponse;
    private $bank_service;

    public function __construct(BankServices $bank_service)
    {
        $this->bank_service = $bank_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->bank_service->dataTable();
        }

        return view('seller.pages.bank-account.index');
    }

    public function create()
    {
        return view('seller.pages.bank-account.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $result = $this->bank_service->store($validatedData);


        if ($result) {
            return redirect()->route('seller.bankAccount.index')->with('success', $this->bank_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->bank_service->message);
    }

    public function edit(BankAccount $bank_account)
    {
        return view('seller.pages.bank-account.edit', [
            'bank'    => $bank_account
        ]);
    }

    public function show(BankAccount $bank_account)
    {
        return view('seller.pages.bank-account.show', [
            'bank'    => $bank_account
        ]);
    }

    public function update(UpdateRequest $request, BankAccount $bank_account): RedirectResponse
    {
        $result = $this->bank_service->update($bank_account, $request->validated());

        if ($result) {
            return redirect()->route('seller.bankAccount.index')->with('success', $this->bank_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->bank_service->message);
    }

    public function destroy(BankAccount $bank_account): RedirectResponse
    {
        abort_unless($bank_account, 404);

        $result = $this->bank_service->delete($bank_account);

        if ($result) {
            return redirect()->route('seller.bankAccount.index')->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }
}
