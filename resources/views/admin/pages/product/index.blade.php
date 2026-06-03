@extends('admin.layouts.master')
@section('title', 'Product')
@section('product', 'active')

@section('content')
@php
use App\Models\Product;
use App\Library\Enum;

$query = Product::with('category');
$total = $query->get()->count();
$published = $query->get()->where('status', Enum::PRODUCT_STATUS_PUBLISHED)->where('approved', 1)->count();
$unpublished = $query->get()->where('status', Enum::PRODUCT_STATUS_UNPUBLISHED)->where('approved', 1)->count();
$trash = $query->onlyTrashed()->where('status', Enum::PRODUCT_STATUS_TRASH)->get()->count();
$s = isset($_GET['s']) ? $_GET['s'] : null;
$status = 'all';
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Product')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.components.product_topbar')
        </div>
    </div>

    <div class="card mb-2 mt-3">
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status == null || $status == 'all'  ? 'active' : '' }}" href="#all"
                        onclick="filterStatus('all')">
                        {{__('All')}}
                        <span class="badge badge-primary">{{ $total }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status === 'published' ? 'active' : '' }}" href="#published"
                        onclick="filterStatus('{{ Enum::PRODUCT_STATUS_PUBLISHED }}')">
                        {{__('Published')}}
                        <span class="badge badge-primary">{{ $published }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status === 'unpublished' ? 'active' : '' }}" href="#unpublished"
                        onclick="filterStatus('{{ Enum::PRODUCT_STATUS_UNPUBLISHED }}')">
                        {{__('Unpublished')}}
                        <span class="badge badge-primary">{{ $unpublished }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status === 'trash' ? 'active' : '' }}" href="#trash"
                        onclick="filterStatus('{{ Enum::PRODUCT_STATUS_TRASH }}')">
                        {{__('Trash')}}
                        <span class="badge badge-primary">{{ $trash }}</span>
                    </a>
                </li>
            </ul>

            <input type="hidden" id="productStatus" value="all">

            <div class="card-header-form row mt-3">

                <div class="form-group col-sm-3">
                    <select class="form-control" name="category_id" id="categories" style="width: 100% !important">
                        <option value="" class="selected highlighted">Select Category</option>
                        @foreach ($categories as $key => $category)
                        <option class="text-capitalize" value="{{ $category->id }}" {{ old('category_id')==$category->id
                            ? 'selected' : '' }}>
                            {{ $category->getTranslation('title') }}
                        </option>

                        @foreach($category->childrenCategories as $key => $subCategory)
                        @if ($subCategory->categories)
                        <option class="text-capitalize" value="{{ $subCategory->id }}" {{
                            old("parent_id")==$subCategory->id ? "selected" : ""}}>
                            &nbsp;-{{ $subCategory->getTranslation('title') }}
                        </option>
                        @endif
                        @foreach ($subCategory->childrenCategories as $key => $subSubCat)
                        @if ($subSubCat->categories)
                        <option class="text-capitalize" value="{{ $subSubCat->id }}" {{ old('category_id')==$subSubCat->
                            id ? 'selected' : '' }}>
                            &nbsp;&nbsp;--{{ $subSubCat->getTranslation('title') }}
                        </option>
                        @endif

                        @endforeach
                        @endforeach
                        @endforeach

                    </select>
                </div>
                <input type="hidden" id="categoryId" value="">

                <div class="form-group col-sm-3">
                    <select class="form-control" id="product_sorting">
                        {{-- <option value="" class="selected highlighted">Select One</option> --}}
                        <option value="latest_on_top" {{ $s=='latest_on_top' ? 'selected' : '' }}>
                            {{ __('Latest On Top') }}</option>
                        <option value="oldest_on_top" {{ $s=='oldest_on_top' ? 'selected' : '' }}>
                            {{ __('Oldest On Top') }}</option>
                        <option value="price_high" {{ $s=='price_high' ? 'selected' : '' }}>
                            {{ __('Price(High > Low)') }}</option>
                        <option value="price_low" {{ $s=='price_low' ? 'selected' : '' }}>
                            {{ __('Price(Low > High)') }}</option>
                        <option value="sale_high" {{ $s=='sale_high' ? 'selected' : '' }}>{{ __('Sale(High > Low)') }}
                        </option>
                        <option value="sale_low" {{ $s=='sale_low' ? 'selected' : '' }}>{{ __('Sale(Low > High)') }}
                        </option>
                        <option value="rating_high" {{ $s=='rating_high' ? 'selected' : '' }}>
                            {{ __('Rating(High > Low)') }}</option>
                        <option value="rating_low" {{ $s=='rating_low' ? 'selected' : '' }}>
                            {{ __('Rating(Low > High)') }}</option>
                    </select>
                </div>
                <input type="hidden" id="productSorting" value="latest_on_top">

            </div>

            <table id="dataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Details</th>
                        <th>Current Stock</th>
                        <th>Featured</th>
                        <th>Published</th>
                        <th>Refundable</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('admin.assets.preview-image')
@include('admin.pages.product.partials.discount_modal')
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@include('admin.assets.select2')
@include('admin.assets.datetimepicker')

@push('scripts')
@vite('resources/admin_assets/js/pages/product/index.js')

<script>
    $(document).ready(function() {
        var ezzicoDiscount = {};
        ezzicoDiscount.opens = 'right',
                ezzicoDiscount.minDate = new Date(),
                ezzicoDiscount.locale = {
                    format: inputDateFormat,
                    separator: ' - ',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                }

        $('#daterangepicker-for-discount').daterangepicker(ezzicoDiscount, function(start, end, label) {
            $('#fromDate').val(start.format('YYYY-MM-DD'));
            $('#toDate').val(end.format('YYYY-MM-DD'));
        });

        // Date range value clear
        $('#daterangepicker-for-discount').val("");
        $('#daterangepicker-for-discount').on('cancel.daterangepicker', function(ev, picker) {
            $('#daterangepicker-for-discount').val("");
            $('#fromDate').val('');
            $('#toDate').val('');
        });
    });

    window.addDiscount = (product_id) => {
        $('#product_id').val(product_id);
        $("#ezzicoDiscount").show()
    }
    window.closeModal = () => {
        $("#ezzicoDiscount").hide()
    }
</script>
@endpush

@push('styles')
<style>
    /* Start Custom Switch */
    .custom-switch {
        padding-left: 0.25rem;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        margin: 0;
    }

    .custom-switch-input {
        position: absolute;
        z-index: -1;
        opacity: 0;
    }

    .custom-switch-indicator {
        display: inline-block;
        height: 1.25rem;
        width: 2.25rem;
        background: #e9ecef;
        border-radius: 50px;
        position: relative;
        vertical-align: bottom;
        border: 1px solid rgba(0, 40, 100, 0.12);
        transition: 0.3s border-color, 0.3s background-color;
    }

    .custom-switch-indicator:before {
        content: "";
        position: absolute;
        height: calc(1.25rem - 4px);
        width: calc(1.25rem - 4px);
        top: 1px;
        left: 1px;
        background: #fff;
        border-radius: 50%;
        transition: 0.3s left;
    }

    .custom-switch-input:checked~.custom-switch-indicator {
        background: var(--btn-primary);
    }

    .custom-switch-input:checked~.custom-switch-indicator:before {
        left: calc(1rem + 1px);
    }

    .custom-switch-description {
        color: #6e7687;
        margin-left: 0.5rem;
        font-size: 0.875rem;
        transition: 0.3s color;
    }

    .custom-switch-input:checked~.custom-switch-description {
        color: #1e1f21;
    }

    .cursor-not-allowed {
        cursor: not-allowed !important;
    }
    table .custom_span {
        display: block !important;
        margin-bottom: -10px;
    }
</style>
@endpush