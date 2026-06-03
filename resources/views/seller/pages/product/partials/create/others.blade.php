<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="p-sm-3">

            <div class="form-group row mt-2 @error('refundable') error @enderror">
                <label class="col-md-3 col-from-label">Refundable</label>
                <div class="col-md-9">
                    <label class="custom-switch">
                        <input type="checkbox" value="1" {{ old('refundable') == 1 ? 'checked' : '' }} name="refundable" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Is Product Refundable</span>
                    </label>
                    @error('refundable')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if(false)
            <div class="form-group row mt-2 @error('featured') error @enderror">
                <label class="col-md-3 col-from-label">Featured</label>
                <div class="col-md-9">
                    <label class="custom-switch">
                        <input type="checkbox" value="1" {{ old('featured') == 1 ? 'checked' : '' }} name="featured" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Is Product Featured</span>
                    </label>
                    @error('featured')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row mt-2 @error('todays_deal') error @enderror">
                <label class="col-md-3 col-from-label">Today's Deals</label>
                <div class="col-md-9">
                    <label class="custom-switch">
                        <input type="checkbox" value="1" {{ old('todays_deal') == 1 ? 'checked' : '' }} name="todays_deal" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Is Product Today's Deals</span>
                    </label>
                    @error('todays_deal')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @endif

        </div>
    </div>
</div>


<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="p-sm-3" id="productService">

            <div class="row">
                <div class="col-sm-6">
                    <h4>Product Service</h4>
                </div>
            </div>
            <hr/>

            <div class="row">
                <div class="col-sm-4 form-group  @error('product_service_title') error @enderror">
                    <label class="col-form-label required">{{ __('Title') }}</label>
                    <input type="text" class="form-control" name="product_service_title[]" maxlength="30" required value="{{ old('product_service_title[]') }}" placeholder="{{ __('Product Service Title') }}">
                    @error('product_service_title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-4 form-group  @error('product_service_sub_title') error @enderror">
                    <label class="col-form-label required">{{ __('Sub Title') }}</label>
                    <input type="text" class="form-control" name="product_service_sub_title[]" maxlength="30" required value="{{ old('product_service_sub_title[]') }}" placeholder="{{ __('Product Service Sub Title') }}">
                    @error('product_service_sub_title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-2 form-group  @error('product_service_order') error @enderror">
                    <label class="col-form-label required">{{ __('Order') }}</label>
                    <input type="number" class="form-control" name="product_service_order[]" min="1" max="3" required value="{{ old('product_service_order[]') }}" placeholder="{{ __('Product Service Order') }}">
                    @error('product_service_order')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                {{-- <div class="col-sm-4 form-group file-upload-section @error('product_service_icon') error @enderror">
                    <label class="col-form-label required">{{ __('Icon') }}</label>
                    <div class="row">
                        <div class="col-md-9">
                            <input name="product_service_icon[]" type="file" class="form-control d-none" allowed="webp,png,gif,jpeg,jpg">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled="" readonly placeholder="Size: 750X750 and max 512KB">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-outline-secondary" type="button"><i class="fas fa-upload"></i> Browse</button>
                                </span>
                            </div>
                            @error('product_service_icon')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <div class="display-input-image">
                                <img src="{{ Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}" alt="Product Thumbnail" />
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-2 d-flex align-items-center">
                    <button type="button" class="btn btn-success btn-sm" id="addServiceFields">
                        <i class="ti-plus"></i>
                    </button>
                </div>

                <input type="hidden" class="noImgPath" value="{{ Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}">
                <input type="hidden" class="totalServiceFields" value="1">

            </div>
        </div>
    </div>
</div>