<div class="col-md-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Add New Category</h4>
            <hr>
            <form method="post" action="{{ route('admin.category.store') }}" enctype="multipart/form-data">
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

                            <div class="form-group @error('parent_id') error @enderror">
                                <label class="">{{ __('Root Category') }}</label>
                                <div class="">

                                    <select class="form-control select2" name="parent_id">
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($categories as $key => $category)
                                        <option value="{{ $category->id }}"
                                            {{ old("parent_id") == $category->id ? "selected" : ""}}>
                                            {{ $category->getTranslation('title') }}
                                        </option>

                                        @foreach($category->childrenCategories as $key => $subCategory)
                                            @if ($subCategory->categories)
                                            <option class="text-capitalize" value="{{ $subCategory->id }}"
                                                {{ old("parent_id") == $subCategory->id ? "selected" : ""}}>
                                                &nbsp;-{{ $subCategory->getTranslation('title') }}
                                            </option>
                                            @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('order') error @enderror">
                                <label class="">{{ __('Order') }}
                                    <span class="fw-lighter text-smaller">(to show Menu sidebar)</span>
                                </label>
                                <div class="">
                                    <input type="number" class="form-control" name="order" min="0" value="{{ old('order') }}"
                                        placeholder="{{ __('Ex: 1') }}">
                                    @error('order')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group @error('thumbnail') error @enderror">
                                <label class="" for="description">{{ __('Thumbnail') }}</label>
                                <div class="">
                                    <div class="file-upload-section">
                                        <input name="thumbnail" type="file" class="form-control hidden_file"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('thumbnail') error @enderror"
                                                disabled="" readonly placeholder="Size:140x160, Max:1024kB">
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

                            <div class="form-group @error('icon') error @enderror">
                                <label class="" for="description">{{ __('Icon') }}
                                <span class="fw-lighter text-smaller">(only SVG)</span>
                                </label>
                                <div class="">
                                    <div class="file-upload-section">
                                        <input name="icon" type="file" class="form-control hidden_file"
                                            allowed="svg">
                                        <div class="input-group col-xs-12">
                                            <input type="text"
                                                class="form-control file-upload-info @error('icon') error @enderror"
                                                disabled="" readonly placeholder="Size: 130x130 and max 1024kB">
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
                                        @error('icon')
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
