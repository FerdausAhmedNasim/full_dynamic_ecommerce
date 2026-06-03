<div class="log-in-button mt-3">
    <ul class="d-flex justify-content-center align-items-center gap-2">
        <li>
            <a href="{{ route('google.auth') }}" class="btn google-button">
                <img src="{{ Vite::asset(\App\Library\Enum::GOOGLE_ICON_PATH) }}" class="blur-up lazyload" alt="">
                <p>Google</p>
            </a>
        </li>
        <!-- <li>
            <a href="https://www.facebook.com/" class="btn google-button">
                <img src="{{ Vite::asset(\App\Library\Enum::FACEBOOK_ICON_PATH) }}" class="blur-up lazyload" alt="">
                <p>FaceBook</p>
            </a>
        </li> -->
    </ul>
</div>