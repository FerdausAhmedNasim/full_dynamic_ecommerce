<?php

namespace App\Http\Controllers\Admin\Website;

use App\Models\Benefit;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\Website\BenefitService;
use App\Http\Requests\Admin\Website\Benefit\BenefitStoreRequest;
use App\Http\Requests\Admin\Website\Benefit\BenefitUpdateRequest;

class BenefitController extends Controller
{
    use ApiResponse;

    private $benefit_service;

    public function __construct(BenefitService $benefit_service)
    {
        $this->benefit_service = $benefit_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->benefit_service->dataTable();
        }

        return view('admin.pages.website.benefit.index');
    }

    public function store(BenefitStoreRequest $request)
    {
        $result = $this->benefit_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.website.benefit.index')->with('success', $this->benefit_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->benefit_service->message);
    }

    public function edit(Benefit $benefit)
    {
        abort_unless($benefit, 404);

        return view('admin.pages.website.benefit.edit', [
            'benefit' => $benefit,
        ]);
    }

    public function update(Benefit $benefit, BenefitUpdateRequest $request)
    {
        abort_unless($benefit, 404);
        $result = $this->benefit_service->update($benefit, $request->validated());

        if ($result) {
            return redirect()->route('admin.website.benefit.index', $benefit->id)->with('success', $this->benefit_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->benefit_service->message);
    }

    public function destroy(Benefit $benefit)
    {
        abort_unless($benefit, 404);
        $result = $this->benefit_service->delete($benefit);

        if ($result) {
            return redirect()->route('admin.website.benefit.index', $benefit->id)->with('success', $this->benefit_service->message);
        }

        return back()->with('error', $this->benefit_service->message);
    }

    public function changeStatus(Request $request, Benefit $benefit)
    {
        abort_unless($benefit, 404);
        $result = $this->benefit_service->changeStatus($benefit);

        if ($result) {
            return redirect()->route('admin.website.benefit.index')->with('success', $this->benefit_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->benefit_service->message);
    }
}
