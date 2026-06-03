<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Library\Response;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Library\Services\Admin\UserService;
use App\Http\Requests\Admin\User\UpdatePasswordRequest;

class UserController extends Controller
{
    use ApiResponse;
    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function updatePasswordApi(User $user, UpdatePasswordRequest $request)
    {
        $result = $this->user_service->updatePassword($user, $request->validated());

        if($request->ajax()) {
            return $result ? Response::success($this->user_service->message) : Response::error($this->user_service->message);
        }

        return back()->with($result ? 'success' : 'error', $this->user_service->message);
    }

    public function updateStatusApi(Request $request, User $user)
    {
        $result = $this->user_service->updateStatus($user, $request->status);

        if($request->ajax()) {
            return $result ? Response::success($this->user_service->message) : Response::error($this->user_service->message);
        }

        return back()->with($result ? 'success' : 'error', $this->user_service->message);
    }

    public function deleteApi(Request $request, User $user)
    {
        $redirect = $this->user_service->checkRolePermission($user, 'user_delete');

        if (count($user->orders)) {
            if ($request->ajax()) {
                return Response::error('Customer could not deleted because of having orders.');
            }

            return redirect($redirect)->with('error', 'Customer could not deleted because of having orders.');
        }

        $result = $this->user_service->deleteUser($user);

        if($request->ajax()) {
            return $result ? Response::success($this->user_service->message) : Response::error($this->user_service->message);
        }

        return redirect($redirect)->with($result ? 'success' : 'error', $this->user_service->message);
    }

    public function restoreApi(Request $request, $id)
    {
        $result = $this->user_service->restoreUser($id);

        if($request->ajax()) {
            return $result ? Response::success($this->user_service->message) : Response::error($this->user_service->message);
        }

        return back()->with($result ? 'success' : 'error', $this->user_service->message);
    }

    public function show(User $user)
    {
        return response($user->load('member', 'employee'));
    }
}
