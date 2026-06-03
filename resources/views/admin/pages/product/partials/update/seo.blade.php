<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="p-sm-3">
            <div class="row">
                <div class="form-group col-sm-6 @error('meta_title') error @enderror">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->getTranslation('meta_title')) }}" class="form-control"
                        placeholder="Meta Title">
                    @error('meta_title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                @php
                    $stringKeywords = $product->getTranslation('meta_keywords');
                    $keywords = $stringKeywords ? json_decode($stringKeywords) : [];
                    $metaKey = implode(",", $keywords);
                @endphp

                <div class="col-sm-6 form-group @error('meta_keywords') error @enderror">
                    <label class="col-form-label">{{ __('Meta Keywords') }}</label>
                    <input type="text" name="meta_keywords[]" value="{{ old('meta_keywords[]', $metaKey) }}" class="form-control tokenfield" id="metaKeywords" placeholder="Write & Hit Enter" style="width: 100%" />
                    @error('meta_keywords')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group @error('meta_description') error @enderror">
                <label for="meta_description">Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="4" placeholder="Meta Description">{{ old('meta_description', $product->getTranslation('meta_description')) }}</textarea>
                @error('meta_description')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group @error('meta_image') error @enderror">
                <div class="align-items-center file-upload-section row">
                    <div class="col-md-8">
                        <label class="col-form-label">{{ __('Meta Image') }}</label>
                        <input name="meta_image" type="file" class="form-control d-none"
                            allowed="webp,png,gif,jpeg,jpg">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled=""
                                readonly placeholder="Size: 750X750 and max 512KB">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-outline-secondary"
                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                            </span>
                        </div>
                        @error('meta_image')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="display-input-image col-md-4">
                        <img src="{{ $product->getMetaImage() }}" alt="Meta Image" />
                        <button type="button" class="btn btn-sm btn-outline-danger file-upload-remove ml-3" title="Remove"> x </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
