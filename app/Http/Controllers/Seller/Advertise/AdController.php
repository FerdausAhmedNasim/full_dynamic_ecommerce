<?php

namespace App\Http\Controllers\Seller\Advertise;

use App\Library\Enum;
use App\Models\Product;
use App\Models\Advertise;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Models\AdvertiseLocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Seller\Advertise\StoreRequest;
use App\Library\Services\Seller\Advertise\AdService;
use App\Http\Requests\Seller\Advertise\UpdateRequest;

class AdController extends Controller
{
    use ApiResponse;

    private $ad_service;

    public function __construct(AdService $ad_service)
    {
        $this->ad_service = $ad_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ad_service->dataTable();
        }

        return view('seller.pages.advertise.index');
    }

    public function create(): View
    {
        $products = Product::with('productLanguages')
                    ->approved()->published()
                    ->where('seller_id', authSellerId())
                    ->get();

        return view('seller.pages.advertise.create', [
            'products' => $products,
            'locations' => AdvertiseLocation::active()->get(),
        ]);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $result = $this->ad_service->store($validatedData);

        if($result) {
            return redirect()->route('seller.ad.index')->with('success', $this->ad_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ad_service->message);
    }

    public function edit(Advertise $ad): View
    {
        $products = Product::with('productLanguages')
                    ->approved()->published()
                    ->where('seller_id', authSellerId())
                    ->get();

        return view('seller.pages.advertise.edit', [
            'ad'        => $ad,
            'products'  => $products,
            'locations' => AdvertiseLocation::active()->get(),
        ]);
    }

    public function update(UpdateRequest $request, Advertise $ad): RedirectResponse
    {
        $result = $this->ad_service->update($ad, $request->validated());

        if($result) {
            return redirect()->route('seller.ad.index')->with('success', $this->ad_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ad_service->message);
    }

    public function destroy(Advertise $ad): RedirectResponse
    {
        abort_unless($ad, 404);

        $result = $this->ad_service->delete($ad);

        if($result) {
            return redirect()->back()->with('success', "Successfully Delete");
        }

        return back()->with('error', 'Unable to delete now');
    }

    public function changeStatus(Request $request, AdvertiseLocation $ad_location)
    {
        $result = $this->ad_service->changeStatus($ad_location);

        if ($result) {
            return redirect()->back()->with('success', $this->ad_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->ad_service->message);
    }
}
