@extends('seller.layouts.master')

@section('title', 'Moderator Details')

@section('content')

@php
use App\Library\Helper;
$user_role = App\Models\User::getAuthUserRole();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('seller.moderator.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Moderator Details')) }}</h4>
        </div>
    </div>

    <input type="hidden" value="{{ $employee->id }}" id="employeeId">

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <ul class="nav nav-tab" id="tabMenu" role="tablist">
                <li class="nav-item">
                    <a class="nav-link default home" data-toggle="tab" href="#tab-home" role="tab" aria-controls="One"
                        aria-selected="true">
                        <div class="tooltip">Details</div>
                        <i class="fa-solid fa-circle-info"></i>
                    </a>
                </li>
{{-- 
                @if( Helper::hasAuthRolePermission('attachment_index'))
                <li class="nav-item attachment">
                    <a class="nav-link" data-toggle="tab" href="#tab-attachment" role="tab" aria-controls="Two"
                        aria-selected="false">
                        <div class="tooltip">Attachment</div>
                        <i class="fa-solid fa-link"></i>
                    </a>
                </li>
                @endif --}}

                {{-- <li class="nav-item assignStock">
                    <a class="nav-link" data-toggle="tab" href="#tab-assign_stock" role="tab" aria-controls="Two"
                        aria-selected="false">
                        <div class="tooltip">Assigned Stock </div>
                        <i class="fa-solid fa-cart-flatbed-suitcase"></i>
                    </a>
                </li> --}}

                {{-- <li class="nav-item ticket">
                    <a class="nav-link" data-toggle="tab" href="#tab-ticket" role="tab" aria-controls="Two"
                        aria-selected="false">
                        <div class="tooltip"> Ticket </div>
                        <i class="fas fa-envelope"></i>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>

    <div class="tab-content mt-4">

     <!-- Home -->
        <div class="tab-pane fade" id="tab-home" role="tabpanel" aria-labelledby="tab-home">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <!-- Home Content -->
                    <div class="card shadow-sm">
                        <div class="card-body py-sm-4">
                            <div class="border-bottom text-center pb-2">
                                <div class="mb-3 border-bottom">
                                    <img src="{{ $employee?->user?->getAvatar() }}" alt="profile"
                                        class="img-lg rounded-circle mb-3" onclick="clickImage('{{ $employee?->user?->getAvatar() }}')">
                                </div>
                                <div class="mb-3">
                                    <h3>{{ $employee?->user?->full_name }}</h3>
                                </div>

                                <p class="mx-auto mb-2">
                                    <i class="fas fa-map-marker-alt"></i> {{ $employee?->user?->getFullAddressAttribute() }}
                                </p>

                            </div>

                            <div class="text-center mt-4 nav-tab">
                                @php $user = $employee->user; @endphp

                                <button
                                    class="btn btn-sm mb-2 mr-2 change-status {{ $user->status != \App\Library\Enum::USER_STATUS_ACTIVE ? 'btn-secondary tooltip-secondary' : 'btn2-secondary' }}"
                                    href="javascript:void(0)" onclick="clickUpdateStatus()" tooltip="Change Status">
                                    <i class="fas fa-power-off"></i>
                                </button>

                                <button class="btn btn-sm mb-2 mr-2 btn2-light-secondary change-pass"
                                onclick="updateUserPassword({{$user->id}})" tooltip="Change Password">
                                    <i class="fas fa-key"></i> </button>

                                <a href="{{ route('seller.moderator.update', $employee->id) }}"
                                    class="btn btn-sm btn-warning mb-2 mr-2 tooltip-warning" tooltip="Edit">
                                    <i class="fas fa-edit"></i></a>

                                <button class="btn btn-sm btn-danger mb-2 tooltip-danger"
                                    onclick="confirmFormModal('{{ route('seller.moderator.delete.api', $user->id) }}', 'Confirmation', 'Are you sure to delete operation?')" tooltip="Delete">
                                    <i class="fas fa-trash-alt"></i> </button>

                            </div>

                        </div>
                    </div>
                    <!-- End Home Content-->

                    <!----------------- SideBar -------------------->
                    <div class="card mt-3">
                        <div class="card-body">
                            <ul class="nav nav-tabss nav-tabs-vertical" id="verticalTabMenu" role="tablist">
                                <li class="nav-item mb-2">
                                    <a class="nav-link default active" id="home-tab-vertical" data-bs-toggle="tab"
                                        href="#home-2" role="tab" aria-controls="home-2" aria-selected="true">
                                        <i class="fa-solid fa-border-all ms-2"></i> Dashboard
                                    </a>
                                </li>

                                <li class="nav-item mb-2">
                                    <a class="nav-link" id="details-tab-vertical" data-bs-toggle="tab" href="#details-2"
                                        role="tab" aria-controls="details-2" aria-selected="false">
                                        <i class="fa-solid fa-user-tie fa-lg ms-2"></i> Details
                                    </a>
                                </li>

                                <li class="nav-item mb-2">
                                    <a class="nav-link" id="contact-tab-vertical" data-bs-toggle="tab" href="#address"
                                        role="tab" aria-controls="address" aria-selected="false">
                                        <i class="fa-solid fa-location-dot fa-lg ms-2"></i> Address
                                    </a>
                                </li>

                                <li class="nav-item mb-2">
                                    <a class="nav-link" id="contact-tab-vertical" data-bs-toggle="tab" href="#emergency-contact"
                                        role="tab" aria-controls="emergency-contact" aria-selected="false">
                                        <i class="fa-solid fa-address-book ms-2"></i> Emergency Contact
                                    </a>
                                </li>

                                @php
                                    $role = count($employee?->user?->getRole());
                                @endphp


                                <li class="nav-item mb-2">
                                    <a class="nav-link" id="security-tab-vertical" data-bs-toggle="tab" href="#security"
                                        role="tab" aria-controls="house-2" aria-selected="false">
                                        <i class="fa-solid fa-lock ms-2"></i> Security
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </div>
                    <!----------------- End SideBar -------------------->
                </div>

                <!----------------- SideBar Content -------------------->
                <div class="col-md-9">
                    <div class="card shadow-sm">
                        <div class="card-body py-4">
                            <div class="tab-content tab-content-vertical">

                                <div class="tab-pane fade show active" id="home-2" role="tabpanel"
                                    aria-labelledby="home-tab-vertical">
                                    @include('seller.pages.moderator.partials.details.dashboard')
                                </div>

                                <div class="tab-pane fade" id="details-2" role="tabpanel"
                                    aria-labelledby="details-tab-vertical">
                                    @include('seller.pages.moderator.partials.details.details')
                                </div>


                                <div class="tab-pane fade" id="address" role="tabpanel"
                                    aria-labelledby="house-tab-vertical">

                                    <div class="" id="emergency_contact_show">
                                    @include('seller.pages.address.index')
                                    </div>
                                    <div class="d-none" id="emergency_contact_edit">
                                    @if(isset($address))
                                        @include('seller.pages.address.edit')
                                    @else
                                        @include('seller.pages.address.create')
                                    @endif
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="emergency-contact" role="tabpanel"
                                    aria-labelledby="house-tab-vertical">
                                    @include('seller.pages.emergency_contact.emergency_contact')
                                </div>


                                <div class="tab-pane fade" id="security" role="tabpanel"
                                    aria-labelledby="house-tab-vertical">
                                    @include('seller.pages.moderator.partials.details.security')
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!----------------- End SideBar Content -------------------->

            </div>
        </div>

        @if( Helper::hasAuthRolePermission('ticket_index'))
        <div class="tab-pane fade" id="tab-ticket" role="tabpanel" aria-labelledby="tab-ticket">
            @include('seller.pages.moderator.ticket.index')
        </div>
        @endif

        @if( Helper::hasAuthRolePermission('attachment_index'))
        <div class="tab-pane fade" id="tab-attachment" role="tabpanel" aria-labelledby="tab-attachment">
            @include('seller.pages.moderator.attachment.index')
        </div>
        @endif
    </div>
</div>

@include('seller.pages.moderator.partials.update_user_status_modal')
@include('seller.pages.moderator.partials.update_password')
@include('admin.assets.preview-image')

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/seller_assets/js/pages/moderator/show.js')
@vite('resources/seller_assets/js/pages/moderator/show.js')
@endpush
<script src="{{ asset('assets/js/vendor.bundle.base.js') }}"></script>


@push('styles')
    <style>
        .count {
            top: -3px !important;
        }

        .nav-link i {
            width: 25px;
        }
    </style>
@endpush
