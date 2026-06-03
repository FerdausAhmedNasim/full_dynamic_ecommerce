@extends('seller.layouts.master')

@section('title', __('New Certificates'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.profile.index') . '#tab-certificates') !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Certificates')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.certificate.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-lg-6 col-md-12">
                        <div class="p-sm-3">
                            <div class="form-group row @error('type') error @enderror">
                                <label class="col-sm-3 col-form-label required required"
                                    for="type">{{ __('Type of Certification') }}</label>
                                <div class="col-sm-9">
                                    <select class="select form-control" name="type"
                                        style="width: 100%;" id="certificationType" required>
                                        <option value="" selected disabled>Select One</option>
                                        @foreach($typeOfCertificates as $typeOfCertificate)
                                        <option value="{{ $typeOfCertificate }}"
                                            {{ old('type') == $typeOfCertificate ? "selected" : "" }}>
                                            {{ $typeOfCertificate }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('facilitator') error @enderror">
                                <label
                                    class="col-sm-3 col-form-label required">{{ __('Facilitor') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="facilitator"
                                        value="{{ old('facilitator') }}" placeholder="{{ __('Facilitor') }}"
                                        id="certificationFacilitator" required>
                                    @error('facilitator')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('training_place') error @enderror">
                                <label
                                    class="col-sm-3 col-form-label required">{{ __('Training Place') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="training_place"
                                        value="{{ old('training_place') }}"
                                        placeholder="{{ __('Training Place') }}" id="certificationTrainingPlace" required>
                                    @error('training_place')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('compilation_date') error @enderror">
                                <label
                                    class="col-sm-3 col-form-label required">{{ __('Completion Date') }}</label>
                                <div class="col-sm-9">

                                    <div class="input-group with-icon">
                                        <input type="text" class="form-control datepicker-max-today" name="compilation_date"
                                            value="{{ old('compilation_date') }}" placeholder="{{ config('app.input_date_format') }}"
                                            id="certificationComplitionDate" required>
                                        <i class="date-icon fa-solid fa-calendar-days"></i>
                                    </div>

                                    @error('compilation_date')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('expire_date') error @enderror">
                                <label
                                    class="col-sm-3 col-form-label required">{{ __('Expired Date') }}</label>
                                <div class="col-sm-9">

                                    <div class="input-group with-icon">
                                        <input type="text" class="form-control datepicker" name="expire_date"
                                            value="{{ old('expire_date') }}" placeholder="{{ config('app.input_date_format') }}"
                                            id="certificationExpireDate" required>
                                        <i class="date-icon fa-solid fa-calendar-days"></i>
                                    </div>

                                    @error('expire_date')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 pl-3">
                        <div class="p-sm-3">
                            <div class="form-group row @error('score') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Score') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="score" min=".01" step="0.01"
                                        value="{{ old('score') }}" id="certificationScore" placeholder="{{ __('Ex: 3.5') }}"
                                        required>
                                    @error('score')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('cost') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Cost') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="cost" step="0.01"
                                        value="{{ old('cost') }}" id="certificationCost" placeholder="{{ __('Ex: 1200.50') }}"
                                        required>
                                    @error('cost')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('description') error @enderror">
                                <label class="col-sm-3 col-form-label"
                                    for="name">{{ __('Description') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" name="description" class="form-control"
                                        placeholder="{{ __('Write Your Description') }}"
                                        rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('documents') error @enderror">
                                <label class="col-sm-3 col-form-label">Documents</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="documents" type="file" class="form-control d-none"
                                            allowed="png,gif,jpeg,jpg,pdf,docx">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info"
                                                disabled="" readonly
                                                placeholder="Size: 200x200 and max 500kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i>
                                                    Browse</button>
                                            </span>
                                        </div>
                                        @error('documents')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        <div class="display-input-image d-none">
                                            <img src="{{ Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                                title="Remove">x</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row @error('name') error @enderror">
                                <label
                                    class="col-sm-3 col-form-label">{{ __('Documents Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name') }}"
                                        placeholder="{{ __('Documents Name required if attached any documents') }}" id="documentsName">
                                    @error('name')
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

@include('admin.assets.datetimepicker')

@push('scripts')
{{-- @vite('resources/admin_assets/js/pages/ams/product/create.js') --}}
@endpush
