@extends('public.layout.master')
@section('title', 'Sign Up')

@section('content')

<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Sign Up') !!}
<!-- End Breadcrumbs -->


<!-- log in section start -->
<section class="log-in-section background-image-2 section-b-space">
    <div class="container-fluid-lg w-100">
        <div class="row">
            <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                <div class="image-contain">
                    <img src="{{ settings('signup_banner') ? asset(settings('signup_banner')) : Vite::asset(\App\Library\Enum::SIGNUP_IMAGE_PATH) }}"
                        class="img-fluid" alt="">
                </div>
            </div>

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                <div class="log-in-box">
                    <div class="log-in-title">
                        <h3 style="text-align: center; margin-bottom: 30px;">Welcome</h3>
                        <h4>Create Your Account</h4>
                    </div>

                    <div class="input-box">
                        <form method="POST" class="row g-4" action="{{ route('register') }}">
                            @csrf

                            <div class="col-6">
                                <div class="form-floating theme-form-floating @error('first_name') error @enderror">
                                    <input type="text" class="form-control" name="first_name" id="first_name"
                                    value="{{ old('first_name') }}"
                                        placeholder="First Name" required>
                                    <label for="first_name">First Name</label>
                                    @error('first_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-floating theme-form-floating @error('last_name') error @enderror">
                                    <input type="text" class="form-control" name="last_name" id="last_name"
                                    value="{{ old('last_name') }}"
                                        placeholder="Last Name" required>
                                    <label for="last_name">Last Name</label>
                                    @error('last_name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating @error('phone') error @enderror">
                                    <input type="number" class="form-control" name="phone" id="phone"
                                    value="{{ old('phone') }}"
                                        placeholder="Phone Number" required>
                                    <label for="phone">Phone Number</label>

                                    @error('phone')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating @error('password') error @enderror">
                                    <input type="password" name="password" class="form-control" id="password"
                                    value="{{ old('password') }}"
                                        placeholder="Password" required>
                                    <label for="password">Password</label>
                                    @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            @php
                                $termsConditions = collect(json_decode(settings('customer_agreement'), true));
                            @endphp
                            <div class="col-12">
                                <button class="btn btn-animation w-100 mb-3" type="submit">Sign Up</button>
                                @if (count($termsConditions))
                                    <span>By clicking “SIGN UP”, I agree
                                        @foreach ($termsConditions as $key => $termsCondition)
                                        <a target="_blank" href="/pages/{{ str_replace('_', '-', $termsCondition) }}" >{{ str_replace('_', ' ', $termsCondition)  }}</a> {{ count($termsConditions) > $key+1 ? 'and' : '' }}
                                        @endforeach
                                    </span>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- <div class="other-log-in text-capitalize">
                        <h6>or Login With</h6>
                    </div>

                    @include('public.auth.partials.login_with') --}}

                    <div class="other-log-in">
                        <h6></h6>
                    </div>

                    <div class="sign-up-box">
                        <h4>Already have an account? <a style="display: inline" href="{{ route('login')}}">Login</a> here.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- log in section end -->
@endsection
