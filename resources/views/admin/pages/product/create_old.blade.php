@extends('admin.layouts.master')

@section('title', __('New Product'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.product.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Product')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
                @csrf
                {{-- @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{$error}}</div>
                    @endforeach
                @endif --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('title') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Product Name') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title') }}" placeholder="{{ __('Product Name') }}"
                                        required>
                                    @error('title')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('category_id') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Category') }}</label>
                                <div class="col-sm-9">

                                    {{-- <select class="form-control" name="category_id" id="categories" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach ($categories as $category)

                                            <option>
                                                {{ ucwords($category->name) }}
                                            </option>

                                            @foreach ($category->childrenCategories as $childCategory)
                                                @include('admin.pages.ams.product.child_category', ['child_category' => $childCategory])
                                            @endforeach

                                        @endforeach
                                    </select> --}}

                                    <select class="form-control" name="category_id" id="categories" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($categories as $key => $category)
                                            <option class="text-capitalize" value="{{ $category->id }}" {{ old("category_id") == $category->id ? "selected" : ""}}>
                                                {{ $category->name }}
                                            </option>

                                            @foreach($category->childrenCategories as $key => $subCategory)
                                                    @if ($subCategory->categories)
                                                    <option class="text-capitalize" value="{{ $subCategory->id }}" {{ old("category_id") == $subCategory->id ? "selected" : ""}}>
                                                        &nbsp;-{{ $subCategory->name }}
                                                    </option>
                                                    @endif

                                                    @foreach($subCategory->childrenCategories as $key => $subSubCat)
                                                        @if ($subSubCat->categories)
                                                            <option class="text-capitalize" value="{{ $subSubCat->id }}" {{ old("category_id") == $subSubCat->id ? "selected" : ""}}>
                                                                &nbsp;&nbsp;--{{ $subSubCat->name }}
                                                            </option>
                                                        @endif

                                                        @foreach($subSubCat->childrenCategories as $key => $subSub2Cat)
                                                            @if ($subSub2Cat->categories)
                                                                <option class="text-capitalize" value="{{ $subSub2Cat->id }}" {{ old("category_id") == $subSub2Cat->id ? "selected" : ""}}>
                                                                    &nbsp;&nbsp;&nbsp;---{{ $subSub2Cat->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('Brand') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="brand" id="brand">
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($brands as $value)
                                            <option class="text-capitalize" value="{{ $value }}" {{(old("brand") == $value) ? "selected" : ""}}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label required">{{ __('Unit') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="unit" id="unit" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($units as $value)
                                            <option class="text-capitalize" value="{{ $value }}" {{(old("unit") == $value) ? "selected" : ""}}>
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('Model') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="model"
                                        value="{{ old('model') }}" placeholder="{{ __('Model') }}"
                                        >
                                </div>
                            </div>

                            <div class="form-group row @error('Featured Image') error @enderror">
                                <label class="col-sm-3 col-form-label required" for="description">{{ __('Featured Image') }}</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="featured_image" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg" required>
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('featured_image') error @enderror"
                                                disabled="" readonly placeholder="Size: 750x750 and max 1024kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>

                                        </div>
                                        <div class="display-input-image d-none">
                                            <img src="{{ asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove"
                                                title="Remove">x</button>
                                        </div>
                                        @error('featured_image')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="form-group row @error('is_featured') error @enderror">
                                <label class="col-sm-3 col-form-label" for="is_featured">{{ __('Is Featured') }} </label>
                                <div class="col-md-9">
                                    <div class="form-check form-check-success">
                                        <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input is_featured" name="is_featured" onchange="isFeatured()"
                                        {{ $checkFeaturedPost ? 'disabled' : '' }} {{ old('is_featured') ? 'checked' : '' }}>
                                        <i class="input-helper"></i></label>
                                    </div>
                                    @error('is_featured')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror

                                </div>
                            </div> --}}

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="description">{{ __('Short Description') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="short_description">{{ old('short_description') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label" for="description">{{ __('Description') }}</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="summernote" name="description">{{ old('description') }}</textarea>
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
@vite('resources/admin_assets/js/pages/product/create.js')
@endpush
