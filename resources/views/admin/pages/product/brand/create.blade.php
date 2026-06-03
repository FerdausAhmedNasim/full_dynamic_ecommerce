<div class="col-md-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Add New Brand</h4>
            <hr>
            <form method="post" action="{{ route('admin.brand.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-2">

                            <div class="form-group @error('name') error @enderror">
                                <label class="required">{{ __('Name') }}</label>
                                <div class="">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="{{ __('Name') }}" required>
                                    @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('thumbnail') error @enderror">
                                <label class="required" for="description">{{ __('Thumbnail') }}</label>
                                <div class="">
                                    <div class="file-upload-section">
                                        <input name="thumbnail" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg" required>
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('thumbnail') error @enderror"
                                                disabled="" readonly placeholder="Size:145x120, Max:1024kB">
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
                                        @error('thumbnail')
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
