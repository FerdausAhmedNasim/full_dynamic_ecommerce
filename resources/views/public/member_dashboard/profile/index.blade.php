@extends('public.member_dashboard.dashboard_master')

@section('title', 'My Profile')

@section('profile', 'active')

@section('member_content')
@php
use \App\Library\Enum;
@endphp
<div class="dashboard-profile">
    <div class="title">
        <h2>My Profile</h2>
        <span class="title-leaf">
            <svg class="icon-width bg-gray">
                <use xlink:href="{{ asset('frontend/svg/leaf.svg') }}#leaf"></use>
            </svg>
        </span>
    </div>

    <div class="profile-about dashboard-bg-box">
        <div class="row">
            <div class="col-xxl-7">
                <div class="dashboard-title mb-3">
                    <h3>Profile About</h3>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Name :</td>
                                <td>{{$user->full_name}}</td>
                            </tr>
                            <tr>
                                <td>Gender :</td>
                                <td>{{$user->gender ? $user->gender : 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Birthday :</td>
                                <td>{{$user->dob ? $user->dob : 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Phone Number :</td>
                                <td>
                                    {{$user->phone ? $user->phone : 'N/A'}}
                                </td>
                            </tr>
                            <tr>
                                <td>Address :</td>
                                <td>{{$user->address ? $user->address : 'N/A'}}</td>
                            </tr>
                            <tr>
                                <td>Note :</td>
                                <td>{{$user->description ? $user->description : 'N/A'}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="dashboard-title mb-3">
                    <h3>Login Details</h3>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Password :</td>
                                <td>
                                    <a href="{{ route('dashboard.profile.showPassword.update') }}" class="m-0">●●●●●●
                                        <span data-bs-toggle="modal" data-bs-target="#editProfile">Edit</span></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-xxl-5">
                <a href="{{ route('dashboard.profile.update') }}" class="text-end">
                    <button class="btn btn-sm theme-bg-color text-white ms-auto">Edit Profile</button>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
