@extends('seller.layouts.master')

@section('title', 'Product Details')

@section('content')

@php
use App\Library\Helper;
@endphp

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.product.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Product Details')) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm">
                <div class="card-body py-sm-4">
                    <div class="text-center pb-2 border-bottom">
                        <div class="mb-3">
                            <img src="{{ $product->getThumbnailImage() }}" alt="profile" class="img-fluid mb-3"
                                onclick="clickImage('{{ $product->getThumbnailImage() }}')">
                        </div>
                        <div class="mb-3">
                            <h3>{{$product->name}}</h3>
                        </div>
                    </div>

                    <div class="text-center my-4">

                        @if(Helper::hasAuthRolePermission('product_status'))
                        <button
                            class="btn btn-sm mb-2 mr-2 change-status {{ $product->is_active ? 'btn-secondary' : 'btn2-secondary' }}"
                            onclick="changeStatus('{{ route('admin.product.change_status', $product->id) }}')">
                            <i class="fas fa-power-off"></i>
                            {{ $product->is_active ? 'Make InActive' : 'Make Active' }}
                        </button>
                        @endif

                        @if(Helper::hasAuthRolePermission('product_status'))
                        <button
                            class="btn btn-sm mb-2 mr-2 change-status {{ $product->is_featured ? 'btn-secondary' : 'btn2-secondary' }}"
                            onclick="changeStatus('{{ route('admin.product.change_feature', $product->id) }}')">
                            <i class="fas fa-power-off"></i>
                            {{ $product->is_featured ? 'Make UnFeature' : 'Make Feature' }}
                        </button>
                        @endif


                        @if(Helper::hasAuthRolePermission('product_update'))
                        <a href="{{ route('admin.product.edit', $product->id) }}"
                            class="btn btn-sm btn-warning mb-2 mr-2"><i class="fas fa-edit"></i> Edit</a>
                        @endif

                        @if(Helper::hasAuthRolePermission('product_delete'))
                        <button class="btn btn-sm btn-danger mb-2"
                            onclick="confirmFormModal('{{ route('admin.product.delete', $product->id) }}', 'Confirmation', 'Are you sure to delete operation?')"><i
                                class="fas fa-trash-alt"></i> Delete </button>
                        @endif
                    </div>

                    <table class="table org-data-table table-bordered">
                        <tbody>
                            <tr>
                                <td>Active Status</td>
                                <td>
                                    <span class="badge {{($product->is_active) ? "btn2-secondary" : "btn-secondary"}}">
                                        {{($product->is_active) ? "Active" : "Inactive"}}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Feature Status</td>
                                <td>
                                    <span class="badge {{($product->is_featured) ? "btn2-secondary" : "btn-secondary"}}">
                                        {{($product->is_featured) ? "Featured" : "UnFeatured"}}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>Category</td>
                                <td>{{ $product->category->name }}</td>
                            </tr>

                            <tr>
                                <td>Brand</td>
                                <td>{{ $product->brand  ?? 'N/A'}}</td>
                            </tr>

                            <tr>
                                <td>Unit</td>
                                <td>{{ $product->unit ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td>Model</td>
                                <td>{{ $product->model ?? 'N/A' }}</td>
                            </tr>

                            <tr>
                                <td>Operator</td>
                                <td>{{ $product?->operator->full_name }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    Description
                </div>
                <div class="card-body">
                    <p>{!! $product->description !!}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<common-update-password></common-update-password>

@include('admin.assets.preview-image')

@stop


@push('scripts')
<script>
window.changeStatus = function (route, confirmation_msg)
{
    confirmFormModal(route, 'Confirmation', confirmation_msg);
}
</script>
@endpush