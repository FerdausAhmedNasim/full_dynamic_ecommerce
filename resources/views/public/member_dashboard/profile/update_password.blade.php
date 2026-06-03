@extends('public.member_dashboard.dashboard_master')
@section('profile', 'active')

@section('member_content')
<div class="row" data-aos="fade-left">
    <div class="col-md-12 content-area">
        <h2>Update Password</h2>
        <hr>
        <div class="row gy-4 gx-5">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form method="post" action="{{ route('dashboard.profile.update_password') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row @error('current_password') error @enderror p-sm-3">
                                <label class="col-sm-4 col-form-label required">{{ __('Current Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="current_password"
                                        value="{{ old('current_password') }}" placeholder="{{ __('Current Password') }}"
                                        required>
                                    @error('current_password')
                                    <p class="text-danger m-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('password') error @enderror p-sm-3">
                                <label class="col-sm-4 col-form-label required">{{ __('New Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password"
                                        value="{{ old('password') }}" placeholder="{{ __('New Password') }}" required>
                                    @error('password')
                                    <p class="text-danger m-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('password_confirmation') error @enderror p-sm-3">
                                <label class="col-sm-4 col-form-label required">{{ __('Confirmed Password') }}</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}"
                                        placeholder="{{ __('Confirmed Password') }}" required>
                                    @error('password_confirmation')
                                    <p class="text-danger m-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>



                            <div class="row">
                                <div class="modal-footer justify-content-center col-md-12">
                                    <button class="btn btn-sm theme-bg-color text-white" type="submit"> Submit </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection