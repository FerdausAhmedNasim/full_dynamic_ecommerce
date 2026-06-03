@extends('admin.layouts.master')

@section('title', __('New Service'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.more_settings.service.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Service')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" id="service-form" action="{{ route('admin.config.more_settings.service.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Service Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" placeholder="{{ __('Name') }}"
                                        required>
                                    @error('name')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('service_manager_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Service Manager') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="service_manager_id" id="service_manager" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($employees as $key => $employee)
                                            <option value="{{ $employee->id }}" {{(old("service_manager_id") == $employee->id) ? "selected" : ""}}>
                                                {{ $employee->user?->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_manager_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('kaimahi_ids') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Kaimahi Ids') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="kaimahi_ids[]" id="kaimahi_ids" multiple required>
                                        @foreach($employees as $key => $employee)
                                            <option value="{{ $employee->id }}" {{ (collect(old('kaimahi_ids'))->contains($employee->id)) ? 'selected':'' }} >
                                                {{ $employee->user?->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('kaimahi_ids')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('location') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Location') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="location" id="location" required >
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($locations as $value)
                                            <option class="text-capitalize" value="{{ $value->name }}" {{(old("location") == $value->name) ? "selected" : ""}}>
                                                {{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('location')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('reporting_frequency') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Reporting Frequency') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="reporting_frequency" id="reporting_frequency"
                                        value="{{ old('reporting_frequency') }}" min=1 placeholder="{{ __('Reporting Frequency') }}"
                                        required>
                                    @error('reporting_frequency')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('start_date') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="name">{{ __('Start Date') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="start_date" max="{{ now()->format('Y-m-d') }}" id="start_date" class="form-control"
                                        value="{{old('start_date')}}" required>
                                    @error('start_date')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('end_date') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="name">{{ __('End Date') }}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="end_date" min="{{ now()->format('Y-m-d') }}" id="end_date" class="form-control"
                                        value="{{old('end_date')}}" required>
                                    @error('end_date')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="p-sm-3 col-sm-12">

                                <div class="form-group row @error('funder_name') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Funder Name') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="funder_name" id="funder_name"
                                            value="{{ old('funder_name') }}" placeholder="{{ __('Funder Name') }}"
                                            required>
                                        @error('funder_name')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('funder_details') error @enderror">
                                    <label class="col-sm-3 col-form-label" for="funder_details">{{ __('Funder Details') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="funder_details" class="form-control"
                                            placeholder="{{ __('Write About Asset') }}" rows="4">{{ old('funder_details') }}</textarea>
                                        @error('funder_details')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('description') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="description">{{ __('Description') }}</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="summernote" name="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
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

@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/config/service/create.js')
@vite('resources/admin_assets/js/select2.js')
@endpush
