@extends('seller.layouts.master')

@section('title', __('New Immunization'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('seller.member.show.immunization', $member->id)) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Immunization')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm col-md-6">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.member.immunization.store', $member->id) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}" placeholder="{{ __('Name') }}" required>
                                    @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('target_date') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Target Date') }}</label>
                                <div class="col-sm-9">

                                    <div class="input-group with-icon">
                                        <input type="text" class="form-control datetimepicker-min-today" name="target_date" required
                                            value="{{ old('target_date') }}" placeholder="{{ config('app.input_date_time_format') }}">
                                        <i class="date-icon fa-solid fa-calendar-days"></i>
                                    </div>

                                    @error('target_date')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row  @error('target_note') error @enderror">
                                <label class="col-sm-3 col-form-label"
                                    for="description">{{ __('Target Note') }}</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="target_note"
                                        name="target_note">{{ old('note') }}</textarea>
                                    @error('target_note')
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
