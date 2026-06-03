@extends('seller.layouts.master')

@section('title', __('Immunization'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.member.immunization.show', $immunization->id)) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Immunization')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm col-md-6">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.member.immunization.update', $immunization->id) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <input type="hidden" name="done" value="done">
                    <input type="hidden" name="immunized_by" id="employee" value="{{ auth()->id() }}">

                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name" readonly
                                        value="{{ old('name', $immunization->name) }}" placeholder="{{ __('Name') }}" required>
                                    @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('immunized_date') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Immunisation Date') }}</label>
                                <div class="col-sm-9">

                                    <div class="input-group with-icon">
                                        <input type="text" class="form-control datetimepicker-min-today" name="immunized_date"
                                            value="{{ old('immunized_date') }}"
                                            placeholder="{{ config('app.input_date_time_format') }}" required>
                                        <i class="date-icon fa-solid fa-calendar-days"></i>
                                    </div>

                                    @error('immunized_date')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row  @error('immunized_note') error @enderror">
                                <label class="col-sm-3 col-form-label required"
                                    for="description">{{ __('Immunisation Note') }}</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="summernote"
                                        name="immunized_note">{{ old('note') }}</textarea>
                                    @error('immunized_note')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
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
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/member/immunization/create.js')
@endpush
