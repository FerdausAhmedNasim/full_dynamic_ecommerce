@extends('admin.layouts.master')
@section('title', __('Update Category'))
@section('category', 'active')

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.category.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Category')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.components.product_topbar')
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm mt-3">
                <div class="card-body py-sm-4">
                    <form method="post" action="{{ route('admin.category.update', $category->id) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="p-sm-3">

                            <div class="form-group row @error('name') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $category->getTranslation('title')) }}" placeholder="{{ __('Name') }}"
                                        required>
                                    @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row @error('parent_id') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Parent Category') }}</label>
                                <div class="col-sm-9">

                                    <select class="form-control select2" name="parent_id">
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($categories as $key => $cat)
                                        <option class="text-capitalize" value="{{ $cat->id }}"
                                            {{ old("parent_id") ?? $category->parent_id == $cat->id ? "selected" : ""}}>
                                            {{ $cat->getTranslation('title') }}
                                        </option>

                                        @foreach($cat->childrenCategories as $key => $subCategory)
                                        @if ($subCategory->categories)
                                        <option class="text-capitalize" value="{{ $subCategory->id }}"
                                            {{ old("parent_id") ?? $category->parent_id == $subCategory->id ? "selected" : ""}}>
                                            &nbsp;-{{ $subCategory->getTranslation('title') }}
                                        </option>
                                        @endif

                                        @endforeach
                                        @endforeach
                                    </select>
                                    @error('parent_id')
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
                                        value="{{ old('order', $category->order) }}" placeholder="{{ __('Ex: 1') }}">
                                    @error('order')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('thumbnail') error @enderror">
                                <label class="col-sm-3 col-form-label" for="description">{{ __('Thumbnail') }}</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="thumbnail" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('thumbnail') error @enderror"
                                                disabled="" readonly placeholder="Size:140x160, Max:1024kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image">
                                            <img src="{{ $category->getThumbnailImage() }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('thumbnail')
                                        <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row @error('icon') error @enderror">
                                <label class="col-sm-3 col-form-label" for="description">{{ __('Icon') }}
                                    <span class="fw-lighter text-smaller">(only SVG)</span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="icon" type="file" class="form-control hidden_file" allowed="svg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('icon') error @enderror"
                                                disabled="" readonly placeholder="Size: 140x160 and max 1024kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image">
                                            <img src="{{ $category->getIconImage() }}" alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('icon')
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
