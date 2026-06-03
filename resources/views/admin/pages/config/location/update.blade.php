@extends('admin.layouts.master')

@section('title', __('Update Location'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.more_settings.location.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Location')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-md-8">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.config.more_settings.location.update', $location->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="p-sm-3">

                    <div class="form-group row @error('name') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', $location->name) }}" placeholder="{{ __('Write Location Name') }}">
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('ip') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('IP') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="ip"
                                value="{{ old('ip', $location->ip) }}" placeholder="{{ __('Write Location IP') }}"
                                required>
                            @error('ip')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('details') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="details">{{ __('Details') }}</label>
                        <div class="col-sm-9">
                        <textarea type="text" name="details" class="form-control"
                                placeholder="{{ __('Write Details.......') }}" rows="8" required>{{ old('details', $location->details) }}</textarea>
                            @error('details')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $location->id }}">

                </div>
                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('scripts')

@endpush
