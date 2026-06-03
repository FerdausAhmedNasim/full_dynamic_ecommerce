@extends('public.layout.master')

@section('title', 'Contact Us')

@section('content')
<!-- ======= Breadcrumbs ======= -->
{!! \App\Library\Html::breadcrumbsSection('Contact Us') !!}
<!-- End Breadcrumbs -->

<section class="contact-box-section mb-2">
    <div class="container-fluid-lg">
        <div class="row g-lg-5 g-3">
            <div class="col-lg-6">
                <div class="left-sidebar-box">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="contact-title d-none d-lg-block">
                                <h3>Contact Us</h3>
                            </div>

                            <div class="contact-detail">
                                <div class="row g-4">
                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-phone"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Phone</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <p>{{settings('phone') ? settings('phone') : +61432381844}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-envelope"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Email</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <p>{{settings('email') ? settings('email') : 'info@ezzico.com'}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-location-dot"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Office</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <p>{{settings('address') ? settings('address') : '1283 (1st Floor), East
                                                    Monipur, Begum Rokeya Sarani Road, Mirpur-10, Dhaka-1216.'}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="title d-lg-none d-block">
                    <h2>Contact Us</h2>
                </div>
                <div class="right-sidebar-box">
                    <form method="post" action="{{ route('public.contact.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="exampleFormControlInput1" class="form-label">Your Name</label>
                                    <div class="custom-input">
                                        <input type="text" name="name" class="form-control"
                                            id="exampleFormControlInput1" value="{{old('name')}}" placeholder="Enter Last Name" required>
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="exampleFormControlInput1" class="form-label">Subject</label>
                                    <div class="custom-input">
                                        <input type="text" name="subject" class="form-control"
                                            id="exampleFormControlInput1" value="{{old('subject')}}" placeholder="Enter Last Name" required>
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="exampleFormControlInput2" class="form-label">Email Address</label>
                                    <div class="custom-input">
                                        <input type="email" name="email" class="form-control"
                                            id="exampleFormControlInput2" value="{{old('email')}}" placeholder="Enter Email Address" required>
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="exampleFormControlInput3" class="form-label">Phone Number</label>
                                    <div class="custom-input">
                                        <input type="number" class="form-control" value="{{old('phone')}}" placeholder="Enter Your Phone Number"
                                            name="phone" maxlength="11" required>
                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                    </div>
                                    @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="exampleFormControlTextarea" class="form-label">Message</label>
                                    <div class="custom-textarea">
                                        <textarea class="form-control" name="message" placeholder="Enter Your Message"
                                            rows="6" value="{{old('message')}}" required></textarea>
                                        <i class="fa-solid fa-message"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-animation btn-md fw-bold ms-auto">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="map-section">
    <div class="container-fluid p-0">
        <div class="map-box">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d4848.8446920162505!2d90.36997212711759!3d23.803014734559476!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sbd!4v1713931091931!5m2!1sen!2sbd"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

@endsection