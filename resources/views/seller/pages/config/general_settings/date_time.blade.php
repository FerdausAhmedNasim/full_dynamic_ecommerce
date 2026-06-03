@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Date & Time')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <input type="hidden" name="dateTime" value="dateTime">

                    <div class="form-group row @error('time_format') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="name">{{ __('Time Format') }}</label>
                        <div class="col-sm-9">

                            <div class="d-inline-flex justify-content-start">
                                <div class="form-check form-check-secondary mr-5">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input user-type-radio"
                                            name="time_format" value="24h" required
                                            {{ (!old('time_format') || old('time_format', settings('time_format')) == '24h') ? 'checked' : '' }}>
                                        24h
                                        <i class="input-helper"></i></label>
                                </div>

                                <div class="form-check form-check-secondary ">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input user-type-radio"
                                            name="time_format" value="12h" required
                                            {{ old('time_format', settings('time_format')) == '12h' ? 'checked' : '' }}>
                                        12h
                                        <i class="input-helper"></i></label>
                                </div>

                                @error('time_format')
                                <p class="error-message text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="form-group row @error('date_format') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="name">{{ __('Date Format') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="date_format"
                                style="width: 100%;" required>

                                <option value="" selected disabled>Select One</option>
                                <option value="DD-MM-YYYY" {{ old('date_format', settings('date_format')) == 'DD-MM-YYYY' ? "selected" : "" }}
                                    data-params="DD-MM-YYYY"> {{ __('DD-MM-YYYY') }} </option>
                                <option value="MM-DD-YYYY" {{ old('date_format', settings('date_format')) == 'MM-DD-YYYY' ? "selected" : "" }}
                                    data-params="MM-DD-YYYY"> {{ __('MM-DD-YYYY') }} </option>
                                <option value="YYYY-MM-DD" {{ old('date_format', settings('date_format')) == 'YYYY-MM-DD' ? "selected" : "" }}
                                    data-params="YYYY-MM-DD"> {{ __('YYYY-MM-DD') }} </option>
                                <option value="YYYY-DD-MM" {{ old('date_format', settings('date_format')) == 'YYYY-DD-MM' ? "selected" : "" }}
                                    data-params="YYYY-DD-MM"> {{ __('YYYY-DD-MM') }} </option>

                                <option value="DD/MM/YYYY" {{ old('date_format', settings('date_format')) == 'DD/MM/YYYY' ? "selected" : "" }}
                                    data-params="DD/MM/YYYY"> {{ __('DD/MM/YYYY') }} </option>
                                <option value="MM/DD/YYYY" {{ old('date_format', settings('date_format')) == 'MM/DD/YYYY' ? "selected" : "" }}
                                    data-params="MM/DD/YYYY"> {{ __('MM/DD/YYYY') }} </option>
                                <option value="YYYY/MM/DD" {{ old('date_format', settings('date_format')) == 'YYYY/MM/DD' ? "selected" : "" }}
                                    data-params="YYYY/MM/DD"> {{ __('YYYY/MM/DD') }} </option>
                                <option value="YYYY/DD/MM" {{ old('date_format', settings('date_format')) == 'YYYY/DD/MM' ? "selected" : "" }}
                                    data-params="YYYY/DD/MM"> {{ __('YYYY/DD/MM') }} </option>

                            </select>
                            @error('date_format')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('app_timezone') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="name">{{ __('Time Zone') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="app_timezone"
                                style="width: 100%;" id="timeZone" required>
                                <option value="" selected disabled>Select One</option>

                                @foreach($timezones as $key => $value)
                                    <option value="{{ $key }}" {{ old('app_timezone', settings('app_timezone')) == $key ? "selected" : "" }}
                                        data-params="{{ $key }}"> {{ $key }} </option>
                                @endforeach

                            </select>
                            @error('app_timezone')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="row mt-2">
            <div class="modal-footer justify-content-center col-md-12">
                {!! \App\Library\Html::btnReset() !!}
                {!! \App\Library\Html::btnSubmit() !!}
            </div>
        </div>
    </form>

@endsection

@include('admin.assets.select2')

@push('scripts')

<script>
    $(document).ready(function () {
        $("#timeZone").select2({
            placeholder: "Select One",
            allowClear: true,
        });
    });
</script>

@endpush
