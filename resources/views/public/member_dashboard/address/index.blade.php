@extends('public.member_dashboard.dashboard_master')

@section('title', 'My Address')

@section('address', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-address">
    <div class="title title-flex">
        <div>
            <h2>My Address</h2>
            <span class="title-leaf">
                <svg class="icon-width bg-gray">
                    <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
                </svg>
            </span>
        </div>

        <a href="{{ route('dashboard.address.address_create') }}">
            <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"><i data-feather="plus"
                    class="me-2"></i> Add New Address</button>
        </a>
    </div>

    <div class="row g-sm-4 g-3">
        @if ($addresses->count() > 0)
        @foreach ($addresses as $address)
        <div class="col-xl-6 col-lg-12 col-md-6">
            <div class="address-box">
                <div class="position-relative">
                    <div class="table-responsive address-table">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Street Name : </td>
                                    <td>
                                        <p class="ms-1">{{$address->street_address}}</p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Area :</td>
                                    <td>{{ $address->area->en_name }}</td>
                                </tr>

                                <tr>
                                    <td>Thana :</td>
                                    <td>{{ $address->area->thana->en_name }}</td>
                                </tr>

                                <tr>
                                    <td>District :</td>
                                    <td>{{ $address->area->district->en_name }}</td>
                                </tr>

                                <tr>
                                    <td>Division :</td>
                                    <td>{{ $address->area->division->en_name }}</td>
                                </tr>

                                <tr>
                                    <td>Latitude :</td>
                                    <td>{{$address->latitude??'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Longitude :</td>
                                    <td>{{$address->longitude??'N/A'}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="position-absolute end-0 top-0">
                            <div class="dropdown">
                                <button class=" btn" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

                                @if(!$address->primary)
                                <ul class="dropdown-menu address-dropdown">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('dashboard.address.defaultShipping', $address->id) }}">Make
                                                Default Shipping</a>
                                        </li>
                                    </ul>
                                    @endif
                            </div>
                        </div>
                        <div class="position-absolute end-0 bottom-0">
                            <span class="text-white bg-secondary px-1 rounded-3">{{ $address->primary ? "Default
                                Shipping" : ''}}</span>
                        </div>
                    </div>
                </div>

                <div class="button-group">
                    <a href="{{ route('dashboard.address.address_update', $address->id) }}" class="w-100">
                        <button class="btn btn-sm add-button w-100"><i data-feather="edit"></i>Edit</button>
                    </a>
                    <a href="{{ route('dashboard.address.delete', $address->id) }}" class="w-100">
                        <button class="btn btn-sm add-button w-100"><i data-feather="trash-2"></i>Remove</button>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @else
            <div class="col-xl-6 col-lg-12 col-md-6 shadow-lg p-5 text-center">
                <h3>Address are not available......</h3>
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
@endpush