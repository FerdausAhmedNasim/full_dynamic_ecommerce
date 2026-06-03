@extends('admin.layouts.master')
@section('title', __('Update Benefit'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.website.benefit.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Benefit')) }}</h4>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-3">
                <div class="card-body py-sm-4">
                    <form method="post"
                        action="{{ route('admin.website.benefit.update', $benefit->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="p-sm-3">

                            <div class="form-group row @error('Title') error @enderror">
                                <label class="col-sm-3 required">{{ __('Title') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title', $benefit->title) }}"
                                        placeholder="{{ __('Title') }}" required>
                                    @error('title')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('sub_title') error @enderror">
                                <label class="col-sm-3 required">{{ __('Subtitle') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="sub_title"
                                        value="{{ old('sub_title', $benefit->sub_title) }}"
                                        placeholder="{{ __('Subtitle') }}" required>
                                    @error('sub_title')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('order') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Order') }}
                                    <span class="fw-lighter text-smaller">(to show Menu sidebar)</span>
                                </label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="order"
                                        value="{{ old('order', $benefit->order) }}"
                                        placeholder="{{ __('Ex: 1') }}">
                                    @error('order')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('image') error @enderror">
                            <label class="required col-sm-3"
                                    for="description">{{ __('Icon Image') }}
                                    <span class="fw-lighter text-smaller">(only svg)</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="image" type="file" class="form-control hidden_file"
                                            allowed="svg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('image') error @enderror"
                                                disabled="" readonly placeholder="Type:svg, Max:1024kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image">
                                            <img src="{{ $benefit->getImage() }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('image')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
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
    </div>
</div>
@stop

    @include('admin.assets.select2')

    @push('scripts')
        @vite('resources/admin_assets/js/select2.js')
        @endpush