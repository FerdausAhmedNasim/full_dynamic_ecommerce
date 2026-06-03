@extends('seller.layouts.master')

@section('title', __('Update Notes'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.member.show.note', $prescription->client_id )) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Notes')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm col-xl-10 col-md-12 col-sm-12 col-12">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.member.prescription.update', $prescription->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-group row @error('category') error @enderror p-sm-3">
                            <select class="form-control" name="category" id="category" required>
                                <option value="" class="selected highlighted">Select Note Type</option>
                                @foreach($prescription_types as $value)
                                <option value="{{ $value }}" {{(old("category", $prescription->category) == $value) ? "selected" : ""}}>
                                    {{ ucwords($value) }}</option>
                                @endforeach
                            </select>

                            @error('category')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-group row @error('contact_type') error @enderror p-sm-3">
                            <select class="form-control" name="contact_type" required>
                                <option value="" class="selected highlighted">Select Contact Type(Required)</option>
                                @foreach(\App\Library\Enum::getContactType() as $index => $value)
                                <option value="{{ $index }}"
                                    {{ (old("contact_type", $prescription->contact_type) == $index) ? "selected" : "" }}>
                                    {{ ucwords($value) }}</option>
                                @endforeach
                            </select>
                            @error('contact_type')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-group row @error('service_id') error @enderror p-sm-3">
                            <select class="form-control" name="service_id" id="service_id" required>
                                <option value="" class="selected highlighted">Select Service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}"
                                    {{ (old("service_id", $prescription->service_id) == $service->id) ? "selected" : "" }}>
                                    {{ ucwords($service->name) }}</option>
                                @endforeach
                            </select>

                            @error('service_id')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-6 col-12">
                        <div class="form-group row @error('title') error @enderror">
                            <div class="col-sm-12 col-12">
                                <input type="text" name="title" class="form-control"
                                value="{{ old('title', $prescription->title) }}" placeholder="Title (Required)" required>
                                @error('title')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group row @error('description') error @enderror">
                            <div class="col-sm-12 col-12">
                                <textarea type="text" name="description" class="form-control" id="summernote"
                                value="{{ old('description', $prescription->description) }}" placeholder="Description" required></textarea>
                                @error('description')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div id="dynamic_field" class="col-md-12 col-sm-12 col-12">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="form-group row @error('name') error @enderror">
                                    <div class="col-sm-12 col-12">
                                        <input type="text" name="name[]" id="name1" onkeyup="attachmentRequired(1)" class="form-control" value="{{ old('name[]') }}"
                                            placeholder="File Name">
                                        @error('name')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group row @error('attachment') error @enderror">
                                    <div class="col-sm-12 col-12">
                                        <div class="file-upload-section d-flex ">
                                            <input name="attachment[]"  id="attachment1" onchange="attachmentRequired(1)" type="file" class="form-control d-none" allowed="*">
                                            <div class="input-group">
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
                            </div>

                            <div class="col-md-2 col-sm-6 col-12">
                                <div class="form-group row @error('user.avatar') error @enderror pt-2">
                                    <div class="col-sm-12 col-12">
                                        <button type="button" class="btn btn-info btn-sm" id="add">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> --}}

                    <div class="col-md-4 col-sm-6 col-12 d-flex d-inline-flex" style="align-items: center;">
                        <label class="col-form-label pr-2">{{ __('Make It Private') }}</label>
                        <div class="form-check form-check-success @error('is_private') error @enderror">
                            <label class="form-check-label">
                                <input type="hidden" value="0" name="is_private">
                                <input type="checkbox" class="form-check-input" name="is_private"
                                    value="{{ old('is_private' == 1 ? 'checked' : '', 1) }}" {{ $prescription->is_private == 1 ? 'checked' : '' }}>
                                <i class="input-helper"></i></label>
                            @error('is_private')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12 d-flex d-inline-flex" style="align-items: center;">
                        <label class="col-form-label pr-2">{{ __('Whanau Around') }}</label>
                        <div class="form-check form-check-success @error('is_whanau') error @enderror">
                            <label class="form-check-label">
                                <input type="hidden" value="0" name="is_whanau">
                                <input type="checkbox" class="form-check-input" name="is_whanau"
                                    value="{{ old('is_whanau' == 1 ? 'checked' : '', 1) }}" {{ $prescription->is_whanau == 1 ? 'checked' : '' }}>
                                <i class="input-helper"></i></label>
                            @error('is_whanau')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12 d-flex d-inline-flex" style="align-items: center;">
                        <label class="col-form-label pr-2">{{ __('Group Session') }}</label>
                        <div class="form-check form-check-success @error('is_group_session') error @enderror">
                            <label class="form-check-label">
                                <input type="hidden" value="0" name="is_group_session">
                                <input type="checkbox" class="form-check-input" name="is_group_session"
                                    value="{{ old('is_group_session' == 1 ? 'checked' : '', 1) }}" {{ $prescription->is_group_session == 1 ? 'checked' : '' }}>
                                <i class="input-helper"></i></label>
                            @error('is_group_session')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-group row @error('contact_person') error @enderror">
                            <div class="col-sm-12 col-12">
                                <input type="text" name="contact_person" class="form-control"
                                value="{{ old('contact_person', $prescription->contact_person) }}" placeholder="Contact Person">
                                @error('contact_person')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    @if(false)
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-group row @error('date_time') error @enderror ">

                            <div class="input-group with-icon">
                                <input type="text" name="date_time" class="form-control datetimepicker"
                                    value="{{ old('date_time', getFormattedDateTime($prescription->date_time)) }}"
                                    placeholder="{{ config('app.input_date_time_format') }}">
                                <i class="date-icon fa-solid fa-calendar-days"></i>
                            </div>

                            @error('date_time')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @endif

                    <div class="col-md-4 col-sm-6 col-12 @if($prescription->is_group_session != 1) d-none @endif" id="contactPersonDiv">
                        <div class="form-group row @error('number_of_attendance') error @enderror d-flex justify-content-end">
                            <div class="col-sm-12 col-12">
                                <input type="number" name="number_of_attendance" id="number_of_attendance" class="form-control"
                                value="{{ old('number_of_attendance', $prescription->number_of_attendance) }}"
                                {{ $prescription->is_group_session == 1 ? 'required' : ''  }} placeholder="Number Of Attendees">
                                @error('number_of_attendance')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-12 @if(! old('is_group_session') )  @endif mb-4" id="multiselectClient">

                        {{-- @php
                            $notes_user = $prescription->users();
                            $user_id = $notes_user ? $notes_user->id : '';
                        @endphp --}}

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
@stop
@include('seller.assets.summernote-text-editor')
@include('seller.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/member/prescription/update.js')


<script>
    $(document).ready(function () {

        var users = <?php echo $prescription->getUsers() ?> ;

        var userArr = [];
        $.each(users, function (index, row) {
            userArr.push(row.id)
        });

        $('#user_id').val(userArr).trigger("change");

    });
</script>

@endpush
