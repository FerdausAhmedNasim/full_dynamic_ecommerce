<div class="cookie-bar-box">
    <div class="cookie-box">
        <div class="cookie-image">
            <img src="{{ Vite::asset(\App\Library\Enum::COOKIES_IMG_PATH) }}" class="blur-up lazyload" alt="">
            <h2>Cookies! {{$has_cookie}}</h2>
        </div>

        <div class="cookie-contain">
            <h5 class="text-content">We use cookies to make your experience better</h5>
        </div>
    </div>

    <div class="button-group">
        <button onclick="window.location.href = '{{ route('public.page.show', \App\Library\Enum::PRIVACY_POLICY) }}'" class="btn privacy-button">Privacy Policy</button>
        <button class="btn ok-button" onclick="window.location.href = '{{ route('public.cookie.set') }}'">OK</button>
    </div>
</div>
