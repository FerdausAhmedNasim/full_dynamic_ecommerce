<div class="card shadow-sm">
    <div class="card-body py-sm-4">
        <form method="post" action="{{ route('seller.member.prescription.store', $member->id) }}"
            enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-sm-4 col-12 notes">
                    <div class="form-group row @error('category') error @enderror p-1">
                        <select class="form-control" name="category" id="category" required>
                            <option value="" class="selected highlighted">Select Note Type</option>
                            @foreach($prescription_types as $value)
                            <option value="{{ $value }}" {{(old("category") == $value) ? "selected" : ""}}>
                                {{ ucwords($value) }}</option>
                            @endforeach
                        </select>

                        @error('category')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-4 col-12 notes">
                    <div class="form-group row @error('contact_type') error @enderror p-1">
                        <select class="form-control" name="contact_type" required>
                            <option value="" class="selected highlighted">Contact Type(Required)</option>
                            @foreach(\App\Library\Enum::getContactType() as $index => $value)
                            <option value="{{ $index }}" {{(old("contact_type") == $index) ? "selected" : ""}}>
                                {{ ucwords($value) }}</option>
                            @endforeach
                        </select>
                        @error('contact_type')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="col-md-4 notes">
                    <div class="form-group row @error('service_id') error @enderror p-1">
                        <select class="form-control" name="service_id" id="service_id" required>
                            <option value="" class="selected highlighted">Select Service</option>
                            @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                {{(old("service_id") == $service->id) ? "selected" : ""}}>
                                {{ ucwords($service->name) }}</option>
                            @endforeach
                        </select>

                        @error('service_id')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12 notes">
                    <div class="form-group row @error('title') error @enderror p-1">
                        <input type="text" name="title" class="form-control" placeholder="Title (Required)"
                            value="{{ old('title') }}" required>
                        @error('title')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 notes">
                    <div class="form-group row @error('description') error @enderror p-1">
                        <textarea type="text" name="description" class="form-control" id="summernote"
                            value="{{ old('description') }}" placeholder="Description" style="width: 80%;"></textarea>
                        @error('description')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div id="dynamic_field">
                <div class="row">
                    <div class="col-xl-4 col-sm-4 col-12 notes">
                        <div class="form-group row @error('name') error @enderror p-1">
                            <input type="text" name="name[]" id="name1" onkeyup="attachmentRequired(1)" class="form-control" value="{{ old('name[]') }}"
                                placeholder="File Name">
                            @error('name')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <div class="col-xl-6 col-sm-6 col-12 notes">
                        <div class="form-group @error('attachment') error @enderror">
                            <div class="file-upload-section d-flex d-inline-flex">
                                <input name="attachment[]"  id="attachment1" onchange="attachmentRequired(1)" type="file" class="form-control d-none" allowed="*">
                                <div class="input-group p-1">
                                    <input type="text" class="form-control file-upload-info" disabled="" readonly
                                        placeholder="Size: 200x200 and 500kB">
                                    <span>
                                        <button class="file-upload-browse btn btn-outline-secondary pb-3"
                                            type="button"><i class="fas fa-upload"></i></button>
                                    </span>
                                </div>
                                @error('attachment')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                                <div class="display-input-image display-input-image2 d-none">
                                    <img src="" alt="Preview Image" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 d-flex align-items-center notes">
                        <div class="form-group @error('user.avatar') error @enderror mr-1">
                            <button type="button" class="btn btn-info btn-sm" id="add">
                                <i class="ti-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="align-items: center">
                <div class="col-xl-5 col-md-5 col-sm-12 col-12 d-flex d-inline-flex p-1 notes" style="align-items: center">
                    <label class="col-form-label pr-2">{{ __('Make It Private') }}</label>
                    <div class="form-check form-check-success @error('is_private') error @enderror">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="is_private"
                                value="1" @checked(old('is_private'))>
                            <i class="input-helper"></i></label>
                        @error('is_private')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-12 col-12 d-flex d-inline-flex p-1 notes" style="align-items: center">
                    <label class="col-form-label pr-2">{{ __('Whanau Around') }}</label>
                    <div class="form-check form-check-success @error('is_whanau') error @enderror">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="is_whanau"
                                value="1" @checked(old('is_whanau'))>
                            <i class="input-helper"></i></label>
                        @error('is_whanau')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-xl-3 col-md-3 col-sm-12 col-12 d-flex d-inline-flex p-1 notes" style="flex-direction: row-reverse">
                    <button type="button" class='btn btn2-light-secondary more' data-bs-toggle="collapse" data-bs-target="#showMore">
                        More
                    </button>
                </div>

            </div>

            {{-- After Click More Button --}}
            {{-- <div id="moreDiv"> --}}
            <div id="showMore" class="collapse">
                <div class="row">
                    <div class="col-md-6 col-12 notes">
                        <div class="form-group row @error('contact_person') error @enderror p-1">
                            <input type="text" name="contact_person" class="form-control"
                                value="{{ old('contact_person') }}" placeholder="Contact Person">
                            @error('contact_person')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12 notes">
                        <div class="form-group row @error('date_time') error @enderror p-1">

                            <div class="input-group with-icon">
                                <input type="text" name="date_time" class="form-control datetimepicker"
                                    value="{{ old('date_time') }}" placeholder="{{ config('app.input_date_time_format') }}">
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>

                            @error('date_time')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12 d-flex d-inline-flex p-1" style="align-items: center">
                        <label class="col-form-label pr-2">{{ __('Group Session') }}</label>
                        <div class="form-check form-check-success @error('is_group_session') error @enderror">
                            <label class="form-check-label">

                                <input type="checkbox" class="form-check-input" name="is_group_session" id="is_group_session"
                                    value="1" @checked(old('is_group_session')) >
                                <i class="input-helper"></i></label>
                            @error('is_group_session')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12 @if(! old('is_group_session') ) d-none  @endif p-1 notes" id="contactPersonDiv">
                        <div class="form-group row @error('number_of_attendance') error @enderror">
                            <div class="col-sm-12 col-12">
                                <input type="number" name="number_of_attendance" id="number_of_attendance"
                                    class="form-control" value="{{ old('number_of_attendance') }}"
                                    placeholder="Number Of Attendees">
                                @error('number_of_attendance')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12 @if(! old('is_group_session') ) d-none  @endif p-1 notes mb-2" id="multiselectClient">
                        <select class="form-control select2" name="user_id[]" id="user_id" multiple data-placeholder="Select User">
                            @foreach($getAllMembers as $user)
                                <option value="{{ $user->id }}"
                                    {{(old("user_id") == $user->id) ? "selected" : ""}}>
                                    {{ $user->full_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('user_id')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
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

@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/member/prescription/create.js')
@endpush
