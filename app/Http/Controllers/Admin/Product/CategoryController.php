<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\Product\CategoryService;
use App\Http\Requests\Admin\Product\Category\CategoryStoreRequest;
use App\Http\Requests\Admin\Product\Category\CategoryUpdateRequest;

class CategoryController extends Controller
{
    use ApiResponse;

    private $category_service;

    public function __construct(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->category_service->dataTable();
        }

        return view('admin.pages.product.category.index', [
            'categories' => Category::whereNull('parent_id')
                                            ->with('childrenCategories.childrenCategories.childrenCategories')
                                            ->get(),
        ]);
    }

    public function store(CategoryStoreRequest $request)
    {
        $result = $this->category_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.category.index')->with('success', $this->category_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->category_service->message);
    }

    public function edit(Category $category)
    {
        abort_unless($category, 404);

        return view('admin.pages.product.category.edit', [
            'category'   => $category,
            'categories' => Category::whereNull('parent_id')
                                            ->with('childrenCategories')
                                            ->with('childrenCategories.childrenCategories')
                                            ->with('childrenCategories.childrenCategories.childrenCategories')
                                            ->get(),
        ]);
    }

    public function update(Category $category, CategoryUpdateRequest $request)
    {
        abort_unless($category, 404);
        $result = $this->category_service->update($category, $request->validated());

        if ($result) {
            return redirect()->route('admin.category.index', $category->id)->with('success', $this->category_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->category_service->message);
    }

    public function destroy(Category $category)
    {
        abort_unless($category, 404);

        // if ($category->parent) {
        //     return redirect()->back()->with('error', "Could not deleted! This category has parent category.");
        // }

        if (count($category->children)) {
            return redirect()->back()->with('error', "Could not deleted! This category has child category.");
        }

        if ($category->products()->count()) {
            return redirect()->back()->with('error', "Could not deleted! This category has products.");
        }

        $result = $this->category_service->delete($category);

        if ($result) {
            return redirect()->route('admin.category.index', $category->id)->with('success', $this->category_service->message);
        }

        return back()->with('error', $this->category_service->message);
    }

    public function changeStatus(Request $request, Category $category)
    {
        abort_unless($category, 404);
        $result = $this->category_service->changeStatus($category);

        if ($result) {
            return redirect()->route('admin.category.index')->with('success', $this->category_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->category_service->message);
    }

    public function changeFeatured(Request $request, Category $category)
    {
        abort_unless($category, 404);
        $result = $this->category_service->changeFeatured($category);

        if ($result) {
            return redirect()->route('admin.category.index')->with('success', $this->category_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->category_service->message);
    }
}
