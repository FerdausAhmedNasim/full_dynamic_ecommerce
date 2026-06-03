@extends('admin.layouts.master')

@section('title', __('Update Discount'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.more_settings.discount.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Discount')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-md-8">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.config.more_settings.discount.update', $discount->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="p-sm-3">

                    <div class="form-group row @error('title') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Title') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title"
                                value="{{ old('title', $discount->title) }}" placeholder="{{ __('Write a Discount Title') }}"
                                required>
                            @error('title')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('amount') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Amount') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="amount" step="0.01"
                                value="{{ old('amount', $discount->amount) }}" placeholder="{{ __('Amount') }}" required>
                            @error('amount')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('start_date') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('Start Date') }}</label>
                        <div class="col-sm-9">
                            <div class="input-group with-icon">
                                <input type="text" name="start_date" id="start_date"
                                    class="form-control datepicker-min-today"
                                    value="{{ old('start_date', getFormattedDate($discount->start_date)) }}" placeholder="{{ settings('date_format') }}">
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>
                            @error('start_date')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('end_date') error @enderror">
                        <label class="col-sm-3 col-form-label">{{ __('End Date') }}</label>
                        <div class="col-sm-9">
                            <div class="input-group with-icon">
                                <input type="text" name="end_date" id="end_date"
                                    class="form-control datepicker-min-today"
                                    value="{{ old('end_date', getFormattedDate($discount->end_date)) }}" placeholder="{{ settings('date_format') }}">
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>
                            @error('end_date')
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

@include('admin.assets.datetimepicker')

@push('scripts')

@endpush
