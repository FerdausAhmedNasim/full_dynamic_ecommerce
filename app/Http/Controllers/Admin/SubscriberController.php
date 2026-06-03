<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\SubscriberService;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    use ApiResponse;
    private $subscriber_service;

    public function __construct(SubscriberService $subscriber_service)
    {
        $this->subscriber_service = $subscriber_service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->subscriber_service->dataTable();
        }

        return view('admin.pages.subscriber.index');
    }

    public function destroy(Subscriber $subscriber)
    {
        abort_unless($subscriber, 404);

        if($subscriber->delete()) {
            return redirect()->route('admin.subscriber.index')->with('success', 'Deleted Successfully');
        }

        return redirect()->route('admin.subscriber.index')->with('error', 'Unable to delete now');
    }

}
