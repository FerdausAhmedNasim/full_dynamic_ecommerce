@extends('seller.layouts.master')

@section('title', 'Product')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Product')) }}</h4>
        </div>
    </div>

    @php
        use App\Models\Product;
        use App\Library\Enum;

        $query       = Product::where('seller_id', auth()->id());
        $total       = $query->get()->count();
        $published   = $query->get()->where('status', Enum::PRODUCT_STATUS_PUBLISHED)->where('approved', 1)->count();
        $unpublished = $query->get()->where('status', Enum::PRODUCT_STATUS_UNPUBLISHED)->where('approved', 1)->count();
        $pending     = $query->get()->where('approved', false)->count();
        $trash       = $query->onlyTrashed()->where('status', Enum::PRODUCT_STATUS_TRASH)->get()->count();
        $s           = isset($_GET['s']) ? $_GET['s'] : null;
        $status      = 'all';
    @endphp

    <div class="card mb-2">
        <div class="card-body">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status == null || $status == 'all'  ? 'active' : '' }}"
                        href="#all" onclick="filterStatus('all')">
                        {{__('All')}}
                        <span class="badge badge-primary">{{ $total }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status === 'published' ? 'active' : '' }}"
                        href="#published" onclick="filterStatus('{{ Enum::PRODUCT_STATUS_PUBLISHED }}')">
                        {{__('Published')}}
                        <span class="badge badge-primary">{{ $published }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status === 'unpublished' ? 'active' : '' }}"
                        href="#unpublished" onclick="filterStatus('{{ Enum::PRODUCT_STATUS_UNPUBLISHED }}')">
                        {{__('Unpublished')}}
                        <span class="badge badge-primary">{{ $unpublished }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status === 'pending' ? 'active' : '' }}"
                        href="#pending" onclick="filterStatus('pending')">
                        {{__('Pending')}}
                        <span class="badge badge-primary">{{ $pending }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link tab-menu {{ $status === 'trash' ? 'active' : '' }}"
                        href="#trash" onclick="filterStatus('{{ Enum::PRODUCT_STATUS_TRASH }}')">
                        {{__('Trash')}}
                        <span class="badge badge-primary">{{ $trash }}</span>
                    </a>
                </li>
            </ul>

            <input type="hidden" id="productStatus" value="all">
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="card-header-form row">
                <div class="form-group col-sm-3">
                    <select class="form-control" name="category_id" id="categories" style="width: 100% !important">
                        <option value="" class="selected highlighted">Select Category</option>
                        @foreach ($categories as $key => $category)
                            <option class="text-capitalize" value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->category->getTranslation('title') }}
                            </option>

                            @foreach ($category->category->childrenCategories as $key => $subCategory)
                                @if ($subCategory->categories)
                                    <option class="text-capitalize" value="{{ $subCategory->id }}"
                                        {{ old('category_id') == $subCategory->id ? 'selected' : '' }}>
                                        &nbsp;¦--{{ $subCategory->getTranslation('title') }}
                                    </option>
                                @endif

                                @foreach ($subCategory->childrenCategories as $key => $subSubCat)
                                    @if ($subSubCat->categories)
                                        <option class="text-capitalize" value="{{ $subSubCat->id }}"
                                            {{ old('category_id') == $subSubCat->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;¦--¦--{{ $subSubCat->getTranslation('title') }}
                                        </option>
                                    @endif

                                    @foreach ($subSubCat->childrenCategories as $key => $subSub2Cat)
                                        @if ($subSub2Cat->categories)
                                            <option class="text-capitalize" value="{{ $subSub2Cat->id }}"
                                                {{ old('category_id') == $subSub2Cat->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;&nbsp;¦--¦--¦--{{ $subSub2Cat->getTranslation('title') }}
                                            </option>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <input type="hidden" id="categoryId" value="">

                <div class="form-group col-sm-3">
                    <select class="form-control" id="product_sorting" >
                        {{-- <option value="" class="selected highlighted">Select One</option> --}}
                        <option value="latest_on_top" {{ $s == 'latest_on_top' ? 'selected' : '' }}>{{ __('Latest On Top') }}</option>
                        <option value="oldest_on_top" {{ $s == 'oldest_on_top' ? 'selected' : '' }}>{{ __('Oldest On Top') }}</option>
                        <option value="price_high" {{ $s == 'price_high' ? 'selected' : '' }}>{{ __('Price(High > Low)') }}</option>
                        <option value="price_low" {{ $s == 'price_low' ? 'selected' : '' }}>{{ __('Price(Low > High)') }}</option>
                        <option value="sale_high" {{ $s == 'sale_high' ? 'selected' : '' }}>{{ __('Sale(High > Low)') }}</option>
                        <option value="sale_low" {{ $s == 'sale_low' ? 'selected' : '' }}>{{ __('Sale(Low > High)') }}</option>
                        <option value="rating_high" {{ $s == 'rating_high' ? 'selected' : '' }}>{{ __('Rating(High > Low)') }}</option>
                        <option value="rating_low" {{ $s == 'rating_low' ? 'selected' : '' }}>{{ __('Rating(Low > High)') }}</option>
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
                        <th>Approved</th>
                        <th>Published</th>
                        <th>Refundable</th>
                        <th>Show Shop Page</th>
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
@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')
@include('admin.assets.select2')

@push('scripts')
@vite('resources/seller_assets/js/pages/product/index.js')
@endpush


@push('styles')
    <style>
        .nav-pills .nav-link, .nav-pills .tab-menu {
            color: black;
            padding: 0.5rem 1rem !important;
            border: 1px solid #CED4DA;
        }
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #4ace8b;
        }

        .table td {
            color:#526484;
            letter-spacing: 0.015em;
            font-size: 0.975rem;
            line-height: 1.65 !important;
        }

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
        .custom-switch-input:checked ~ .custom-switch-indicator {
            background: #4ace8b;
        }
        .custom-switch-input:checked ~ .custom-switch-indicator:before {
            left: calc(1rem + 1px);
        }
        .custom-switch-description {
            color: #6e7687;
            margin-left: 0.5rem;
            font-size: 0.875rem;
            transition: 0.3s color;
        }
        .custom-switch-input:checked ~ .custom-switch-description {
            color: #1e1f21;
        }
        .cursor-not-allowed {
            cursor: not-allowed !important;
        }

    </style>
@endpush
