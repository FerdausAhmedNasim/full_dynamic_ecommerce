
<div class="card shadow-sm mt-3">
    <div class="card-body">
        <div class="p-sm-3">
            <div class="row">

                <div class="col-sm-12 form-group  @error('short_description') error @enderror">
                    <label class="col-form-label">{{ __('Short Description') }}</label>
                    <textarea type="text" rows="5" class="form-control" name="short_description" value="{{ old('short_description', $product->getTranslation('short_description')) }}" placeholder="{{ __('Short Description') }}"></textarea>
                    @error('short_description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-12 form-group  @error('description') error @enderror">
                    <label class="col-form-label">{{ __('Long Description') }}</label>
                    <textarea type="text" class="form-control" id="summernote" name="description" placeholder="{{ __('Long Description') }}">{{ old('description', $product->getTranslation('description')) }}</textarea>
                    @error('description')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-sm-12 form-group @error('description_image') error @enderror">
                    <div class="align-items-center file-upload-section row">
                        <div class="col-md-8">
                            <label class="col-form-label">{{ __('Description Image') }}</label>
                            <input name="description_image" type="file" class="form-control d-none"
                                allowed="webp,png,gif,jpeg,jpg">
                            <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled=""
                                    readonly placeholder="Size: 750X750 and max 512KB">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-outline-secondary"
                                        type="button"><i class="fas fa-upload"></i> Browse</button>
                                </span>
                            </div>
                            @error('description_image')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
    
                        <div class="display-input-image col-md-4">
                            <img src="{{ $product->getDescriptionImage() }}" alt="Description Image" />
                            <button type="button" class="btn btn-sm btn-outline-danger file-upload-remove ml-3" title="Remove"> x </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>