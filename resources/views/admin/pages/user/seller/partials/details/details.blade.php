@extends('admin.pages.user.seller.layout.master')

@section('title', 'Seller Details')
@section('details', 'active')

@section('clientContent')

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
                <td>User Name</td>
                <td> {{ $user?->user_name ?? 'N/A' }} </td>
            </tr>

            <tr>
                <td>Date Of Birth</td>
                <td> {{ getFormattedDate($user?->dob) }} </td>
            </tr>

            <tr>
                <td>Location</td>
                <td> {{ $user?->location ?? 'N/A' }} </td>
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
                <td> {{ $user->email }} </td>
            </tr>
            <tr>
                <td>Gender</td>
                <td> {{ $user?->gender }} </td>
            </tr>
            <tr>
                <td>Joined At</td>
                <td> {{ getFormattedDateTime($user->created_at) }} </td>
            </tr>
            {{-- <tr>
                <td>Email Verified</td>
                <td>
                    @if($user?->email_verified_at)
                        <i class="fa-solid fa-circle-check"></i>
                    @else
                        <i class="fa-solid fa-circle-xmark"></i>
                    @endif
                </td>
            </tr> --}}
        </tbody>
    </table>
</div>

@endsection
