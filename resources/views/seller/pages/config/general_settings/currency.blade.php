@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Currency Settings')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <input type="hidden" name="currency" value="currency">

                    <div class="form-group row @error('currency_name') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Currency Name') }}</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="currency_name" value="{{ old('currency_name', settings('currency_name')) }}" placeholder="{{ __('Currency Name') }}">
                            @error('currency_name')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('currency_symbol') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="name">{{ __('Currency Symbol') }}</label>
                        <div class="col-sm-9">
                            <input class="form-control" name="currency_symbol" value="{{ old('currency_symbol', settings('currency_symbol')) }}" placeholder="{{ __('Currency Symbol') }}">
                            @error('currency_symbol')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('currency_position') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Currency Position') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="currency_position"
                                style="width: 100%;">
                                <option value="" selected disabled>Select One</option>
                                <option value="left" {{ old('currency_position', settings('currency_position')) == 'left' ? "selected" : "" }}
                                    data-params="left"> {{ __('Left ($0.00)') }} </option>
                                <option value="right" {{ old('currency_position', settings('currency_position')) == 'right' ? "selected" : "" }}
                                    data-params="right"> {{ __('Right (0.00$)') }} </option>

                            </select>
                            @error('currency_position')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('decimal_separator') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Decimal Separator') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="decimal_separator"
                                style="width: 100%;">
                                <option value="" selected disabled>Select One</option>
                                <option value="." {{ old('decimal_separator', settings('decimal_separator')) == '.' ? "selected" : "" }}
                                    data-params="."> {{ __('Dot (0.00)') }} </option>
                                <option value="," {{ old('decimal_separator', settings('decimal_separator')) == ',' ? "selected" : "" }}
                                    data-params=","> {{ __('Comma (0,00)') }} </option>

                            </select>
                            @error('decimal_separator')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('thousand_separator') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Thousand Separator') }}</label>
                        <div class="col-sm-9">
                            <select class="select form-control" name="thousand_separator"
                                style="width: 100%;">
                                <option value="" selected disabled>Select One</option>
                                <option value="space" {{ old('thousand_separator', settings('thousand_separator')) == 'space' ? "selected" : "" }}
                                    data-params="space"> {{ __('Space (1 00 000)') }} </option>
                                <option value="comma" {{ old('thousand_separator', settings('thousand_separator')) == 'comma' ? "selected" : "" }}
                                    data-params="comma"> {{ __('Comma (1,00,000)') }} </option>

                            </select>
                            @error('thousand_separator')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('number_of_decimal') error @enderror">
                        <label class="col-sm-3 col-form-label" for="name">{{ __('Number of Decimal') }}</label>
                        <div class="col-sm-9">
                            <div class="d-inline-flex justify-content-start">
                                <div class="form-check form-check-secondary mr-5">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input user-type-radio"
                                            name="number_of_decimal" value="0"
                                            {{ (!old('number_of_decimal') || old('number_of_decimal', settings('number_of_decimal')) == '0') ? 'checked' : '' }}>
                                        0
                                        <i class="input-helper"></i></label>
                                </div>

                                <div class="form-check form-check-secondary  mr-5">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input user-type-radio"
                                            name="number_of_decimal" value="2"
                                            {{ old('number_of_decimal', settings('number_of_decimal')) == '2' ? 'checked' : '' }}>
                                        2
                                        <i class="input-helper"></i></label>
                                </div>

                                <div class="form-check form-check-secondary ">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input user-type-radio"
                                            name="number_of_decimal" value="3"
                                            {{ old('number_of_decimal', settings('number_of_decimal')) == '3' ? 'checked' : '' }}>
                                        3
                                        <i class="input-helper"></i></label>
                                </div>

                                @error('number_of_decimal')
                                <p class="error-message text-danger">{{ $message }}</p>
                                @enderror
                            </div>

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
