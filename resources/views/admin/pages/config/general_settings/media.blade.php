@extends('admin.pages.config.general_settings.layout.master')

@section('title', 'Media')

@section('settingsContent')

    <form method="post" action="{{ route('admin.config.general_settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="p-sm-3">

                    <div class="align-item-baseline form-group row @error('logo') error @enderror">
                        <label class="col-sm-2 col-form-label required">Logo</label>
                        <div class="col-md-4 d-flex">
                            <input type="number" name="width" class="form-control mr-2" min="0" placeholder="Width (px)">
                            <input type="number" name="height" class="form-control" min="0" placeholder="Height (px)">
                        </div>
                        <div class="col-sm-6">
                            <div class="align-item-baseline file-upload-section row">
                                <div class="col-md-7">
                                    <input name="logo" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg,webp">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            readonly placeholder="Size: 300x50 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i> Browse</button>
                                        </span>
                                    </div>
                                    @error('logo')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="display-input-image col-md-5">
                                    <img src="{{ settings('logo') ? asset(settings('logo')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                        alt="Preview Image" style="width:110px; height: auto;" />
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                        title="Remove">x</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="align-item-baseline form-group row @error('favicon') error @enderror">
                        <label class="col-sm-2 col-form-label required">Favicon</label>
                        <div class="col-sm-10">
                            <div class="align-item-baseline file-upload-section row">
                                <div class="col-md-9">
                                    <input name="favicon" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg,JPEG">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            readonly placeholder="Size: 32X32 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i> Browse</button>
                                        </span>
                                    </div>
                                    @error('favicon')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="display-input-image col-md-3">
                                    <img src="{{ settings('favicon') ? asset(settings('favicon')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                        alt="Preview Image" />
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                        title="Remove">x</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="align-item-baseline form-group row @error('og_image') error @enderror">
                        <label class="col-sm-2 col-form-label">OG Image</label>
                        <div class="col-sm-10">
                            <div class="align-item-baseline file-upload-section row">
                                <div class="col-md-9">
                                    <input name="og_image" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            readonly placeholder="Size: 200x200 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i> Browse</button>
                                        </span>
                                    </div>
                                    @error('og_image')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="display-input-image col-md-3">
                                    <img src="{{ settings('og_image') ? asset(settings('og_image')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                        alt="Preview Image" />
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                        title="Remove">x</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="align-item-baseline form-group row @error('login_logo') error @enderror">
                        <label class="col-sm-2 col-form-label">Login Page Logo</label>
                        <div class="col-sm-10">
                            <div class="align-item-baseline file-upload-section row">
                                <div class="col-md-9">
                                    <input name="login_logo" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg,webp">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            readonly placeholder="Size: 200x200 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i> Browse</button>
                                        </span>
                                    </div>
                                    @error('login_logo')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="display-input-image col-md-3">
                                    <img src="{{ settings('login_logo') ? asset(settings('login_logo')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                        alt="Preview Image" />
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                        title="Remove">x</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="align-item-baseline form-group row @error('login_bg_image') error @enderror">
                        <label class="col-sm-3 col-form-label">Login Page BG Image</label>
                        <div class="col-sm-9">
                            <div class="align-item-baseline file-upload-section row">
                                <div class="col-md-9">
                                    <input name="login_bg_image" type="file" class="form-control d-none"
                                        allowed="png,gif,jpeg,jpg">
                                    <div class="input-group col-xs-12">
                                        <input type="text" class="form-control file-upload-info" disabled=""
                                            readonly placeholder="Size: 200x200 and max 500kB">
                                        <span class="input-group-append">
                                            <button class="file-upload-browse btn btn-outline-secondary"
                                                type="button"><i class="fas fa-upload"></i> Browse</button>
                                        </span>
                                    </div>
                                    @error('login_bg_image')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="display-input-image col-md-3">
                                    <img src="{{ settings('login_bg_image') ? asset(settings('login_bg_image')) : Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                        alt="Preview Image" />
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                        title="Remove">x</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>

        </div>

        @if(\App\Library\Helper::hasAuthRolePermission('general_settings_update'))
        <div class="row mt-2">
            <div class="modal-footer justify-content-center col-md-12">
                {!! \App\Library\Html::btnReset() !!}
                {!! \App\Library\Html::btnSubmit() !!}
            </div>
        </div>
        @endif
        
    </form>

@endsection
