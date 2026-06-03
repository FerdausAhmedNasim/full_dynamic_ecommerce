@extends('admin.layouts.master')

@section('title', 'Service Details')

@section('content')

@php
    use App\Library\Helper;
    $user_role = App\Models\User::getAuthUser()->roles()->first();
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.config.more_settings.service.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Service Details')) }}</h4>
        </div>
    </div>

    <div class="row">

        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">

                    {{-- <div class="border-bottom text-center pb-2">
                        <img src="" alt="profile" class="img-lg rounded-circle mb-3">
                        <div class="mb-3">
                            <h3>{{ $service->name }} </h3>
                        </div>
                        <p class="mx-auto mb-2 w-75">{{ $service->location }}</p>
                    </div> --}}

                    <table class="table org-data-table table-bordered show-table">
                        <tbody>
                            <tr>
                                <td>Service Name</td>
                                <td> {{ $service->name }} </td>
                            </tr>
                            <tr>
                                <td>Service Manager</td>
                                <td> {{ $service->serviceManager->user?->full_name }} </td>
                            </tr>
                            <tr>
                                <td>Kaimahi IDs</td>
                                <td>
                                    @foreach($service->getEmployee() as $key => $value)
                                        <span class="badge btn2-secondary mr-2 mb-1">{{ $value->user?->full_name }}</span>
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>Location</td>
                                <td> {{ $service->location }} </td>
                            </tr>
                            <tr>
                                <td>Reporting Frequency</td>
                                <td> {{ $service->reporting_frequency }} </td>
                            </tr>
                            <tr>
                                <td>Start Date</td>
                                <td> {{ $service->start_date }} </td>
                            </tr>
                            <tr>
                                <td>End Date</td>
                                <td> {{ $service->end_date }} </td>
                            </tr>
                            <tr>
                                <td>Funder name</td>
                                <td> {{ $service->funder_name }} </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Funder Details</td>
                                <td style="white-space: unset;"> {{ $service->funder_details }} </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Operator</td>
                                <td style="white-space: unset;"> {{ $service?->operator->full_name }} </td>
                            </tr>
                        </tbody>
                    </table>


                    <div class="text-center mt-4">

                        @if(Helper::hasAuthRolePermission('config_service_update'))
                            <a href="{{ route('admin.config.more_settings.service.update', $service->id) }}" class="btn btn-sm btn-warning mb-2 mr-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif

                        @if(Helper::hasAuthRolePermission('config_service_delete'))
                            <button class="btn btn-sm btn-danger mb-2"
                                onclick="confirmFormModal('{{ route('admin.config.more_settings.service.delete', $service->id) }}', 'Confirmation', 'Are you sure to delete operation?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        @endif

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-light-secondary">
                    <span><i class="fas fa-book"></i> {{ __('Descriptions') }} </span>
                </div>

                <div class="card-body py-4">
                    <div class="text-left">

                        {!! $service->description !!}

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@stop

@push('scripts')
<script>

</script>
@endpush
