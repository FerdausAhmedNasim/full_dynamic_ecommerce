@extends('admin.layouts.master')

@section('title', __('New Alert'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.more_settings.alert.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Alert')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-md-8">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.config.more_settings.alert.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="p-sm-3">

                    <div class="form-group row @error('name') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Alert Name') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name') }}" placeholder="{{ __('Write a Alert Name') }}" required>
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('parent_alert') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Parent Category') }}</label>
                        <div class="col-sm-9">
                        
                            <select class="form-control select2" name="parent_alert" required>
                                <option value="" class="selected highlighted" selected>Select One</option>
                                @foreach($parentAlerts as $key => $parent)
                                    <option class="text-capitalize" value="{{ $parent }}" {{ old('parent_alert') == $parent ? "selected" : ""}}>
                                        {{ $parent }}
                                    </option> 
                                @endforeach
                            </select>
                            @error('parent_alert')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('details') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="details">{{ __('Details') }}</label>
                        <div class="col-sm-9">
                        <textarea type="text" name="details" class="form-control"
                                placeholder="{{ __('Write Details.......') }}" rows="8" required>{{ old('details') }}</textarea>
                            @error('details')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

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

@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/select2.js')
@endpush