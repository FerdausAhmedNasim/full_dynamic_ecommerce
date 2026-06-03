<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="p-sm-3">

            <div class="form-group @error('product_thumbnail') error @enderror">
                <div class="align-items-center file-upload-section row">
                    <div class="col-md-6">
                        <label class="col-form-label required">{{ __('Thumbnail (750X750)') }}</label>
                        <input name="product_thumbnail" type="file" class="form-control d-none"
                            allowed="webp,png,gif,jpeg,jpg">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled="" readonly
                                placeholder="Size: 750X750 and max 512KB">
                            <span class="input-group-append @error('product_thumbnail') input-group-error @enderror">
                                <button class="file-upload-browse btn btn-outline-secondary" type="button"><i
                                        class="fas fa-upload"></i> Browse</button>
                            </span>
                        </div>
                        @error('product_thumbnail')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="display-input-image col-md-6 {{ isset($product->thumbnail) ? '' : 'd-none' }}">
                        <img src="{{ $product->getThumbnailImage() }}" alt="Product Thumbnail" />
                        <button type="button" class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                            title="Remove">x</button>
                    </div>
                </div>
            </div>

            <div class="form-group  @error('images') error @enderror">
                <label class="col-form-label">{{ __('Gallery Image(750X750)') }}</label>

                <div class="dropMeUpdateImage">

                </div>

                @error('images')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>
</div>
