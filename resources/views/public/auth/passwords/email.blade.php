@extends('public.layout.master')
@section('title', 'Forgot Password')

@section('content')

<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Forgot Password') !!}
<!-- End Breadcrumbs -->

    <!-- log in section start -->
    <section class="log-in-section section-b-space forgot-section">
        <div class="container-fluid-lg w-100">
            <div class="row">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                    <div class="image-contain">
                        <img src="{{ settings('forgot_password_banner') ? asset(settings('forgot_password_banner')) : Vite::asset(\App\Library\Enum::FORGOT_PASSWORD_IMAGE_PATH) }}" class="img-fluid" alt="">
                    </div>
                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="log-in-box">
                            <div class="log-in-title">
                                <h3>Welcome</h3>
                                <h4>Forgot your password</h4>
                            </div>

                            <div class="input-box">
                                <form method="POST" action="{{ route('password.email') }}" class="row g-4">
                                    @csrf

                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating log-in-form">
                                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" id="email"
                                                placeholder="Email Address" required>
                                            <label for="email">Email Address</label>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-animation w-100" type="submit">Send Password Reset Link</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->
@endsection