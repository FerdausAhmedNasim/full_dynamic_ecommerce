<?php

namespace App\Http\Controllers\Admin\User\Customer;

use App\Models\User;
use App\Models\Member;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\User\CustomerService;

class CustomerProfileController extends Controller
{
    use ApiResponse;
    private $customer_service;

    public function __construct(CustomerService $customer_service)
    {
        $this->customer_service = $customer_service;
    }

    public function showDetails(User $user)
    {
        abort_unless($user, 404);

        return view('admin.pages.user.customer.partials.details.details', compact('user'));
    }

    public function showAddress(Member $user)
    {
        abort_unless($user, 404);

        $address = $user?->address;

        $user_type = 'members';

        return view('admin.pages.user.customer.address', compact('user', 'address', 'user_type'));
    }
}
