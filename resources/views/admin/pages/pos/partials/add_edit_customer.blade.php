<!-- Modal -->
<div class="modal fade" id="customer-add-edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" action="" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fa-solid fa-user-plus text-primary"></i>
                        {{ __('Add Customer') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="p-sm-3">
    
                                <div class="form-group row @error('full_name') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Full Name') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="full_name"
                                            value="{{ old('full_name') }}" placeholder="{{ __('Full Name') }}"
                                            required>
                                        @error('full_name')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="form-group row @error('email') error @enderror">
                                    <label class="col-sm-3 col-form-label">{{ __('Email') }}</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email') }}" placeholder="{{ __('example@example.com') }}">
                                        @error('email')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="form-group row @error('gender') error @enderror">
                                    <label class="col-sm-3 col-form-label" for="name">{{ __('Gender')
                                        }}</label>
                                    <div class="col-sm-9">
                                        <select class="select form-control" name="gender" id="gender"
                                            style="width: 100%;">
                                            <option value="" selected disabled>Select One</option>
                                            @foreach($genders = [] as $gender)
                                            <option value="{{ $gender }}" {{ old('gender')==$gender
                                                ? "selected" : "" }} data-params="{{ $gender }}">
                                                {{ $gender }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
    
                                <div class="form-group row @error('location') error @enderror">
                                    <label class="col-sm-3 col-form-label">{{ __('Location') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="location"
                                            value="{{ old('location') }}" placeholder="{{ __('Location') }}"/>
                                        @error('location')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                            </div>
    
                                
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('Description') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="description"
                                        value="{{ old('description') }}" placeholder="{{ __('Description') }}"
                                        >{{ old('description') }}</textarea>
                                </div>
                            </div>
    
                            <div class="form-group row @error('phone') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Mobile No') }}</label>
                                <div class="col-sm-9">
                                    <div class="input-group mb-4">
                                        {{-- <div class="input-group-prepend">
                                        <select name="country_code" class="input-group-text text-secondary" required>
                                            @foreach($countries = [] as $key => $country)
                                                <option value="{{ old('country_code', $country['code']) }}" {{($key == "NZ") ? "selected" : ""}}>{{$key}} {{ $country['code']}}</option>
                                            @endforeach
                                        </select>
                                        </div> --}}
                                        <input type="number" name="phone" value="{{old('phone')}}" class="form-control" placeholder="{{ __('013 355 666') }}">
                                    </div>
                                    @error('phone')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-group row @error('dob') error @enderror">
                                <label class="col-sm-3 col-form-label" for="name">{{ __('Date Of
                                    Birth') }}</label>
                                <div class="col-sm-9">
    
                                    <div class="input-group with-icon">
                                        <input type="text" name="dob" id="dob"
                                            class="form-control datepicker-max-today"
                                            value="{{ old('dob') }}" placeholder="{{ settings('date_format') }}">
                                        <i class="date-icon fa-solid fa-calendar-days"></i>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group row @error('avatar') error @enderror">
                                <label class="col-sm-3 col-form-label">Avatar</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="avatar" type="file" class="form-control d-none"
                                            allowed="png,gif,jpeg,jpg">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info"
                                                disabled="" readonly
                                                placeholder="Size: 200x200 and max 500kB">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i>
                                                    Browse</button>
                                            </span>
                                        </div>
                                        @error('avatar')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        <div class="display-input-image d-none">
                                            <img src="{{ Vite::asset(\App\Library\Enum::NO_IMAGE_PATH) }}"
                                                alt="Preview Image" />
                                            <button type="button"
                                                class="btn btn-sm btn-outline-danger file-upload-remove ml-3"
                                                title="Remove">x</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn2-light-secondary mr-3" data-dismiss="modal"><i
                            class="fas fa-times"></i> {{ __('Close') }}</button>
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>
            </div>
        </form>
    </div>
</div>