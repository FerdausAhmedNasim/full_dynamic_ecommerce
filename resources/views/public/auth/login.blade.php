@extends('public.layout.master')
@section('title', 'Login')

@section('content')

<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Log In') !!}
<!-- End Breadcrumbs -->

<!-- log in section start -->
<section class="log-in-section background-image-2 section-b-space">
    <div class="container-fluid-lg w-100">
        <div class="row">
            <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                <div class="image-contain">
                    <img src="{{ settings('login_banner') ? asset(settings('login_banner')) : Vite::asset(\App\Library\Enum::LOGIN_IMAGE_PATH) }}"
                        class="img-fluid" alt="">
                </div>
            </div>

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                <div class="log-in-box">
                    <div class="log-in-title">
                        <h3 style="text-align: center; margin-bottom: 30px;">Welcome</h3>
                        <h4>Login Your Account</h4>
                    </div>

                    <div class="input-box">
                        <form method="POST" class="row g-4" action="{{ route('login') }}">
                            @csrf
                            <!-- @foreach($errors->all() as $error)
                                <li>{!!   $error !!}</li>
                            @endforeach -->
                            <div class="col-12">
                                <div class="form-floating theme-form-floating @error('phone') error @enderror">
                                    <input type="tel" class="form-control" name="phone" id="phone"
                                        placeholder="Phone Number" required>
                                    <label for="phone">Phone Number</label>
                                    @error('phone')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-floating theme-form-floating @error('password') error @enderror">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Password" required>
                                    <label for="password">Password</label>

                                    @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="forgot-box">
                                    <div class="form-check ps-0 m-0 remember-box">
                                        <input class="checkbox_animated check-box" type="checkbox"
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">Remember me</label>
                                    </div>
                                    <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-animation w-100 justify-content-center" type="submit">Login</button>
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
                        <h4>Don't have an account? <a style="display: inline;" href="{{route('register')}}">Sign Up</a> here.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- log in section end -->
@endsection
<script type="text/javascript">
    $(function () {
        $("#show_pass").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#password").attr("type", type);
        });
    });
</script>
