<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="POS">
    <meta name="author" content="">

    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <link rel="shortcut icon"
        href="{{ settings('favicon') ? asset(settings('favicon')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}">
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        window.auth_role_permissions = JSON.parse('{!! json_encode(config('
            auth.role_permissions ')) !!}');
    </script>
    <link rel="stylesheet" href="{{ asset('assets/css/congratulations.css') }}">
</head>

<body>
    <main>
        <article>
            <canvas class="confetti" id="canvas">
            </canvas>
            <!--End DEMO HTML -->
            <div class="congratulations-div">
                <div class="checkmark-circle">
                    <div class="background"></div>
                    <div class="checkmark draw"></div>
                </div>
                <h1>Congratulations!</h1>
                <p>You are Passed !!. Well done!</p>
                <a class="submit-btn" type="submit"
                    href="{{$route}}">Continue</a>
            </div>
        </article>
    </main>

    <!-- Confetti JS -->
    <script src="{{asset('admin/js/congratulations.js')}}"></script>
</body>

</html>