<?php

namespace App\Http\Controllers\Admin\Website;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\Website\PageService;
use App\Http\Requests\Admin\Website\Page\PageStoreRequest;
use App\Http\Requests\Admin\Website\Page\PageUpdateRequest;

class PageController extends Controller
{
    use ApiResponse;
    private $page_service;

    public function __construct(PageService $page_service)
    {
        $this->page_service = $page_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->page_service->dataTable();
        }

        return view('admin.pages.website.page.index');
    }

    public function showCreateForm()
    {
        return view('admin.pages.website.page.create');
    }

    public function create(PageStoreRequest $request)
    {
        $result = $this->page_service->store($request->validated());

        if ($result) {
            return redirect()->route('admin.website.page.index')->with('success', $this->page_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->page_service->message);
    }

    public function edit(Page $page)
    {
        abort_unless($page, 404);

        return view('admin.pages.website.page.edit', [
            'page' => $page,
        ]);
    }

    public function update(Page $page, PageUpdateRequest $request)
    {
        abort_unless($page, 404);
        $result = $this->page_service->update($page, $request->validated());

        if ($result) {
            return redirect()->route('admin.website.page.index', $page->id)->with('success', $this->page_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->page_service->message);
    }

    public function destroy(Page $page)
    {
        abort_unless($page, 404);
        $result = $this->page_service->delete($page);

        if ($result) {
            return redirect()->route('admin.website.page.index', $page->id)->with('success', $this->page_service->message);
        }

        return back()->with('error', $this->page_service->message);
    }

    public function changeStatus(Request $request, Page $page)
    {
        abort_unless($page, 404);
        $result = $this->page_service->changeStatus($page);

        if ($result) {
            return redirect()->route('admin.website.page.index')->with('success', $this->page_service->message);
        }

        return back()->withInput($request->all())->with('error', $this->page_service->message);
    }
}
