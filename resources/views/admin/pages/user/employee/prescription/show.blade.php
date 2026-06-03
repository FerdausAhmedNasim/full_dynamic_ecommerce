@extends('admin.layouts.master')
@section('title', 'Note Details')
@section('content')

@php
use App\Library\Helper;
@endphp
<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.employee.show', $prescription->user->employee->id).'#tab-note') !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Note Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <!-- Home Content -->
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="border-bottom text-center pb-2">
                        <div class="mb-3">
                            <h3>{{$prescription->title}}</h3>
                        </div>

                    </div>
                    <div class="text-center mt-4 nav-tab">
                        @if(Helper::hasAuthRolePermission('note_update'))
                        <a href="{{ route('admin.user.employee.prescription.edit', $prescription->id) }}"
                            class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>
                        @endif

                        @if(Helper::hasAuthRolePermission('note_delete'))
                        <button class="btn btn-sm btn-danger mb-2"
                            onclick="confirmFormModal('{{ route('admin.user.employee.prescription.delete', $prescription->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i
                                class="fas fa-trash-alt"></i> Delete </button>
                        @endif
                    </div>
                </div>
            </div>
            <!-- End Home Content-->
            <div class="card mt-3">
                <div class="card-body table-responsive">
                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <td>Operator</td>
                                <td>{{ $prescription?->operator->full_name }}</td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>{{ getFormattedDateTime($prescription->created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title">Description</h4>
                </div>
                <div class="card-body">
                    @if($prescription->description)
                    <p>{!! $prescription->description !!}</p>
                    @else
                    <p class="text-center">No data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.assets.preview-image')

@stop



@push('scripts')
@endpush
