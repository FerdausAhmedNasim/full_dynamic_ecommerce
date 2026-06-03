@extends('seller.layouts.master')

@section('title', 'Immunization Details')

@section('content')


<div class="content-wrapper" id="reloadShowDiv">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.member.show.immunization', $immunization->client_id)) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('immunization Details')) }}</h4>
        </div>
    </div>


    <div class="row">
        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 pb-4">
            <div class="card shadow-sm mb-2">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3">
                            <h3>{{ $immunization->name }}</h3>
                        </div>
                    </div>

                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width:15%;"> <b>Immunisation By</b> </td>
                                <td style="white-space: unset;">{{ $immunization->immunized_by ? $immunization->immunizedBy->user?->full_name : 'N/A' }}</td>

                                <td style="width:15%;"><b>Immunisation Date</b></td>
                                <td style="white-space: unset;"> {{ $immunization->immunized_date ? getFormattedDateTime($immunization->immunized_date) : 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td style="width:15%;"><b>Target Date</b></td>
                                <td style="white-space: unset;"> {{ getFormattedDateTime($immunization->target_date) }}</td>
                                <td style="width:15%;"><b>Status</b></td>
                                <td style="white-space: unset;"> {!! App\Library\Html::ImmunizationStatus($immunization->status) !!} </td>
                            </tr>

                        </tbody>
                    </table>


                    <div class="text-center mt-4">

                        <button
                            class="btn btn-sm mb-2 mr-2 change-status {{ $immunization->status == \App\Library\Enum::IMMUNIZATION_STATUS_PENDING  ? 'btn-secondary' : 'btn2-secondary' }}"
                            onclick="clickChangeStatusAction()">
                            <i class="fas fa-power-off"></i> Change Status
                        </button>

                        @if(!$immunization->immunized_by)
                        <a href="{{ route('seller.member.immunization.done', $immunization->id) }}"
                            class="btn btn-sm btn-success mb-2 mr-2"><i class="fa-solid fa-check"></i> Done</a>
                        @endif

                        <a href="{{ route('seller.member.immunization.edit', $immunization->id) }}"
                            class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>

                        <button class="btn btn-sm mb-2 mr-2 btn-danger"
                            onclick="confirmFormModal('{{ route('seller.member.immunization.delete', $immunization->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i
                                class="fas fa-trash-alt"></i> Delete </button>

                    </div>
                </div>
            </div>

            @if($immunization->immunized_note)
                <div class="card shadow-sm col-md-12">
                    <div class="card-body py-4 flex-item-center">
                        <h3 class="text-center">Immunization Note</h3>
                        <hr>
                        {!! $immunization->immunized_note !!}
                    </div>
                </div>
            @endif

        </div>

        @if($immunization->target_note)
        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
            <div class="card shadow-sm col-md-12">
                <div class="card-body py-4">
                    <h3 class="text-center">Target Note</h3>
                    <hr>
                    {!! $immunization->target_note !!}
                </div>
            </div>
        </div>
        @endif
    </div>


</div>

@include('seller.pages.member.immunization.partial.immunization_modal')
@stop

@push('scripts')
@vite('resources/employee_assets/js/member/immunization/show.js')
@endpush

