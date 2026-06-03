<table class="table table-bordered table-bordered product-variant-table">
    @if (isset($variants))
        <thead>
            <tr>
                <th scope="col">{{ __('Variant') }}</th>
                <th scope="col">{{ __('Price') }} <span class="text-danger">*</span></th>
                <th scope="col">{{ __('SKU') }} <span class="text-danger">*</span></th>
                <th scope="col">{{ __('Current Stock') }} <span class="text-danger">*</span></th>
                <th scope="col">{{ __('Image') }}</th>
                <th>{{ __('Action') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($variants_data as $key => $variant)
                @php
                    $variant_name = '';
                    $variant_ids = '';

                    foreach ($variant as $key => $item) {
                        if ($key > 0) {
                            $attribute_value = \App\Models\AttributeValue::find($item);
                            $variant_name .= '-' . str_replace(' ', '', $attribute_value->value);
                            $variant_ids .= '-' . str_replace(' ', '', $attribute_value->id);
                        } else {
                            if ($colors == 1) {
                                $color_all = \App\Models\Color::where('id', $item)->get();

                                foreach ($color_all as $color) {
                                    $color_name = $color->name;
                                    $color_id = $color->id;
                                    continue;
                                }

                                $variant_name .= $color_name;
                                $variant_ids .= $item;
                            } else {
                                $attribute_value = \App\Models\AttributeValues::find($item);
                                $variant_name .= str_replace(' ', '', $attribute_value->value);
                                $variant_ids .= str_replace(' ', '', $attribute_value->id);
                            }
                        }
                    }
                    $variant_stock = $product->productStocks->where('name', $variant_name)->first();

                    $skuGenerate = App\Library\Helper::sku(auth()->user()->last_name);
                @endphp

                @if (strlen($variant_name) > 0)
                    <tr>
                        <th scope="row" width="18%">
                            <label class="font-normal">{{ $variant_name }}</label>
                            <input type="hidden" lang="en" name="variant_name[]" value="{{ $variant_name }}" class="form-control">
                            <input type="hidden" lang="en" name="variant_ids[]" value="{{ $variant_ids }}" class="form-control">
                            <input type="hidden" name="stock_id[]" value="{{ $variant_stock ? $variant_stock->id : null }}" class="form-control">
                        </th>
                        <td width="16%">
                            <input type="number" lang="en" name="variant_price[]" 
                            value="{{ $product_price == $product->price ? ($variant_stock ? $variant_stock->unit_price : $product_price) : $product_price }}" min="0" step="any" class="form-control variant_price" placeholder="0">
                        </td>
                        <td width="16%">
                            <input type="text" name="variant_sku[]" value="{{ $variant_stock ? $variant_stock->sku : $skuGenerate }}" class="form-control">
                        </td>
                        <td width="16%">
                            <input type="number" lang="en" name="variant_stock[]" value="{{ $variant_stock ? $variant_stock->current_stock : '' }}" min="0" step="1" class="form-control variant_stock" placeholder="0">
                        </td>
                        <td width="29%">
                            <div class="align-items-center file-upload-section row">

                                @php
                                    $src = settings('logo') ? asset(settings('logo')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH);
                                    $placeholder = 'Size: 750X750 and max 512KB';

                                    if ($variant_stock != '') {
                                        $src = $variant_stock->getVariantImage();
                                        $placeholder = $variant_stock->getVariantImage();
                                    }
                                @endphp

                                <div class="col-md-9">
                                    <input name="variant_image[]" type="file" class="form-control d-none"
                                        allowed="webp,png,gif,jpeg,jpg">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            value="{{ $placeholder }}"
                                            readonly placeholder="Size: 750X750 and max 1024MB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary" type="button" style="padding: 0.875rem 0.7rem;">
                                                <i class="fa-solid fa-cloud-arrow-up"></i> 
                                            </button>
                                        </span>
                                    </div>
                                </div>
            
                                <div class="display-input-image col-md-3">
                                    <img class="variantImage" src="{{ $src }}" alt="Preview Image" />
                                    <div class="file-upload-remove image-remove">
                                        <span class="remove">
                                            <i class="fa-solid fa-xmark"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td width="5%">
                            <button type="button" class="btn btn-icon btn-sm btn-danger remove-menu-row" onclick="$(this).closest('tr').remove();">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    @endif
</table>

