<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="p-sm-3">

            <div class="form-group row mt-2 @error('refundable') error @enderror">
                <label class="col-md-3 col-from-label">Refundable</label>
                <div class="col-md-9">
                    <label class="custom-switch">
                        <input type="checkbox" value="1" {{ old('refundable', $product?->refundable) == 1 ? 'checked' : '' }} name="refundable" class="custom-switch-input">
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
                        <input type="checkbox" value="1" {{ old('featured', $product?->featured) == 1 ? 'checked' : '' }} name="featured" class="custom-switch-input">
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
                        <input type="checkbox" value="1" {{ old('todays_deal', $product?->todays_deal) == 1 ? 'checked' : '' }} name="todays_deal" class="custom-switch-input">
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

            @if(count($product->productServices) > 0)
                @foreach($product->productServices as $key => $service)
                    <div class="row">
                        <div class="col-sm-4 form-group  @error('product_service_title') error @enderror">
                            @if($key == 0)<label class="col-form-label required">{{ __('Title') }}</label>@endif
                            <input type="text" class="form-control" name="product_service_title[]" maxlength="30" value="{{ $service->getTranslation('title') }}" placeholder="{{ __('Product Service Title') }}">
                            @error('product_service_title')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-4 form-group  @error('product_service_sub_title') error @enderror">
                            @if($key == 0)<label class="col-form-label required">{{ __('Sub Title') }}</label>@endif
                            <input type="text" class="form-control" name="product_service_sub_title[]" maxlength="30" value="{{ $service->getTranslation('sub_title') }}" placeholder="{{ __('Product Service Sub Title') }}">
                            @error('product_service_sub_title')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-2 form-group  @error('product_service_order') error @enderror">
                            @if($key == 0)<label class="col-form-label required">{{ __('Order') }}</label>@endif
                            <input type="number" class="form-control" name="product_service_order[]" min="1" max="3" value="{{ old('product_service_order[2]', $service->order) }}" placeholder="{{ __('Product Service Order') }}">
                            @error('product_service_order')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($key == 0)
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="button" class="btn btn-success btn-sm" id="addServiceFields">
                                <i class="ti-plus"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                @endforeach

                <input type="hidden" class="totalServiceFields" value="{{ count($product->productServices) }}">
            @else
                <div class="row">
                    <div class="col-sm-4 form-group  @error('product_service_title') error @enderror">
                        <label class="col-form-label required">{{ __('Title') }}</label>
                        <input type="text" class="form-control" name="product_service_title[]" maxlength="30" value="{{ old('product_service_title[]') }}" placeholder="{{ __('Product Service Title') }}">
                        @error('product_service_title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-sm-4 form-group  @error('product_service_sub_title') error @enderror">
                        <label class="col-form-label required">{{ __('Sub Title') }}</label>
                        <input type="text" class="form-control" name="product_service_sub_title[]" maxlength="30" value="{{ old('product_service_sub_title[]') }}" placeholder="{{ __('Product Service Sub Title') }}">
                        @error('product_service_sub_title')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-sm-2 form-group  @error('product_service_order') error @enderror">
                        <label class="col-form-label required">{{ __('Order') }}</label>
                        <input type="number" class="form-control" name="product_service_order[]" min="1" max="3" value="{{ old('product_service_order[]') }}" placeholder="{{ __('Product Service Order') }}">
                        @error('product_service_order')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="button" class="btn btn-success btn-sm" id="addServiceFields">
                            <i class="ti-plus"></i>
                        </button>
                    </div>
                </div>

                <input type="hidden" class="totalServiceFields" value="1">
            @endif

        </div>
    </div>
</div>
