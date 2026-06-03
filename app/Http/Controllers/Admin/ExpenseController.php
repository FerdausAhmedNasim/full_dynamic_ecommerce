<?php

namespace App\Http\Controllers\Admin;

use App\Library\Enum;
use App\Models\Expense;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\ExpenseService;
use App\Http\Requests\Admin\Expense\StoreRequest;
use App\Http\Requests\Admin\Expense\UpdateRequest;

class ExpenseController extends Controller
{
    use ApiResponse;
    private $expense_service;

    public function __construct(ExpenseService $expense_service)
    {
        $this->expense_service = $expense_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->expense_service->dataTable();
        }

        return view('admin.pages.expense.index');
    }

    public function create(): View
    {
        return view('admin.pages.expense.create', [
            'user_type'  => auth()->user()->user_type,
            'categories' => getDropdown(Enum::CONFIG_DROPDOWN_EXPENSE_CATEGORY),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $result = $this->expense_service->store($request->validated());

        if($result) {
            return redirect()->route('admin.expense.index')->with('success', $this->expense_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->expense_service->message);
    }

    public function edit(Expense $expense): View
    {
        return view('admin.pages.expense.edit', [
            'user_type'  => auth()->user()->user_type,
            'expense'    => $expense,
            'categories' => getDropdown(Enum::CONFIG_DROPDOWN_EXPENSE_CATEGORY),
        ]);
    }

    public function update(UpdateRequest $request, Expense $expense): RedirectResponse
    {
        $result = $this->expense_service->update($expense, $request->validated());

        if($result) {
            return redirect()->route('admin.expense.index')->with('success', $this->expense_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->expense_service->message);
    }

    public function destroy(Expense $expense): RedirectResponse
    {
        abort_unless($expense, 404);
        $result = $this->expense_service->delete($expense);

        if($result) {
            return redirect()->back()->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');

    }
}
