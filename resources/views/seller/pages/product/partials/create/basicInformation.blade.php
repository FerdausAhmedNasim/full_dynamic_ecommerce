<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="p-sm-3">
            <div class="row">

                <div class="col-sm-6 form-group  @error('title') error @enderror">
                    <label class="col-form-label required">{{ __('Product Name') }}</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                        placeholder="{{ __('Product Name') }}" id="productTitle" required>
                    @error('title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-6 form-group  @error('category_id') error @enderror">
                    <label class="col-form-label required">{{ __('Category') }}</label>
                    <select class="form-control" name="category_id" id="categories" required>
                        <option value="" class="selected highlighted">Select One</option>
                        @foreach ($categories as $key => $category)
                            <option class="text-capitalize" value="{{ $category->category_id }}"
                                {{ old('category_id') == $category->category_id ? 'selected' : '' }}>
                                {{ $category->category->getTranslation('title') }}
                            </option>

                            @foreach ($category->category->childrenCategories as $key => $subCategory)
                                @if ($subCategory->categories)
                                    <option class="text-capitalize" value="{{ $subCategory->id }}"
                                        {{ old('category_id') == $subCategory->id ? 'selected' : '' }}>
                                        &nbsp;¦--{{ $subCategory->getTranslation('title') }}
                                    </option>
                                @endif

                                @foreach ($subCategory->childrenCategories as $key => $subSubCat)
                                    @if ($subSubCat->categories)
                                        <option class="text-capitalize" value="{{ $subSubCat->id }}"
                                            {{ old('category_id') == $subSubCat->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;¦--¦--{{ $subSubCat->getTranslation('title') }}
                                        </option>
                                    @endif

                                    @foreach ($subSubCat->childrenCategories as $key => $subSub2Cat)
                                        @if ($subSub2Cat->categories)
                                            <option class="text-capitalize" value="{{ $subSub2Cat->id }}"
                                                {{ old('category_id') == $subSub2Cat->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;¦--¦--¦--{{ $subSub2Cat->getTranslation('title') }}
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

                <div class="col-sm-6 form-group  @error('brand_id') error @enderror">
                    <label class="col-form-label">{{ __('Brand') }}</label>
                    <select class="form-control" name="brand_id" id="brand">
                        <option value="" class="selected highlighted">Select One</option>
                        @foreach ($brands as $brand)
                            <option class="text-capitalize" value="{{ $brand->id }}"
                                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->getTranslation('title') }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-6 form-group  @error('unit') error @enderror">
                    <label class="col-form-label">{{ __('Unit') }}</label>
                    <select class="form-control" name="unit" id="unit">
                        <option value="" class="selected highlighted">Select One</option>
                        @foreach ($units as $value)
                            <option class="text-capitalize" value="{{ $value }}"
                                {{ old('unit') == $value ? 'selected' : '' }}>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('unit')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-6 form-group  @error('weight') error @enderror">
                    <label class="col-form-label required">{{ __('Weight') }}</label>
                    <input type="number" min="0" step="any" class="form-control" name="weight" value="{{ old('weight') }}"
                        placeholder="{{ __('Weight') }}" id="weight" required>
                    @error('weight')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-6 form-group  @error('dimension') error @enderror">
                    <label class="col-form-label">{{ __('Dimension') }}</label>

                    <div class="row">
                        <div class="col-md-4">
                            <input type="number" min="0" step="any" class="form-control" name="length" value="{{ old('length') }}" placeholder="{{ __('Length') }}" id="length">
                        </div>
                        <div class="col-md-4">
                            <input type="number" min="0" step="any" class="form-control" name="width" value="{{ old('width') }}" placeholder="{{ __('Width') }}" id="width">
                        </div>
                        <div class="col-md-4">
                            <input type="number" min="0" step="any" class="form-control" name="height" value="{{ old('height') }}" placeholder="{{ __('Height') }}" id="height">
                        </div>
                    </div>
                    
                    @error('dimension')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-6 form-group  @error('minimum_order_quantity') error @enderror">
                    <label class="col-form-label required">{{ __('Min. Order Quantity') }}</label>
                    <input type="number" class="form-control" name="minimum_order_quantity" required
                        value="{{ old('minimum_order_quantity') }}" placeholder="{{ __('Min. Order Quantity') }}">
                    @error('minimum_order_quantity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-6 form-group  @error('barcode') error @enderror">
                    <label class="col-form-label">{{ __('Barcode') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="barcode" value="{{ old('barcode') }}" id="barcode" placeholder="{{ __('Barcode') }}">
                        <div class="input-group-append barcode">
                            <i class="ti-reload input-group-text"></i>
                        </div>
                    </div>

                    @error('barcode')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-12 form-group  @error('tags') error @enderror">
                    <label class="col-form-label">{{ __('Tags') }}</label>
                    <input type="text" name="tags[]" value="{{ old('tags[]') }}" class="form-control tokenfield" id="productTags" placeholder="Write & Hit Enter" />
                    @error('tags')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>
        </div>
    </div>
</div>
