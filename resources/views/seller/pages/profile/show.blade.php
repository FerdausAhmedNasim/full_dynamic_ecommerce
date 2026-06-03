@extends('seller.layouts.master')

@section('title', 'Employee Details')

@section('content')

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Profile')) }}</h4>
        </div>
    </div>

    <input type="hidden" value="1" id="canSignIn">

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

                <li class="nav-item certificates">
                    <a class="nav-link" data-toggle="tab" href="#tab-certificates" role="tab" aria-controls="Two"
                        aria-selected="false">
                        <div class="tooltip">Certificates</div>
                        <i class="fa-solid fa-graduation-cap"></i>
                    </a>
                </li>

                {{-- <li class="nav-item attachment">
                    <a class="nav-link" data-toggle="tab" href="#tab-attachment" role="tab" aria-controls="Two"
                        aria-selected="false">
                        <div class="tooltip">Attachment</div>
                        <i class="fa-solid fa-link"></i>
                    </a>
                </li> --}}

            </ul>
        </div>
    </div>

    <div class="tab-content mt-4">

     <!-- Home -->
        <div class="tab-pane fade" id="tab-home" role="tabpanel" aria-labelledby="tab-home">
            <div class="row">
                <div class="col-lg-3 col-md-5 mb-4">
                    <!-- Home Content -->
                    <div class="card shadow-sm">
                        <div class="card-body py-sm-4">
                            <div class="border-bottom text-center pb-2">
                                <div class="mb-3 border-bottom">
                                    <img src="{{ $employee?->user?->getAvatar() }}" alt="profile"
                                        class="img-lg rounded-circle mb-3">
                                </div>
                                <div class="mb-3">
                                    <h3>{{$employee?->user?->full_name}}</h3>
                                </div>

                                <p class="mx-auto mb-2">
                                    <i class="fas fa-map-marker-alt"></i> {{ $employee?->user?->location }}
                                </p>

                            </div>

                            <div class="text-center mt-4 nav-tab">

                                <a class="btn btn-sm mb-2 mr-2 btn2-light-secondary change-pass"
                                   href="{{ route('seller.profile.update_password') }}" >
                                    <div class="tooltip"> Change Password </div>
                                    <i class="fas fa-key"></i> Update Password</a>

                                @if(false)
                                <a href="{{ route('seller.profile.edit') }}"
                                    class="btn btn-sm btn-warning mb-2 mr-2 tooltip-edit">
                                    <div class="tooltip"> Edit </div>
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif

                            </div>

                        </div>
                    </div>
                    <!-- End Home Content-->

                    <!----------------- SideBar -------------------->
                    <div class="card mt-3">
                        <div class="card-body">
                            <ul class="nav nav-tabss nav-tabs-vertical" id="verticalTabMenu" role="tablist">

                                <li class="nav-item mb-2">
                                    <a class="nav-link default active" id="details-tab-vertical" data-bs-toggle="tab" href="#details-2"
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

                                <li class="nav-item mb-2">
                                    <a class="nav-link" id="house-tab-vertical" data-bs-toggle="tab" href="#house-hold"
                                        role="tab" aria-controls="house-2" aria-selected="false">
                                        <i class="fa-solid fa-house-chimney-window ms-2"></i> Household
                                    </a>
                                </li>

                                <li class="nav-item mb-2">
                                    <a class="nav-link" id="health-tab-vertical" data-bs-toggle="tab" href="#health"
                                        role="tab" aria-controls="health-2" aria-selected="false">
                                        <i class="fas fa-heartbeat"></i></i> Health
                                    </a>
                                </li>

                                @if(false)
                                <li class="nav-item mb-2">
                                    <a class="nav-link" id="security-tab-vertical" data-bs-toggle="tab" href="#security"
                                        role="tab" aria-controls="house-2" aria-selected="false">
                                        <i class="fa-solid fa-lock ms-2"></i> Security
                                    </a>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                    <!----------------- End SideBar -------------------->
                </div>

                <!----------------- SideBar Content -------------------->
                <div class="col-lg-9 col-md-7">
                    <div class="card shadow-sm">
                        <div class="card-body py-4">
                            <div class="tab-content tab-content-vertical">

                                <div class="tab-pane fade show active table-responsive" id="details-2" role="tabpanel"
                                    aria-labelledby="details-tab-vertical">

                                </div>

                                <div class="tab-pane fade" id="address" role="tabpanel"
                                    aria-labelledby="house-tab-vertical">

                                    <div class="" id="emergency_contact_show">
                                    @include('seller.pages.address.index')
                                    </div>
                                    <div class="d-none" id="emergency_contact_edit">
                                    @include('seller.pages.address.edit')
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="emergency-contact" role="tabpanel"
                                    aria-labelledby="house-tab-vertical">
                                    @include('seller.pages.emergency_contact.emergency_contact')
                                </div>

                                <div class="tab-pane fade" id="house-hold" role="tabpanel"
                                    aria-labelledby="house-tab-vertical">
                                    @include('seller.pages.house_hold.index')
                                </div>

                                <div class="tab-pane fade" id="health" role="tabpanel"
                                    aria-labelledby="health-tab-vertical">
                                    @include('seller.pages.health.index')
                                </div>

                                <div class="tab-pane fade" id="security" role="tabpanel"
                                    aria-labelledby="house-tab-vertical">
                                    @include('seller.pages.seller.partials.details.security')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!----------------- End SideBar Content -------------------->

            </div>
        </div>

        <div class="tab-pane fade" id="tab-certificates" role="tabpanel" aria-labelledby="tab-donations">
            @include('seller.pages.certificates.index')
        </div>

        <div class="tab-pane fade" id="tab-attachment" role="tabpanel" aria-labelledby="tab-donations">
            @include('seller.pages.attachment.index')
        </div>
    </div>

</div>

@stop

@include('seller.assets.dt')
@include('seller.assets.dt-buttons')
@include('seller.assets.dt-buttons-export')

@push('scripts')
@vite('resources/employee_assets/js/certificates/index.js')
@vite('resources/employee_assets/js/show.js')
@vite('resources/employee_assets/js/attachment/index.js')
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
