@extends('admin.layouts.master')

@section('title', __('New Notification'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">

        {!! \App\Library\Html::linkBack(route('admin.notification.index')) !!}

        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Notification')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.notification.create') }}" enctype="multipart/form-data"
                id="notificationCreateForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div
                                class="form-group member-select row @error('user_type') error @enderror">

                                <label class="col-sm-3 col-form-label">{{ __('User Type') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="user_type[]" id="user_type" multiple>
                                        @foreach($user_types as $key => $user_type)
                                        @if($key != \App\Library\Enum::USER_TYPE_SUPER_ADMIN && $key != \App\Library\Enum::USER_TYPE_SELLER)
                                        <option value="{{ $key }}" {{(old("user_type") == $key) ? "selected" : ""}}>
                                            {{ $user_type }}
                                        </option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('user_type')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div
                                class="form-group member-select row @error('user_status') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('User Status') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="user_status[]" id="user_status" multiple>
                                        @foreach($user_status as $key => $status)

                                            <option value="{{ $key }}" {{(old("user_status") == $key) ? "selected" : ""}}>
                                                {{ $status }}
                                            </option>

                                        @endforeach
                                    </select>
                                    @error('user_status')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('subject') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Subject') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="subject" value="{{ old('subject') }}"
                                        placeholder="{{ __('Notification Subject') }}" required>
                                    @error('subject')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('send_date') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Send Date') }}</label>
                                <div class="col-sm-9">

                                    <div class="input-group with-icon">
                                        <input type="text" class="form-control datetimepicker-min-today" name="send_date"
                                            value="{{ old('send_date') }}"
                                            placeholder="{{ settings('date_format') }}">
                                        <i class="date-icon fa-solid fa-calendar-days"></i>
                                    </div>

                                    @error('send_date')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group row @error('message') error @enderror">
                                <label class="col-sm-2 col-form-label required">{{ __('Message') }}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="exampleTextarea1" name="message" rows="5"
                                        placeholder="Notification Message" required>{{ old('message') }}</textarea>
                                    @error('message')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-footer text-center">
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>

            </form>
        </div>
    </div>
</div>
@stop
@include('admin.assets.summernote-text-editor')
@include('admin.assets.datetimepicker')
@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/notification/create.js')
@endpush
