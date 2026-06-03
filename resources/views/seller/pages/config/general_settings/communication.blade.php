@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Communication')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <input type="hidden" name="communication" value="communication">

                    <div class="form-group row @error('phone') error @enderror">
                        <label class="col-sm-3 col-form-label ">{{ __('Mobile No') }}</label>
                        <div class="col-sm-9">
                            <div class="input-group mb-4">
                                {{-- <div class="input-group-prepend">
                                    <select name="country_code" class="input-group-text text-secondary" >
                                        @foreach($countries as $key => $country)
                                        <option value="{{ old('country_code', $country['code']) }}"
                                            {{($key == 'NZ' || $country['code'] == (explode('-', settings('phone')))[0] ) ? "selected" : ""}}>{{$key}} {{ $country['code']}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div> --}}
                                <input type="tel" name="phone" value="{{old('phone') ?? ((strpos(settings('phone'), '-') == true) ? (explode('-', settings('phone')))[1] : settings('phone')) }}" class="form-control"
                                    placeholder="{{ __('013 355 666') }}">
                            </div>
                            @error('phone')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('email') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Email') }}</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" value="{{ old('email') ?? settings('email')  }}"
                                placeholder="{{ __('example@example.com') }}" required>
                            @error('email')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group row @error('ticket_email') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('Ticket Notify Email') }}</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="ticket_email" value="{{ old('ticket_email') ?? settings('ticket_email')  }}"
                                placeholder="{{ __('Ticket create notification send to this email. (example@example.com)') }}">
                            @error('ticket_email')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div> --}}

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
