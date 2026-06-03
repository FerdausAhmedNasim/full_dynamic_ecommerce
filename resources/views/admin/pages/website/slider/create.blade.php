<div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Add New Slider</h4>
            <hr>
            <form method="post" action="{{ route('admin.website.slider.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-2">

                            <div class="form-group @error('order') error @enderror">
                                <label class="">{{ __('Order') }}
                                    <span class="fw-lighter text-smaller">(to show slider)</span>
                                </label>
                                <div class="">
                                    <input type="number" class="form-control" name="order" min="0"
                                        value="{{ old('order') }}"
                                        placeholder="{{ __('Ex: 1') }}">
                                    @error('order')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('link') error @enderror">
                                <label class="required">{{ __('Link') }}</label>
                                <div class="">
                                    <input type="text" class="form-control" name="link"
                                        value="{{ old('link') }}"
                                        placeholder="{{ __('Link') }}" required>
                                    @error('link')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('background') error @enderror">
                                <label class="required"
                                    for="description">{{ __('Background Image') }}</label>
                                <div class="">
                                    <div class="file-upload-section">
                                        <input name="background" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg,webp" required>
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('background') error @enderror"
                                                disabled="" readonly placeholder="Size:1920x800, Max:1024kB">
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
                                        @error('background')
                                            <p class="error-message text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
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