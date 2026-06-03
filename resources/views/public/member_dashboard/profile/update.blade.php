@extends('public.member_dashboard.dashboard_master')
@section('profile', 'active')

@section('member_content')
<div class="row" data-aos="fade-up">
    <div class="col-md-12 content-area">
        <h2>Profile Update</h2>
        <hr>
        <div class="row d-flex flex-column align-items-center justify-content-center shadow-lg p-4 rounded-4">
            <form method="post" action="{{ route('dashboard.profile.update_profile') }}" class="client-signup-form"
                enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id" value="{{ authId() }}" />

                <div class="row g-4">
                    <div class="col-xxl-6">
                        <div class="form-floating theme-form-floating">
                            <input type="text" class="form-control" id="fname" name="first_name"
                                value="{{authUser()->first_name}}">
                            <label for="fname">First Name</label>
                        </div>
                        @error('first_name')
                        <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xxl-6">
                        <div class="form-floating theme-form-floating">
                            <input type="text" class="form-control" id="lname" name="last_name"
                                value="{{authUser()->last_name}}">
                            <label for="lname">Last Name</label>
                        </div>
                        @error('last_name')
                            <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xxl-6">
                        <div class="form-floating theme-form-floating">
                            <input type="email" class="form-control" id="email1" name="email"
                                value="{{authUser()->email}}" placeholder="Email">
                            <label for="email1">Email</label>
                        </div>
                        @error('email')
                        <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xxl-6">
                        <div class="form-floating theme-form-floating">
                            <input class="form-control" type="number" value="{{authUser()->phone}}" name="phone" id="phone"
                                maxlength="11" min="0">
                            <label for="phone">Phone</label>
                        </div>
                        @error('phone')
                        <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xxl-6">
                        <div class="form-floating theme-form-floating">
                            <select class="select form-control" name="gender" id="userGender"
                                style="width: 100%;" required>
                                <option value="Gender" selected disabled>Select One</option>
                                @foreach($genders as $gender)
                                <option value="{{ $gender }}"
                                    {{ old('gender', $user->gender) == $gender ? "selected" : "" }}>
                                    {{ $gender }}</option>
                                @endforeach
                            </select>
                            <label for="userGender">Gender</label>
                        </div>
                        @error('gender')
                        <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-xxl-6">
                        <div class="form-floating theme-form-floating">
                            <input type="date" class="form-control" id="dob" name="dob" value="{{authUser()->dob}}"
                                placeholder="Birthday">
                            <label for="dob">Birthday</label>
                        </div>
                        @error('dob')
                        <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-floating theme-form-floating">
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{authUser()->address}}" placeholder="Address">
                            <label for="address">Address</label>
                        </div>
                        @error('address')
                        <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-floating theme-form-floating">
                            <textarea type="text" class="form-control" name="description" id="description" placeholder="Note">{{authUser()->description}}</textarea>
                            <label for="description">Note</label>
                        </div>
                        @error('description')
                        <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="form-floating theme-form-floating">
                            <input class="form-control" type="file" name="avatar" />
                            <label for="description">Profile Photo</label>
                        </div>
                        @error('description')
                        <p class="m-0 text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-sm theme-bg-color text-white register-btn" type="submit"> Submit </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
