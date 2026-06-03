<div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Add New Benefit</h4>
            <hr>
            <form method="post" action="{{ route('admin.website.benefit.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-2">

                            <div class="form-group @error('title') error @enderror">
                                <label class="required">{{ __('Title') }}</label>
                                <div class="">
                                    <input type="text" class="form-control" name="title"
                                        value="{{ old('title') }}"
                                        placeholder="{{ __('Title') }}" required>
                                    @error('title')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('sub_title') error @enderror">
                                <label class="required">{{ __('Subtitle') }}</label>
                                <div class="">
                                    <input type="text" class="form-control" name="sub_title"
                                        value="{{ old('sub_title') }}"
                                        placeholder="{{ __('Subtitle') }}" required>
                                    @error('sub_title')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('order') error @enderror">
                                <label class="">{{ __('Order') }}
                                    <span class="fw-lighter text-smaller">(to show benefit)</span>
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

                            <div class="form-group @error('image') error @enderror">
                                <label class="required"
                                    for="description">{{ __('Icon Image') }}
                                    <span class="fw-lighter text-smaller">(only svg)</span>
                                </label>
                                <div class="">
                                    <div class="file-upload-section">
                                        <input name="image" type="file" class="form-control hidden_file"
                                            allowed="svg" required>
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('image') error @enderror"
                                                disabled="" readonly placeholder="Max:1024kB, Type:svg">
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
                                        @error('image')
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