@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Color Settings')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">
                    <div class="border p-3 mb-3">
                        <h4 class="mb-3" title="Used for General Settings active Tabs, Sidebar text and icons color">
                            Primary Button</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group row @error('btn_primary') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Button Primary') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="btn_primary"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('btn_primary') ?? settings('btn_primary') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('btn_primary')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('btn_primary_text') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Button Primary Text') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="btn_primary_text"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('btn_primary_text') ?? settings('btn_primary_text') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('btn_primary_text')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('btn_primary_hover') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Button Primary Hover') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="btn_primary_hover"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('btn_primary_hover') ?? settings('btn_primary_hover') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('btn_primary_hover')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('btn_primary_text_hover') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Primary Hover Text') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="btn_primary_text_hover"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('btn_primary_text_hover') ?? settings('btn_primary_text_hover') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('btn_primary_text_hover')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="border p-3 mb-3">
                        <h4 class="mb-3" title="Used for General Settings Tabs color, Sidebar text and icons active color, Save button, Tab button.">Secondary Button</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group row @error('btn_secondary') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Button Secondary') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="btn_secondary"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('btn_secondary') ?? settings('btn_secondary') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('btn_secondary')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('btn_secondary_text') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Button Secondary Text') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="btn_secondary_text"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('btn_secondary_text') ?? settings('btn_secondary_text') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('btn_secondary_text')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('btn_secondary_hover') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Button Secondary Hover') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="btn_secondary_hover"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('btn_secondary_hover') ?? settings('btn_secondary_hover') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('btn_secondary_hover')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group row @error('btn_secondary_text_hover') error @enderror">
                                    <label class="col-sm-8 col-form-label ">{{ __('Secondary Hover Text') }}</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-4">
                                            <input type="color" name="btn_secondary_text_hover"
                                                class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                                value="{{ old('btn_secondary_text_hover') ?? settings('btn_secondary_text_hover') }}"
                                                title="Choose your color">
                                        </div>
                                        @error('btn_secondary_text_hover')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="border p-3 mb-3">
                    <h4 class="mb-3" title="Used for reset button and others button">Light Button</h4>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group row @error('btn_light') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Button Light') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="btn_light"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('btn_light') ?? settings('btn_light') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('btn_light')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('btn_light_text') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Button Light Text') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="btn_light_text"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('btn_light_text') ?? settings('btn_light_text') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('btn_light_text')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('btn_light_hover') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Button Light Hover') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="btn_light_hover"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('btn_light_hover') ?? settings('btn_light_hover') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('btn_light_hover')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('btn_light_text_hover') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Button Light Hover Text') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="btn_light_text_hover"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('btn_light_text_hover') ?? settings('btn_light_text_hover') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('btn_light_text_hover')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    </div> --}}

                    {{-- <div class="border p-3 mb-3">
                    <h4 class="mb-3" title="Used for Disabled and status button">Disabled Button</h4>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group row @error('btn_disabled') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Button Disabled') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="btn_disabled"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('btn_disabled') ?? settings('btn_disabled') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('btn_disabled')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('btn_disabled_hover') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Button Disabled Hover') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="btn_disabled_hover"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('btn_disabled_hover') ?? settings('btn_disabled_hover') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('btn_disabled_hover')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    </div> --}}

                    <div class="border p-3 mb-3">
                    <h4 class="mb-3" title="Used for only Card">Card Color</h4>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group row @error('card_heading') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Card Heading') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="card_heading"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('card_heading') ?? settings('card_heading') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('card_heading')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('card_bg') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Card BG') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="card_bg"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('card_bg') ?? settings('card_bg') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('card_bg')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('card_heading_text') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Card Heading Text') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="card_heading_text"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('card_heading_text') ?? settings('card_heading_text') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('card_heading_text')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="border p-3 mb-3">
                    <h4 class="mb-3" title="Used for Table heading, button">Table Color</h4>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group row @error('table_heading') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Table Heading') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="table_heading"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('table_heading') ?? settings('table_heading') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('table_heading')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('table_heading_text') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Table Heading Text') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="table_heading_text"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('table_heading_text') ?? settings('table_heading_text') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('table_heading_text')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('table_btn') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Table Button') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="table_btn"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('table_btn') ?? settings('table_btn') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('table_btn')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('table_btn_hover') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Table Button Hover') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="table_btn_hover"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('table_btn_hover') ?? settings('table_btn_hover') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('table_btn_hover')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="border p-3 mb-3">
                    <h4 class="mb-3" title="Used for Geneal Text color, Text heading And Background color.">General Color</h4>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group row @error('general_text') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('General Text') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="general_text"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('general_text') ?? settings('general_text') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('general_text')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('text_heading') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Text Heading') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="text_heading"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('text_heading') ?? settings('text_heading') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('text_heading')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('bg_color') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('BG Color') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="bg_color"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('bg_color') ?? settings('bg_color') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('bg_color')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group row @error('tab_color') error @enderror">
                                <label class="col-sm-8 col-form-label ">{{ __('Tab Color') }}</label>
                                <div class="col-sm-4">
                                    <div class="input-group mb-4">
                                        <input type="color" name="tab_color"
                                            class="form-control py-1 px-1 form-control-color" id="exampleColorInput"
                                            value="{{ old('tab_color') ?? settings('tab_color') }}"
                                            title="Choose your color">
                                    </div>
                                    @error('tab_color')
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
                axios.post('{{ route('admin.config.general_settings.color.reset', "backend") }}', {
                        _token: '{{ csrf_token() }}'
                    })
                    .then(function(response) {
                        notify('Color settings have been reset!', 'success')
                        setTimeout(function() {
                            window.location.href = '{{ route('admin.config.general_settings.backend.color') }}';
                        }, 2000);
                    })
                    .catch(function(error) {
                        console.error('There was an error resetting the colors:', error);
                    });

            })
        })
    </script>
@endpush
