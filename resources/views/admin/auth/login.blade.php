<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MFS') }}</title>
    <link rel="shortcut icon"
        href="{{ settings('favicon') ? asset(settings('favicon')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}">


    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <!--Stylesheet-->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .login-section {
            min-height: 100vh;
            max-width: 1280px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        }

        .row {
            height: 100vh;
            display: grid;
            grid-template-columns: repeat(2, 40% 60%);
        }

        .row .col-5,
        .row .col-7 {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row .col-7 {
            background-color: #e1f1ee;
        }

        .login-img img {
            width: 700px;
        }

        form {
            width: 100%;
            color: #fff;
            border-radius: 10px;
            padding: 0 35px;
            background-color: #fff;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: black;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 46px;
            font-weight: 700;
            line-height: 44px;
            text-align: center;
            color: #0FB9B8;
        }

        label {
            color: #161616 !important;
            display: block;
            margin-top: 20px;
            font-size: 14px;
            font-weight: 400;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 3px;
            padding: 0 16px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
            border: 1px solid #0FB9B8;
        }

        ::placeholder {
            color: #494949;
        }

        button {
            margin-top: 30px;
            width: 100%;
            background-color: #0FB9B8;
            color: #fff;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid #0FB9B8;
        }

        button:hover {
            transition: 0.3s;
            background-color: #fff;
            color: #0FB9B8;
            border: 1px solid #0FB9B8;
        }

        .social {
            margin-top: 30px;
            display: flex;
        }

        .social div {
            background: red;
            width: 100%;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
        }

        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }

        .danger {
            color: #e71313;
            font-weight: 400;
            font-size: 13px;
        }

        .is-invalid {
            border: 1px solid red;
        }

        .show-pass {
            float: right;
            color: black;
            margin: -31px 4px 0px 0px;
        }

        header {
            width: 140px;
            margin: auto;
            text-align: center;
            margin-bottom: 20px;
        }

        header img {
            width: 100%;
        }

        @media (max-width: 993px) {
            .login-section {
                max-width: 568px;
            }
            .row {
                height: 100vh;
                display: block;
            }

            .row .col-7 {
                display: none;
            }

            form {
                width: 100%;
                position: static;
                transform: none;
            }

            .footer-design {
                flex-direction: column;
                text-align: center;
                color: #fff;
                gap: 4px;
                font-size: 13px;
            }
        }

    </style>

</head>

<body>
    <div id="app" class="login-section">
        <div class="row">
            <div class="col-5">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <header>
                        <img
                            src="{{ settings('login_logo') ? asset(settings('login_logo')) : Vite::asset(\App\Library\Enum::LOGO_PATH) }}">
                    </header>
                    <h3 style="margin-bottom: 15px;font-size: 38px;">{{ __('Admin Login') }}</h3>

                    @error('inactive')
                    <span class="invalid-feedback" role="alert">
                        <strong class="danger">{{ $message }}</strong><br>
                    </span>
                    @enderror

                    <div class="forEmail">
                        <label for="email">{{ __('Email Address') }}</label>
                        <input type="email" class="@error('email') is-invalid @enderror" id="email" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong class="danger">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="forPassword">
                        <label for="password">Password</label>
                        <input type="password" placeholder="Password" id="password"
                            class="@error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        <i class="fas fa-eye show-pass" id="show_pass"></i>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong class="danger">{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    {{-- <!-- <div class="social">
                    <div class="go">
                        @if (Route::has('admin.password.request'))
                            <a class="btn btn-link" href="{{ route('admin.password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div> --> --}}
                </form>
            </div>
            <div class="col-7">
                <div class="login-img">
                    <img src="{{ Vite::asset(\App\Library\Enum::LOGIN_BACKGROUND_PATH) }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(function () {
        $("#show_pass").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#password").attr("type", type);
        });
    });
    </script>
</body>

</html>