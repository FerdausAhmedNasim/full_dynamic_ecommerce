@extends('seller.layouts.master')

@section('title', 'Hauora Plan Details')

@section('content')

@php
$user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper" id="reloadShowDiv">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack( route('seller.member.show.hauora.plan', $hauoraPlan->client_id) ) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Hauora Plan Details')) }}</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-md-5 pb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3">
                            <h3>{{ $hauoraPlan->name }}</h3>
                        </div>
                    </div>

                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @php
                                    use App\Library\Enum;
                                    if ($hauoraPlan->status == Enum::HAUORA_PLAN_STATUS_ACTIVE){
                                    $class = 'badge-secondary';
                                    }
                                    else if ($hauoraPlan->status == Enum::HAUORA_PLAN_STATUS_HOLD){
                                    $class = 'badge-warning';
                                    }
                                    else if ($hauoraPlan->status == Enum::HAUORA_PLAN_STATUS_COMPLETED){
                                    $class = 'badge-success';
                                    }
                                    @endphp

                                    <div class="badge {{ $class }}">
                                        {{ ucwords(Enum::getHauoraPlanStatus($hauoraPlan->status)) }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Plan Type</td>
                                <td> {{ ucwords($hauoraPlan->plan_type) }} </td>
                            </tr>
                            <tr>
                                <td>Services</td>
                                <td> {{ $hauoraPlan->services->pluck('name')->implode(', '); }} </td>
                            </tr>
                            <tr>
                                <td>Members</td>
                                @php
                                $employees = $hauoraPlan->employees;

                                $data = [];

                                foreach ($employees as $employee) {
                                $data[] = $employee->user?->full_name;
                                }

                                $members = collect($data)->implode(', ');
                                @endphp
                                <td> {{ $members }} </td>
                            </tr>
                            <tr>
                                <td>Follow Up Date</td>
                                <td> {{ getFormattedDateTime($hauoraPlan->follow_up_date) }}
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="text-center mt-4">

                        @if($hauoraPlan->status == Enum::HAUORA_PLAN_STATUS_ACTIVE)
                        <a href="{{ route('seller.member.hauora_plan.follow_up.create', $hauoraPlan->id) }}"
                            class="btn btn-sm btn-success mb-2 mr-2"><i class="fa fa-arrow-circle-right"></i> Follow
                            Up</a>
                        @endif

                        <button class="btn btn-sm mb-2 mr-2 btn-info"
                            onclick="clickChangeStatusAction({{ $hauoraPlan->id }})">
                            <i class="fas fa-power-off"></i> Change Status
                        </button>

                        <a href="{{ route('seller.member.hauora_plan.edit', $hauoraPlan->id) }}"
                            class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>

                        <button class="btn btn-sm mb-2 mr-2 btn-danger"
                            onclick="confirmFormModal('{{ route('seller.member.hauora_plan.delete', $hauoraPlan->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i
                                class="fas fa-trash-alt"></i> Delete </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header text-center display-5"> {{ __('Follow-Ups') }}</div>
                <div class="card-body py-4">
                    @foreach ($hauoraPlan->hauoraPlanDetails as $hauoraPlanDetail)
                    <div class="accordion accordion-solid-header mt-2" id="accordion-m{{$hauoraPlanDetail->id}}"
                        role="tablist">
                        <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                            <div class="card-header" role="tab" id="heading-m{{$hauoraPlanDetail->id}}">
                                <h6 class="mb-0">
                                    <a class="d-flex justify-content-between align-items-center" data-toggle="collapse"
                                        href="#collapse-m{{$hauoraPlanDetail->id}}" aria-expanded="false"
                                        aria-controls="collapse-m{{$hauoraPlanDetail->id}}">
                                        <span class="float-left font-weight-bold">
                                            <i class="ti-calendar mr-1"></i>
                                            {{ getFormattedDateTime($hauoraPlanDetail->created_at)}}
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <button onclick="goToEdit(event, {{$hauoraPlanDetail->id}})"
                                                class="btn btn-sm btn-outline-dark py-2"><i class="fas fa-edit"></i></button>
                                        </span>
                                    </a>
                                </h6>
                            </div>
                            <div id="collapse-m{{$hauoraPlanDetail->id}}" class="collapse" role="tabpanel"
                                aria-labelledby="heading-m{{$hauoraPlanDetail->id}}"
                                data-parent="#accordion-m{{$hauoraPlanDetail->id}}">
                                <div class="accordion accordion-solid-header mt-2 mx-3"
                                    id="accordion-s1-{{$hauoraPlanDetail->id}}" role="tablist">
                                    <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                                        <div class="card-header" role="tab" id="heading-s1-{{$hauoraPlanDetail->id}}">
                                            <h6 class="mb-0">
                                                <a class="d-flex justify-content-between align-items-center"
                                                    data-toggle="collapse" href="#collapse-s1-{{$hauoraPlanDetail->id}}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-s1-{{$hauoraPlanDetail->id}}">
                                                    <span class="float-left font-weight-bold">
                                                        <i class="ti-calendar mr-1"></i>
                                                        Taha Tinana - Physical Growth & Development
                                                    </span>
                                                    <span class="d-flex align-items-center">
                                                        @for ($i = 0; $i < 5; $i++) @if ($i < $hauoraPlanDetail->
                                                            ph_rating)
                                                            <i class="fa-solid fa-star"
                                                                style="color: #f2740d; font-weight: 900 !important;"></i>
                                                            @else
                                                            <i class="fa-regular fa-star"></i>
                                                            @endif
                                                            @endfor
                                                    </span>
                                                </a>
                                            </h6>
                                        </div>

                                        <div id="collapse-s1-{{$hauoraPlanDetail->id}}" class="collapse" role="tabpanel"
                                            aria-labelledby="heading-s1-{{$hauoraPlanDetail->id}}"
                                            data-parent="#accordion-s1-{{$hauoraPlanDetail->id}}">
                                            <div class="card-body p-3">
                                                <div class="row mt-2">
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Strengths - What is already in
                                                                place to
                                                                support Taha Tinana</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->ph_strengths}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Needs - What needs to be put in
                                                                place to
                                                                support Taha Tinana</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->ph_needs}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Client Goals - As identified by
                                                                the
                                                                client</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->ph_goals}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-11 offset-md-1 card mb-2">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Plan - How will the goals be
                                                                achieved
                                                                and
                                                                measure</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->ph_plan}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion accordion-solid-header mt-2 mx-3"
                                    id="accordion-s2-{{$hauoraPlanDetail->id}}" role="tablist">
                                    <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                                        <div class="card-header" role="tab" id="heading-s2-{{$hauoraPlanDetail->id}}">
                                            <h6 class="mb-0">
                                                <a class="d-flex justify-content-between align-items-center"
                                                    data-toggle="collapse" href="#collapse-s2-{{$hauoraPlanDetail->id}}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-s2-{{$hauoraPlanDetail->id}}">
                                                    <span class="float-left font-weight-bold">
                                                        <i class="ti-calendar mr-1"></i>
                                                        Taha Hinengaro - Mental Health - Capacity to think and feel
                                                        (thoughts,
                                                        feelings, emotions)
                                                    </span>
                                                    <span class="d-flex align-items-center">
                                                        @for ($i = 0; $i < 5; $i++) @if ($i < $hauoraPlanDetail->
                                                            mh_rating)
                                                            <i class="fa-solid fa-star"
                                                                style="color: #f2740d; font-weight: 900 !important;"></i>
                                                            @else
                                                            <i class="fa-regular fa-star"></i>
                                                            @endif
                                                            @endfor
                                                    </span>
                                                </a>
                                            </h6>
                                        </div>

                                        <div id="collapse-s2-{{$hauoraPlanDetail->id}}" class="collapse" role="tabpanel"
                                            aria-labelledby="heading-s2-{{$hauoraPlanDetail->id}}"
                                            data-parent="#accordion-s2-{{$hauoraPlanDetail->id}}">
                                            <div class="card-body p-3">
                                                <div class="row mt-2">
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Strengths - What is already in
                                                                place to
                                                                support Taha Hinengaro</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->mh_strengths}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Needs - What needs to be put in
                                                                place to
                                                                support Taha Hinengaro</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->mh_needs}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Client Goals - As identified by
                                                                the
                                                                client</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->mh_goals}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-11 offset-md-1 card mb-2">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Plan - How will the goals be
                                                                achieved
                                                                and
                                                                measure</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->mh_plan}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion accordion-solid-header mt-2 mx-3"
                                    id="accordion-s3-{{$hauoraPlanDetail->id}}" role="tablist">
                                    <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                                        <div class="card-header" role="tab" id="heading-s3-{{$hauoraPlanDetail->id}}">
                                            <h6 class="mb-0">
                                                <a class="d-flex justify-content-between align-items-center"
                                                    data-toggle="collapse" href="#collapse-s3-{{$hauoraPlanDetail->id}}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-s3-{{$hauoraPlanDetail->id}}">
                                                    <span class="float-left font-weight-bold">
                                                        <i class="ti-calendar mr-1"></i>
                                                        Taha Wairua - Spiritual Health - Faith & wider communication.
                                                        Life force
                                                    </span>
                                                    <span class="d-flex align-items-center">
                                                        @for ($i = 0; $i < 5; $i++) @if ($i < $hauoraPlanDetail->
                                                            sh_rating)
                                                            <i class="fa-solid fa-star"
                                                                style="color: #f2740d; font-weight: 900 !important;"></i>
                                                            @else
                                                            <i class="fa-regular fa-star"></i>
                                                            @endif
                                                            @endfor
                                                    </span>
                                                </a>
                                            </h6>
                                        </div>

                                        <div id="collapse-s3-{{$hauoraPlanDetail->id}}" class="collapse" role="tabpanel"
                                            aria-labelledby="heading-s3-{{$hauoraPlanDetail->id}}"
                                            data-parent="#accordion-s3-{{$hauoraPlanDetail->id}}">
                                            <div class="card-body p-3">
                                                <div class="row mt-2">
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Strengths - What is already in
                                                                place to
                                                                support Taha Wairua</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->sh_strengths}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Needs - What needs to be put in
                                                                place to
                                                                support Taha Wairua</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->sh_needs}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Client Goals - As identified by
                                                                the
                                                                client</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->sh_goals}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-11 offset-md-1 card mb-2">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Plan - How will the goals be
                                                                achieved
                                                                and
                                                                measure</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->sh_plan}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion accordion-solid-header mt-2 mx-3"
                                    id="accordion-s4-{{$hauoraPlanDetail->id}}" role="tablist">
                                    <div class="card" style="box-shadow: 2px 4px 5px #e4e4e4;">
                                        <div class="card-header" role="tab" id="heading-s4-{{$hauoraPlanDetail->id}}">
                                            <h6 class="mb-0">
                                                <a class="d-flex justify-content-between align-items-center"
                                                    data-toggle="collapse" href="#collapse-s4-{{$hauoraPlanDetail->id}}"
                                                    aria-expanded="false"
                                                    aria-controls="collapse-s4-{{$hauoraPlanDetail->id}}">
                                                    <span class="float-left font-weight-bold">
                                                        <i class="ti-calendar mr-1"></i>
                                                        Taha Whānau - Family Health - Belong to & share with whānau and
                                                        the
                                                        wider
                                                        social system
                                                    </span>
                                                    <span class="d-flex align-items-center">
                                                        @for ($i = 0; $i < 5; $i++) @if ($i < $hauoraPlanDetail->
                                                            fh_rating)
                                                            <i class="fa-solid fa-star"
                                                                style="color: #f2740d; font-weight: 900 !important;"></i>
                                                            @else
                                                            <i class="fa-regular fa-star"></i>
                                                            @endif
                                                            @endfor
                                                    </span>
                                                </a>
                                            </h6>
                                        </div>

                                        <div id="collapse-s4-{{$hauoraPlanDetail->id}}" class="collapse" role="tabpanel"
                                            aria-labelledby="heading-s4-{{$hauoraPlanDetail->id}}"
                                            data-parent="#accordion-s4-{{$hauoraPlanDetail->id}}">
                                            <div class="card-body p-3">
                                                <div class="row mt-2">
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Strengths - What is already in
                                                                place to
                                                                support Taha Whānau</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->fh_strengths}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Needs - What needs to be put in
                                                                place to
                                                                support Taha Whānau</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->fh_needs}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-11 offset-md-1 card mb-4">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Client Goals - As identified by
                                                                the
                                                                client</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->fh_goals}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-11 offset-md-1 card mb-2">
                                                        <div class="card-block ">
                                                            <h4 style="card-title py-1">Plan - How will the goals be
                                                                achieved
                                                                and
                                                                measure</h4>
                                                            <p class="card-text">
                                                                {{$hauoraPlanDetail->fh_plan}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@include('seller.pages.member.hauora_plan.partial.status_modal')
@stop

@push('styles')
<style>
    .card .card-header h6 a[aria-expanded="true"] span .btn-outline-dark {
        color: #fff;
        border-color: #fff;
    }

    .card .card-header h6 a[aria-expanded="true"] span .btn-outline-dark:hover {
        background-color: #e4e4e4;
        color: #282f3a;
    }
</style>
@endpush
@push('scripts')
@vite('resources/admin_assets/js/pages/member/hauora_plan/show.js')
@endpush
