@extends('seller.layouts.master')

@section('title', __('Update Hauora Plan'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.member.hauora_plan.show', $hauoraPlan->id)) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Hauora Plan')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" id="hauora_plan-form"
                action="{{ route('seller.member.hauora_plan.update', $hauoraPlan->id) }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
                @endforeach
                @endif
                <div class="card shadow-sm col-xl-12 col-md-12 col-sm-12 col-12 mt-3"
                    style="box-shadow: 0px 2px 5px #005C2D!important;">
                    <div class="card-body py-sm-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="p-sm-3">
                                    <div class="form-group row @error('name') error @enderror">
                                        <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $hauoraPlan->name) }}"
                                                placeholder="{{ __('Name') }}" required>
                                            @error('name')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label required">{{ __('Plan Type') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="plan_type" id="plan_type" required>
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach(\App\Library\Enum::getHauoraPlanType() as $key => $planType)
                                                <option value="{{ $key }}" {{(old("plan_type", $hauoraPlan->plan_type)
                                                    == $key) ? "selected" : ""}}>
                                                    {{ ucwords($planType) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label required">{{ __('Services') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="service_ids[]" id="service" multiple
                                                required>
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($services as $service)
                                                <option value="{{ $service->id }}" @foreach ($hauoraPlan->services as $item)
                                                    {{ $item->id == $service->id ? "selected" : ""}}
                                                    @endforeach
                                                    >
                                                    {{ ucwords($service->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-sm-3">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label required">{{ __('Employee') }}</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" name="member_ids[]" id="employee" required>
                                                <option value="" class="selected highlighted">Select One</option>
                                                @foreach($employees as $employee)
                                                <option value="{{ $employee->employee->id }}" @foreach ($hauoraPlan->employees as $item)
                                                    {{ $item->id == $employee->employee->id ? "selected" : ""}}
                                                    @endforeach
                                                    >
                                                    {{ ucwords($employee?->full_name) }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">{{ __('Follow Up Date') }}</label>
                                        <div class="col-sm-9">

                                            <div class="input-group with-icon">
                                                <input type="text" class="form-control datetimepicker-min-today" name="follow_up_date"
                                                    value="{{ old('follow_up_date', getFormattedDateTime($hauoraPlan->follow_up_date)) }}"
                                                    placeholder="{{ config('app.input_date_time_format') }}">
                                                <i class="date-icon fa-solid fa-calendar-days"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm col-xl-12 col-md-12 col-sm-12 col-12 mt-3"
                    style="box-shadow: 0px 2px 5px #005C2D!important;">
                    <div class="accordion accordion-solid-header mt-2" id="accordion-1" role="tablist">
                        <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                            <div class="card-header" role="tab" id="heading-1">
                                <h6 class="mb-0">
                                    <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                                        href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
                                        <span class="float-left font-weight-bold">
                                            <i class="ti-calendar mr-1"></i>
                                            Taha Tinana - Physical Growth & Development
                                        </span>
                                        <span class="select-container d-flex align-items-center">
                                            <span class="text-nowrap px-2">Rating Scale</span>
                                            <select class="form-control select-box" id="ratingSelect1"
                                                name="details[ph_rating]">
                                                <option value="" selected disabled>1 - 5</option>
                                                <option value="1" {{(old("details[ph_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->ph_rating)==1) ? "selected" : "" }}>1
                                                </option>
                                                <option value="2" {{(old("details[ph_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->ph_rating)==2) ? "selected" : "" }}>2
                                                </option>
                                                <option value="3" {{(old("details[ph_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->ph_rating)==3) ? "selected" : "" }}>3
                                                </option>
                                                <option value="4" {{(old("details[ph_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->ph_rating)==4) ? "selected" : "" }}>4
                                                </option>
                                                <option value="5" {{(old("details[ph_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->ph_rating)==5) ? "selected" : "" }}>5
                                                </option>
                                            </select>
                                        </span>
                                    </a>
                                </h6>
                            </div>

                            <div id="collapse-1" class="collapse show" role="tabpanel" aria-labelledby="heading-1"
                                data-parent="#accordion-1">
                                <div class="card-body p-3">
                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-2">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Strengths - What is already in place to
                                                    support Taha Tinana</p>
                                            </div>
                                            <textarea name="details[ph_strengths]" class="form-control"
                                                rows="6">{{ old('details[ph_strengths]', $hauoraPlan->hauoraPlanDetails?->ph_strengths) }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Needs - What needs to be put in place to
                                                    support Taha Tinana</p>
                                            </div>
                                            <textarea name="details[ph_needs]" class="form-control"
                                                rows="6">{{ old('details[ph_needs]', $hauoraPlan->hauoraPlanDetails?->ph_needs) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6 ">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Client Goals - As identified by the client
                                                </p>
                                            </div>
                                            <textarea name="details[ph_goals]" class="form-control"
                                                rows="6">{{ old('details[ph_goals]', $hauoraPlan->hauoraPlanDetails?->ph_goals) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Plan - How will the goals be achieved and
                                                    measure</p>
                                            </div>
                                            <textarea name="details[ph_plan]" class="form-control"
                                                rows="6">{{ old('details[ph_plan]', $hauoraPlan->hauoraPlanDetails?->ph_plan) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion accordion-solid-header mt-2" id="accordion-2" role="tablist">
                        <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                            <div class="card-header" role="tab" id="heading-2">
                                <h6 class="mb-0">
                                    <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                                        href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                                        <span class="float-left font-weight-bold">
                                            <i class="ti-calendar mr-1"></i>
                                            Taha Hinengaro - Mental Health - Capacity to think and feel (thoughts,
                                            feelings, emotions)
                                        </span>
                                        <span class="select-container d-flex align-items-center">
                                            <span class="text-nowrap px-2">Rating Scale</span>
                                            <select class="form-control select-box" id="ratingSelect2"
                                                name="details[mh_rating]">
                                                <option value="" selected disabled>1 - 5</option>
                                                <option value="1" {{(old("details[mh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->mh_rating)==1) ? "selected" : "" }}>1
                                                </option>
                                                <option value="2" {{(old("details[mh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->mh_rating)==2) ? "selected" : "" }}>2
                                                </option>
                                                <option value="3" {{(old("details[mh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->mh_rating)==3) ? "selected" : "" }}>3
                                                </option>
                                                <option value="4" {{(old("details[mh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->mh_rating)==4) ? "selected" : "" }}>4
                                                </option>
                                                <option value="5" {{(old("details[mh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->mh_rating)==5) ? "selected" : "" }}>5
                                                </option>
                                            </select>
                                        </span>
                                    </a>
                                </h6>
                            </div>

                            <div id="collapse-2" class="collapse" role="tabpanel" aria-labelledby="heading-2"
                                data-parent="#accordion-2">
                                <div class="card-body p-3">
                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-2">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Strengths - What is already in place to
                                                    support Taha Hinengaro</p>
                                            </div>
                                            <textarea name="details[mh_strengths]" class="form-control"
                                                rows="6">{{ old('details[mh_strengths]', $hauoraPlan->hauoraPlanDetails?->mh_strengths) }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Needs - What needs to be put in place to
                                                    support Taha Hinengaro</p>
                                            </div>
                                            <textarea name="details[mh_needs]" class="form-control"
                                                rows="6">{{ old('details[mh_needs]', $hauoraPlan->hauoraPlanDetails?->mh_needs) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6 ">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Client Goals - As identified by the client
                                                </p>
                                            </div>
                                            <textarea name="details[mh_goals]" class="form-control"
                                                rows="6">{{ old('details[mh_goals]', $hauoraPlan->hauoraPlanDetails?->mh_goals) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Plan - How will the goals be achieved and
                                                    measure</p>
                                            </div>
                                            <textarea name="details[mh_plan]" class="form-control"
                                                rows="6">{{ old('details[mh_plan]', $hauoraPlan->hauoraPlanDetails?->mh_plan) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion accordion-solid-header mt-2" id="accordion-3" role="tablist">
                        <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                            <div class="card-header" role="tab" id="heading-3">
                                <h6 class="mb-0">
                                    <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                                        href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                                        <span class="float-left font-weight-bold">
                                            <i class="ti-calendar mr-1"></i>
                                            Taha Wairua - Spiritual Health - Faith & wider communication. Life force
                                        </span>
                                        <span class="select-container d-flex align-items-center">
                                            <span class="text-nowrap px-2">Rating Scale</span>
                                            <select class="form-control select-box" id="ratingSelect3"
                                                name="details[sh_rating]">
                                                <option value="" selected disabled>1 - 5</option>
                                                <option value="1" {{(old("details[sh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->sh_rating)==1) ? "selected" : "" }}>1
                                                </option>
                                                <option value="2" {{(old("details[sh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->sh_rating)==2) ? "selected" : "" }}>2
                                                </option>
                                                <option value="3" {{(old("details[sh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->sh_rating)==3) ? "selected" : "" }}>3
                                                </option>
                                                <option value="4" {{(old("details[sh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->sh_rating)==4) ? "selected" : "" }}>4
                                                </option>
                                                <option value="5" {{(old("details[sh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->sh_rating)==5) ? "selected" : "" }}>5
                                                </option>
                                            </select>
                                        </span>
                                    </a>
                                </h6>
                            </div>

                            <div id="collapse-3" class="collapse" role="tabpanel" aria-labelledby="heading-3"
                                data-parent="#accordion-3">
                                <div class="card-body p-3">
                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-2">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Strengths - What is already in place to
                                                    support Taha Wairua</p>
                                            </div>
                                            <textarea name="details[sh_strengths]" class="form-control"
                                                rows="6">{{ old('details[sh_strengths]', $hauoraPlan->hauoraPlanDetails?->sh_strengths) }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Needs - What needs to be put in place to
                                                    support Taha Wairua</p>
                                            </div>
                                            <textarea name="details[sh_needs]" class="form-control"
                                                rows="6">{{ old('details[sh_needs]', $hauoraPlan->hauoraPlanDetails?->sh_needs) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6 ">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Client Goals - As identified by the client
                                                </p>
                                            </div>
                                            <textarea name="details[sh_goals]" class="form-control"
                                                rows="6">{{ old('details[sh_goals]', $hauoraPlan->hauoraPlanDetails?->sh_goals) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Plan - How will the goals be achieved and
                                                    measure</p>
                                            </div>
                                            <textarea name="details[sh_plan]" class="form-control"
                                                rows="6">{{ old('details[sh_plan]', $hauoraPlan->hauoraPlanDetails?->sh_plan) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion accordion-solid-header mt-2" id="accordion-4" role="tablist">
                        <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                            <div class="card-header" role="tab" id="heading-4">
                                <h6 class="mb-0">
                                    <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                                        href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
                                        <span class="float-left font-weight-bold">
                                            <i class="ti-calendar mr-1"></i>
                                            Taha Whānau - Family Health - Belong to & share with whānau and the wider
                                            social system
                                        </span>
                                        <span class="select-container d-flex align-items-center">
                                            <span class="text-nowrap px-2">Rating Scale</span>
                                            <select class="form-control select-box" id="ratingSelect4"
                                                name="details[fh_rating]">
                                                <option value="" selected disabled>1 - 5</option>
                                                <option value="1" {{(old("details[fh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->fh_rating)==1) ? "selected" : "" }}>1
                                                </option>
                                                <option value="2" {{(old("details[fh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->fh_rating)==2) ? "selected" : "" }}>2
                                                </option>
                                                <option value="3" {{(old("details[fh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->fh_rating)==3) ? "selected" : "" }}>3
                                                </option>
                                                <option value="4" {{(old("details[fh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->fh_rating)==4) ? "selected" : "" }}>4
                                                </option>
                                                <option value="5" {{(old("details[fh_rating]", $hauoraPlan->
                                                    hauoraPlanDetails?->fh_rating)==5) ? "selected" : "" }}>5
                                                </option>
                                            </select>
                                        </span>
                                    </a>
                                </h6>
                            </div>

                            <div id="collapse-4" class="collapse" role="tabpanel" aria-labelledby="heading-4"
                                data-parent="#accordion-4">
                                <div class="card-body p-3">
                                    <div class="row mt-2">
                                        <div class="col-md-6 mb-2">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Strengths - What is already in place to
                                                    support Taha Whānau</p>
                                            </div>
                                            <textarea name="details[fh_strengths]" class="form-control"
                                                rows="6">{{ old('details[fh_strengths]', $hauoraPlan->hauoraPlanDetails?->fh_strengths) }}</textarea>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Needs - What needs to be put in place to
                                                    support Taha Whānau</p>
                                            </div>
                                            <textarea name="details[fh_needs]" class="form-control"
                                                rows="6">{{ old('details[fh_needs]', $hauoraPlan->hauoraPlanDetails?->fh_needs) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Client Goals - As identified by the client
                                                </p>
                                            </div>
                                            <textarea name="details[fh_goals]" class="form-control"
                                                rows="6">{{ old('details[fh_goals]', $hauoraPlan->hauoraPlanDetails?->fh_goals) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="text-center mb-1">
                                                <p style="font-size: 18px;">Plan - How will the goals be achieved and
                                                    measured</p>
                                            </div>
                                            <textarea name="details[fh_plan]" class="form-control"
                                                rows="6">{{ old('details[fh_plan]', $hauoraPlan->hauoraPlanDetails?->fh_plan) }}</textarea>
                                        </div>
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
@stop
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/member/hauora_plan/create.js')
@endpush
