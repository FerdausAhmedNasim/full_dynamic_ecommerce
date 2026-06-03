@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Color Settings')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">
                    <div class="border p-3 mb-3">
                        <h4 class="mb-3">Select Colors</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group row @error('primary_color') error @enderror">
                                    <label class="col-sm-8 col-form-label " title="Top header,card btn, tab, card price, breadcrumb first heading, footer link hover.">{{ __('Primary Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="primary_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('primary_color') ?? settings('primary_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('primary_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('secondary_color') error @enderror">
                                    <label class="col-sm-8 col-form-label " title="search btn, bottom header, product details tab.">{{ __('Secondary Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="secondary_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('secondary_color') ?? settings('secondary_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('secondary_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('accent_color') error @enderror">
                                    <label class="col-sm-8 col-form-label " title="buy btn, sing up, login btn.">{{ __('Accent Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="accent_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('accent_color') ?? settings('accent_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('accent_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('background_color') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Background Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="background_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('background_color') ?? settings('background_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('background_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('breadcrumb_bg_color') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Breadcrumb BG Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="breadcrumb_bg_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('breadcrumb_bg_color') ?? settings('breadcrumb_bg_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('breadcrumb_bg_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('footer_color') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Footer BG Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="footer_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('footer_color') ?? settings('footer_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('footer_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('general_color') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('General Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="general_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('general_color') ?? settings('general_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('general_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('heading_text') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Heading Text') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="heading_text"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('heading_text') ?? settings('heading_text') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('heading_text')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('secondary_text') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Secondary Text') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="secondary_text"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('secondary_text') ?? settings('secondary_text') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('secondary_text')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('card_color') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Card Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="card_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('card_color') ?? settings('card_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('card_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('card_hover_color') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Card Hover Color') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="card_hover_color"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('card_hover_color') ?? settings('card_hover_color') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('card_hover_color')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('button[type="reset"]').click(function() {
                axios.post('{{ route('admin.config.general_settings.color.reset', "frontend") }}', {
                        _token: '{{ csrf_token() }}'
                    })
                    .then(function(response) {
                        notify('Color settings have been reset!', 'success')
                        setTimeout(function() {
                            window.location.href = '{{ route('admin.config.general_settings.frontend.color') }}';
                        }, 2000);
                    })
                    .catch(function(error) {
                        console.error('There was an error resetting the colors:', error);
                    });

            })
        })
    </script>
@endpush
