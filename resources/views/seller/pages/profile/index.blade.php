@extends('seller.layouts.master')
@section('title', __('Profile'))
@section('content')

@php
    use App\Library\Helper;
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ __('My Profile') }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3 border-bottom">
                            <img src="{{ $user->getAvatar() }}" alt="profile" class="img-lg rounded-circle mb-3">
                        </div>
                        <div class="mb-3">
                            <h3>{{ $user?->full_name }}</h3>
                            <div class="d-flex align-items-center justify-content-center">
                                <h5 class="mb-0 me-2 text-muted">{{ $user->country }}</h5>
                            </div>
                        </div>
                        <p class="mx-auto mb-2">{{ $user ? $user->about_me : 'N/A' }}</p>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('seller.profile.update_password') }}"
                            class="btn btn-sm btn2-light-secondary mb-2 mr-2">
                            <i class="fas fa-key"></i> Update Password
                        </a>
                        
                        <a href="{{ route('seller.profile.update') }}" class="btn btn-sm btn-warning mb-2 mr-2">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td>
                                    <span
                                        class="badge {{ $user->status == \App\Library\Enum::USER_STATUS_ACTIVE ? 'btn-success' : 'btn-warning'}}">
                                        {{ $user->status == \App\Library\Enum::USER_STATUS_ACTIVE ? "Active" : "Inactive" }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Date Of Birth</td>
                                <td> {{ $user ? getFormattedDate($user->dob) : 'N/A' }} </td>
                            </tr>
                            <tr>
                                <td>Phone</td>
                                <td> {{ $user ? $user->phone : 'N/A' }} </td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td> {{ $user->email }} </td>
                            </tr>

                            <tr>
                                <td>Type</td>
                                <td class="text-capitalize"> {{ $user ? $user->user_type : 'N/A' }} </td>
                            </tr>
                            <tr>
                                <td>Joined At</td>
                                <td> {{ $user ? getFormattedDateTime($user->created_at) : "--:--:--" }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="text-center"> Address</h4>

                    <table class="table table-bordered" id="addressTableShow">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    <h4 class="text-center">Home Address</h4>
                                </th>
                                <th>
                                    <h4 class="text-center">Postal Address</h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td width="20%">Street Name & Number</td>
                                <td width="40%" class="text-capitalize text-center">
                                    {{ $address->home_street_address ?? 'N/A' }}
                                </td>
                                <td width="40%" class="text-capitalize text-center">
                                    {{ $address->postal_street_address ?? 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td>Suburb</td>
                                <td class="text-capitalize text-center"> {{ $address->home_suburb ?? 'N/A' }} </td>
                                <td class="text-capitalize text-center"> {{ $address->postal_suburb ?? 'N/A' }} </td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td class="text-capitalize text-center"> {{ $address->home_city ?? 'N/A' }} </td>
                                <td class="text-capitalize text-center"> {{ $address->postal_city ?? 'N/A' }} </td>
                            </tr>
                            <tr>
                                <td>Post Code</td>
                                <td class="text-capitalize text-center"> {{ $address->home_post_code ?? 'N/A' }} </td>
                                <td class="text-capitalize text-center"> {{ $address->postal_post_code ?? 'N/A' }} </td>
                            </tr>

                            @if(true)
                            <tr>
                                <td>Latitude</td>
                                <td class="text-capitalize text-center"> {{ $address->home_latitude ?? 'N/A' }}
                                </td>
                                <td class="text-capitalize text-center"> {{ $address->postal_latitude ?? 'N/A'}}
                                </td>
                            </tr>
                            <tr>
                                <td>Longitude</td>
                                <td class="text-capitalize text-center"> {{ $address->home_longitude ?? 'N/A'  }}
                                </td>
                                <td class="text-capitalize text-center"> {{ $address->postal_longitude ?? 'N/A' }}
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.components.update_password')

@stop

@include('admin.assets.dt')

@push('scripts')

<script type="text/javascript">

</script>
@endpush
