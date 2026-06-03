<?php

namespace App\Http\Controllers\Admin\User\Seller;

use App\Models\SellerCategory;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\Seller\SellerCategory\CreateRequest;
use App\Http\Requests\Admin\User\Seller\SellerCategory\UpdateRequest;
use Illuminate\Http\RedirectResponse;
use App\Library\Services\Admin\User\SellerCategoryService;
use App\Models\Category;

class SellerCategoryController extends Controller
{
    use ApiResponse;

    private $sellerCategoryService;

    public function __construct(SellerCategoryService $sellerCategoryService)
    {
        $this->sellerCategoryService = $sellerCategoryService;
    }

    public function index(User $user, Request $request)
    {
        if ($request->ajax()) {
            return $this->sellerCategoryService->dataTable($user->id);
        }

        return view('admin.pages.user.seller.seller_category.index', compact('user'));
    }

    public function create(User $user): View
    {
        return view('admin.pages.user.seller.seller_category.create', [
            'user' => $user,
            'categories' => Category::active()->get(),
        ]);
    }

    public function store(CreateRequest $request, User $user): RedirectResponse
    {
        $result = $this->sellerCategoryService->store($request->validated(), $user->id);

        if ($result) {
            return redirect(route('admin.user.seller.category.index', $user->id))->with('success', $this->sellerCategoryService->message);
        }

        return back()->withInput($request->all())->with('error', $this->sellerCategoryService->message);
    }

    public function edit(User $user, SellerCategory $sellerCategory): View
    {
        abort_unless($sellerCategory, 404);

        return view('admin.pages.user.seller.seller_category.edit', [
            'sellerCategory' => $sellerCategory,
            'user' => $user,
            'categories' => Category::active()->get(),
        ]);
    }

    public function update(UpdateRequest $request, User $user, SellerCategory $sellerCategory): RedirectResponse
    {
        abort_unless($sellerCategory, 404);

        $result = $this->sellerCategoryService->update($request->validated(), $sellerCategory);

        if ($result) {
            return redirect(route('admin.user.seller.category.index', $user->id))->with('success', $this->sellerCategoryService->message);
        }

        return back()->withInput($request->all())->with('error', $this->sellerCategoryService->message);
    }

    public function destroy(User $user, SellerCategory $sellerCategory): RedirectResponse
    {
        abort_unless($sellerCategory, 404);

        $sellerCategory->delete();

        return redirect(route('admin.user.seller.category.index', $user->id))->with('success', 'Successfully Deleted !!!');
    }
}
