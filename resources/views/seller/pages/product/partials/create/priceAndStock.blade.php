@php
    use App\Library\Enum;
    use App\Library\Helper;
@endphp

<div class="card shadow-sm mt-3">
    <div class="card-body">

        <div class="p-sm-3">

            <div class="row">
                <div class="col-sm-6">
                    <h4>Product Price & Discount</h4>
                </div>
                <div class="col-sm-6 text-right @error('has_discount') error @enderror">
                    <label class="custom-switch" id="hasDiscountSwitchBtn">
                        <input type="checkbox" name="has_discount" class="custom-switch-input has_discount"
                            value="1" {{ old('has_discount') == 1 ? 'checked' : '' }}>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Has Discount</span>
                    </label>
                    @error('has_discount')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <hr/>

            <div class="row mb-4">
                <div class="col-sm-6 form-group  @error('unit_price') error @enderror">
                    <label class="col-form-label required">{{ __('Unit Price') }}</label>
                    <input type="number" min="0" step="any" class="form-control" name="unit_price"
                        value="{{ old('unit_price') }}" placeholder="{{ __('0.00') }}" required>
                    @error('unit_price')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-6 form-group  @error('discount_type') error @enderror {{ old('has_discount') == 1 ? '' : 'd-none' }}" id="discountTypeDiv">
                    <label class="col-form-label required">{{ __('Discount Type') }}</label>
                    <select class="form-control discountType" name="discount_type" id="discount_type">
                        <option value="" class="selected highlighted">Select One</option>
                        @foreach (Enum::getDiscountType() as $index => $value)
                            <option class="text-capitalize" value="{{ $index }}"
                                {{ old('discount_type') == $index ? 'selected' : '' }}>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('discount_type')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6 form-group  @error('discount') error @enderror {{ old('has_discount') == 1 ? '' : 'd-none' }}" id="discountDiv">
                    <label class="col-form-label required">{{ __('Discount') }}</label>
                    <input type="number" min="0" step="any" class="form-control specialDiscount" name="discount"
                        value="{{ old('discount') }}" placeholder="{{ __('0.00') }}">
                    @error('discount')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6 form-group  @error('discount_period') error @enderror {{ old('has_discount') == 1 ? '' : 'd-none' }}" id="discountPeriodDiv">
                    <label class="col-form-label required">{{ __('Discount Period') }}</label>

                    <input type="hidden" name="discount_start" id="fromDate" value="">
                    <input type="hidden" name="discount_end" id="toDate" value="">

                    <div class="input-group with-icon">
                        <input type="text" name="discount_period" class="form-control discountPeriod" id="datetimerangepicker" value="{{ old('discount_period') }}" style="border-radius: 4px; background: #fff; color: #000;"
                        placeholder="{{ inputDateTimeFormat() }} - {{ inputDateTimeFormat() }}" />
                        <i class="date-icon fa-solid fa-calendar-days"></i>
                    </div>
                    @error('discount_period')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="p-sm-3">

            <div class="row">
                <div class="col-sm-6">
                    <h4>Product Stock</h4>
                </div>
                <div class="col-sm-6 text-right @error('has_variant') error @enderror">
                    <label class="custom-switch" id="hasVariantSwitchBtn">
                        <input type="checkbox" name="has_variant" class="custom-switch-input has_variant"
                            value="1" {{ old('has_variant') == 1 ? 'checked' : '' }}>
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">Has Variant</span>
                    </label>
                    @error('has_variant')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <hr/>

            <div class="row">
                <div class="col-sm-6 form-group  @error('low_stock_to_notify') error @enderror">
                    <label class="col-form-label">{{ __('Minimum Stock Warning') }}</label>
                    <input type="number" min="0" class="form-control" name="low_stock_to_notify"
                        value="{{ old('low_stock_to_notify') }}" placeholder="{{ __('Enter Minimum stock amount to notify.') }}">
                    @error('low_stock_to_notify')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6 form-group  @error('stock_visibility') error @enderror">
                    <label class="col-form-label required">{{ __('Stock Visibility') }}</label>
                    <select class="form-control" name="stock_visibility" id="stock_visibility" required>
                        @foreach (Enum::getProductVisibilityStatus() as $index => $value)
                            <option class="text-capitalize" value="{{ $index }}"
                                {{ old('stock_visibility') == $index ? 'selected' : '' }}>
                                {{ $value }}</option>
                        @endforeach
                    </select>
                    @error('stock_visibility')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Start Without Variant --}}
            <div class="row {{ old('has_variant') == 1 ? 'd-none' : '' }}" id="withoutVariant" >
                <div class="col-sm-6 form-group  @error('sku') error @enderror">
                    <label class="col-form-label required">{{ __('SKU') }}</label>
                    <input type="text" class="form-control" name="sku" id="sku" 
                        value="{{ old('sku') }}" placeholder="{{ __('Enter Product SKU') }}">
                    @error('sku')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="col-sm-6 form-group  @error('current_stock') error @enderror">
                    <label class="col-form-label required">{{ __('Current Stock') }}</label>
                    <input type="number" min="1" step="any" class="form-control" name="current_stock" id="current_stock"
                        value="{{ old('current_stock') }}" placeholder="{{ __('Enter Current Available Quantity') }}">
                    @error('current_stock')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            {{-- End Without Variant --}}
            </div>

            {{-- Start Variant --}}
            <div class="{{ old('has_variant') == 1 ? '' : 'd-none' }}" id="withVariant">

                <div class="form-group @error('colors') error @enderror">
                    <label class="col-form-label required">{{ __('Colors') }}</label>

                    <div class="form-group d-flex" id="colorsContainer">

                        @foreach($colors as $color)

                            <div class="form-check mr-2 colorsFormCheck">
                                <label class="colorinput-label" data-toggle="tooltip" title="{{ $color->name }}" data-original-title="{{ $color->name }}">
                                    <input name="colors[]" type="checkbox" value="{{ $color->id }}" id="colors"
                                    data-url="{{ route('seller.product.get-attribute-values') }}"
                                    class="colorinput-input attribute-sets colors-input" {{ old('colors') == $color->id ? checked : '' }}>
                                    <span class="colorinput-color" style="background-color: {{ $color->color_code }}"></span>
                                </label>
                            </div>

                        @endforeach

                    </div>

                    @error('colors')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group row d-none @error('attribute_sets') error @enderror" id="attributeSetsContainer">
                    <div class="col-sm-3">
                        <input type="text" class="form-control" value="{{ __('Attribute Sets') }}" disabled>
                    </div>
                    <div class="col-sm-9">
                        <select class="form-control select2 select2bs4 attribute-sets attributes-input" name="attribute_sets[]" id="attributeSets" multiple
                            data-url="{{ route('seller.product.get-attribute-values') }}">
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute->id }}" {{ old('attribute_sets') ? (in_array($attribute->id , old('attribute_sets')) ? 'selected' : '') : '' }}>{{ $attribute->name }}</option>
                            @endforeach
                        </select>
                        <span style="color: #3abaf4; font-size: 0.875rem;">N.B: Select Attribute sets of this product to add attribute values</span>
                    </div>
                    @error('attribute_sets')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="attribute-values d-none">
                    @php
                        $selected_attributes = old('attribute_sets') ? old('attribute_sets') : '';
                        $selected_attributes = $attributes->whereIn('id', $selected_attributes);
                    @endphp

                    @foreach($selected_attributes as $attribute)
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <input type="text" class="form-control" value="{{ $attribute->name }}" disabled>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control select2 select2bs4 variant attributes-value" name="attribute_values_{{$attribute->id}}[]" multiple>
                                    @foreach($attribute->load('attributeValues')->attributeValues as $value)
                                        <option value="{{ $value->id }}" {{  old('attribute_values_'.$attribute->id) ? (in_array($value->id, old('attribute_values_'.$attribute->id)) ? 'selected' : '') : '' }}>
                                            {{ $value->value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Start Variant Table --}}
                <div class="form-group row variant-table d-none">
                    @if(session()->has('attributes'))
                        @include('seller.pages.product.partials.session-sku')
                    @endif
                </div>
                {{-- End Variant Table --}}

            </div>
            {{-- End Variant --}}

        </div>

    </div>
</div>
