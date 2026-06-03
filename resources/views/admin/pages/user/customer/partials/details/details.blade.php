@extends('admin.pages.user.customer.layout.master')

@section('title', 'Customer Details')

@section('clientContent')

<div class="content-header d-flex">
    <div class="d-block">
        <h4 class="content-title ml-0">{{ strtoupper(__('Details' )) }}</h4>
    </div>
</div>

<div class="text-center">
    <table class="table org-data-table table-bordered">
        <tbody>
            <tr>
                <td>Status</td>
                <td>
                    @php
                        use App\Library\Enum;
                        if ($user?->status == Enum::USER_STATUS_PENDING)
                            $class = 'badge-secondary';
                        else if ($user?->status == Enum::USER_STATUS_ACTIVE)
                            $class = 'badge-success';
                        else if ($user?->status == Enum::USER_STATUS_SUSPENDED)
                            $class = 'badge-danger';
                    @endphp

                    <div class="badge {{ $class }}">
                        {{ Enum::getUserStatus($user?->status) }}
                    </div>
                </td>
            </tr>
            <tr>
                <td>Date Of Birth</td>
                <td> {{ getFormattedDate($user?->dob) }} </td>
            </tr>
            <tr>
                <td>User Type</td>
                <td class="text-capitalize"> {{ $user?->user_type }} </td>
            </tr>
            <tr>
                <td>Phone</td>
                <td> {{ $user?->phone }} </td>
            </tr>
            <tr>
                <td>Email</td>
                <td> {{ $user->email ?? 'N/A' }} </td>
            </tr>
            <tr>
                <td>Gender</td>
                <td> {{ $user?->gender ?? 'N/A' }} </td>
            </tr>
            <tr>
                <td>Joined At</td>
                <td> {{ getFormattedDateTime($user->created_at) }} </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
