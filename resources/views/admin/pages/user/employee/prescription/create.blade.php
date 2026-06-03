@extends('admin.layouts.master')

@section('title', __('New Note'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.employee.show', $employee->id).'#tab-note') !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Note')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm col-lg-8  col-md-12">
        <div class="card-body py-sm-4">
            <form method="post" class="form" action="{{ route('admin.user.employee.prescription.create', $employee->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="p-sm-3">

                    <div class="form-group row @error('title') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Title') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                placeholder="{{ __('Title') }}" required>
                            @error('title')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('description') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="description">{{ __('Description') }}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="summernote"
                                name="description" placeholder="Write here Description About Note....">{{ old('description') }}</textarea>

                                @error('description')
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
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/user/employee/prescription/create.js')
@endpush
