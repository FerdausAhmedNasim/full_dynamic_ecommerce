<footer class="section-t-space">
    <div class="container-fluid-lg">
        <div class="main-footer section-b-space section-t-space">
            <div class="row g-md-4 g-3">
                <div class="col-lg-3 col-sm-6">
                    <div class="footer-logo">
                        <div class="theme-logo">
                            <a href="{{ url('/')}}">
                                <img src="{{ settings('logo') ? asset(settings('logo')) : Vite::asset(\App\Library\Enum::LOGO_PATH) }}"
                                    class="blur-up lazyload" alt="">
                            </a>
                        </div>

                        <div class="footer-logo-contain">
                            <ul class="address">
                                {{-- <li></li> --}}
                                <li>
                                    <i data-feather="home"></i>
                                    <a>{{ getCompanyAddress() }}</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="footer-title">
                        <h4>Categories</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            @foreach($categories as $key => $category)
                            @if($key < 5) <li>
                                <a href="{{ route('public.product.category_wise', $category->slug) }}"
                                    class="text-content">{{ $category->getTranslation('title') }}</a>
                                </li>
                                @endif
                                @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-2 col-md-3 col-sm-6">
                    <div class="footer-title">
                        <h4>Useful Links</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            <li>
                                <a href="{{ url('/') }}" class="text-content">Home</a>
                            </li>

                            {{-- <li>
                                <a href="{{ route('public.seller.index') }}" class="text-content">Shop</a>
                            </li> --}}

                            @if (App\Models\Page::where(['link' => 'about-us', 'active' => 1])->first())
                                <li>
                                    <a href="{{ route('public.page.about_us') }}" class="text-content">About Us</a>
                                </li>
                            @endif

                            @if (App\Models\Page::where(['link' => 'contact-us', 'active' => 1])->first())
                                <li>
                                    <a href="{{ route('public.contact.index') }}" class="text-content">Contact Us</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-3">
                    <div class="footer-title">
                        <h4>Help Center</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            @if (App\Models\Page::where(['link' => 'refund-policy', 'active' => 1])->first())
                            <li>
                                <a href="{{ route('public.page.show', \App\Library\Enum::REFUND_POLICY) }}" class="text-content">Return &
                                    Refund Policy</a>
                            </li>
                            @endif

                            @if (App\Models\Page::where(['link' => 'contact-us', 'active' => 1])->first())
                            <li>
                                <a href="{{ route('public.page.show', \App\Library\Enum::PRIVACY_POLICY) }}"
                                    class="text-content">privacy-policy</a>
                            </li>
                            @endif

                            @if (App\Models\Page::where(['link' => 'support-policy', 'active' => 1])->first())
                            <li>
                                <a href="{{ route('public.page.show', \App\Library\Enum::SUPPORT_POLICY) }}"
                                    class="text-content">Support Policy</a>
                            </li>
                            @endif

                            {{-- @if (App\Models\Page::where(['link' => 'seller-policy', 'active' => 1])->first())
                            <li>
                                <a href="{{ route('public.page.show', \App\Library\Enum::SELLER_POLICY) }}"
                                    class="text-content">Seller Policy</a>
                            </li>
                            @endif --}}
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-sm-6">
                    <div class="footer-title">
                        <h4>Contact Us</h4>
                    </div>

                    <div class="footer-contact">
                        <ul>
                            <li>
                                <div class="footer-number">
                                    <i data-feather="phone"></i>
                                    <div class="contact-number">
                                        <h6 class="text-content">Hotline 24/7 :</h6>
                                        <h5>{{ settings('phone') != '' ? settings('phone') : '+880199173856'}}</h5>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="footer-number">
                                    <i data-feather="mail"></i>
                                    <div class="contact-number">
                                        <h6 class="text-content">Email Address :</h6>
                                        <h5>{{ settings('email') != '' ? settings('email') : 'contact@ezzico.com'}}</h5>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="sub-footer section-small-space">
            <div class="reserve">
                <h6 class="text-content">
                    {{-- © Copyright - 2024 | All Rights Reserved --}}
                    © Copyright {{ now()->format('Y') }} {{ settings('copyright') }}
                    {{-- @if(settings('copyright_url'))
                    <a class="theme-color font-weight-bold" href="{{ settings('copyright_url') }}"
                        target="_blank">{{ settings('copyright') }} </a>
                    @else 
                    @endif --}}

                </h6>
            </div>

            <div class="payment">
                <img src="{{ asset('frontend/images/payment/1.png') }}" class="blur-up lazyload" alt="">
            </div>

            @if (settings('facebook_link') || settings('twitter_link') || settings('instagram_link') || settings('youtube_link'))
            <div class="social-link">
                <h6 class="text-content">Stay connected :</h6>
                <ul>
                    @if (settings('facebook_link'))
                    <li>
                        <a href="{{settings('facebook_link') }}" target="_blank">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    </li>
                    @endif
                    @if (settings('linkedin_link'))
                    <li>
                        <a href="{{ settings('linkedin_link') }}" target="_blank">
                            <i class="fa-brands fa-linkedin"></i>
                        </a>
                    </li>
                    @endif
                    @if (settings('twitter_link'))
                    <li>
                        <a href="{{ settings('twitter_link') }}" target="_blank">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </li>
                    @endif
                    @if (settings('instagram_link'))
                    <li>
                        <a href="{{ settings('instagram_link') }}" target="_blank">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </li>
                    @endif
                    @if (settings('youtube_link'))
                    <li>
                        <a href="{{ settings('youtube_link') }}" target="_blank">
                            <i class="fa-brands fa-youtube"></i>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif

            <a href="https://websolutionfirm.com" target="_blank"><i class="fa fa-laptop"></i> <span> Web Solution Firm </span> </a>
        </div>
    </div>
</footer>
