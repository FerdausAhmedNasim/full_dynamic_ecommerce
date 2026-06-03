<div class="card shadow-sm mt-3">
    <div class="card-body">

        <div class="p-sm-3">
            
            @if(false)
            <div class="form-group @error('shipping_type') error @enderror">
                <label class="col-form-label required">{{ __('Shipping Fee Type') }}</label>
                <select class="form-control" name="shipping_type" id="shipping_type" required>
                    <option value="flat_rate" {{ old('shipping_type') == 'flat_rate' ? 'selected' : '' }}>Flat Rate</option>
                    <option value="free_shipping" {{ old('shipping_type') == 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                </select>
                @error('shipping_type')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="shippingFeeDiv form-group @error('shipping_fee') error @enderror 
                {{ old('shipping_type') == 'free_shipping' ? 'd-none' : '' }}">
                <label class="col-form-label required">{{ __('Shipping Fee') }}</label>
                <input type="number" min="0" step="any" class="form-control" name="shipping_fee"
                    value="{{ old('shipping_fee') }}" id="shipping_fee" placeholder="Enter Shipping Fee" />
                @error('shipping_fee') 
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group row mt-2 @error('shipping_fee_depend_on_quantity') error @enderror">
                <label class="col-md-3 col-from-label">Is Depend On Quantity</label>
                <div class="col-md-9">
                    <label class="custom-switch">
                        <input type="checkbox" value="1" {{ old('shipping_fee_depend_on_quantity') == 1 ? 'checked' : '' }} name="shipping_fee_depend_on_quantity" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Shipping fee depend on quantity</span>
                    </label>
                    @error('shipping_fee_depend_on_quantity')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group row mt-2 @error('cash_on_delivery') error @enderror">
                <label class="col-md-3 col-from-label">Cash On Delivery</label>
                <div class="col-md-9">
                    <label class="custom-switch">
                        <input type="checkbox" value="1" {{ old('cash_on_delivery') == 1 ? 'checked' : '' }} name="cash_on_delivery" class="custom-switch-input">
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Collect cash after delivery</span>
                    </label>
                    @error('cash_on_delivery')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @endif

            <div class="form-group @error('estimated_shipping_days') error @enderror">
                <label class="col-form-label required">{{ __('Estimated Shipping Days') }}</label>
                <input type="text" class="form-control" name="estimated_shipping_days"
                    value="{{ old('estimated_shipping_days') }}" id="estimated_shipping_days"
                    placeholder="Enter Estimate Shipping Days" required />
                @error('estimated_shipping_days')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
        </div>

    </div>
</div>
