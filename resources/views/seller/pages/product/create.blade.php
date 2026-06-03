@extends('seller.layouts.master')

@section('title', __('New Product'))

@section('content')

    <div class="content-wrapper">

        <div class="content-header d-flex justify-content-start">
            {!! \App\Library\Html::linkBack(route('seller.product.index')) !!}
            <div class="d-block">
                <h4 class="content-title">{{ strtoupper(__('New Product')) }}</h4>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body py-sm-4">
                <ul class="nav nav-tab" role="tablist">
                    <li class="nav-item">
                        <a href="#productInformation" data-toggle="tab" role="tab"
                            class="nav-link active {{ has_key(['title','category_id','brand_id','unit','weight','minimum_order_quantity','barcode','tags'],$errors) ? 'tab-error' : '' }}">
                            Product Information
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#productPriceAndStock" data-toggle="tab" role="tab"
                            class="nav-link {{ has_key(['unit_price','discount_type','discount','discount_period','has_variant','low_stock_to_notify','stock_visibility','sku','current_stock','colors','attribute_sets','variant_name','variant_ids','variant_price','variant_sku','variant_stock','variant_image'],$errors) ? 'tab-error' : '' }}">
                            Product Price & Stock
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#images" data-toggle="tab" role="tab"
                            class="nav-link {{ has_key(['product_thumbnail','images'],$errors) ? 'tab-error' : '' }}">
                            Images
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#descriptionsAndSpecifications" data-toggle="tab" role="tab"
                            class="nav-link {{ has_key(['short_description','description','description_image'],$errors) ? 'tab-error' : '' }}">
                            Descriptions & Specifications
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#shippingInfo" data-toggle="tab" role="tab"
                            class="nav-link {{ has_key(['shipping_type','shipping_fee','shipping_fee_depend_on_quantity','cash_on_delivery','estimated_shipping_days'],$errors) ? 'tab-error' : '' }}">
                            Shipping Info
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#others" data-toggle="tab" role="tab"
                            class="nav-link {{ has_key(['featured','refundable','todays_deal'],$errors) ? 'tab-error' : '' }}">
                            Product Service & Others
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#seo" data-toggle="tab" role="tab"
                            class="nav-link {{ has_key(['meta_title','meta_description','meta_keywords','meta_image'],$errors) ? 'tab-error' : '' }}">
                            SEO
                        </a>
                    </li>

                </ul>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="text-danger">{{$error}}</div>
                    @endforeach
                @endif

            </div>
        </div>

        <form action="{{ route('seller.product.store') }}" method="post" enctype="multipart/form-data" data-form="{{ route('seller.product.getVariants') }}" data-for="add" id="variant">
            @csrf

            <div class="tab-content">

                <div class="tab-pane active" id="productInformation" role="tabpanel">
                    @include('seller.pages.product.partials.create.basicInformation')
                </div>

                <div class="tab-pane" id="productPriceAndStock" role="tabpanel">
                    @include('seller.pages.product.partials.create.priceAndStock')
                </div>

                <div class="tab-pane" id="images" role="tabpanel">
                    @include('seller.pages.product.partials.create.images')
                </div>

                <div class="tab-pane" id="descriptionsAndSpecifications" role="tabpanel">
                    @include('seller.pages.product.partials.create.descriptionsAndSpecifications')
                </div>

                <div class="tab-pane" id="shippingInfo" role="tabpanel">
                    @include('seller.pages.product.partials.create.shipping')
                </div>

                <div class="tab-pane" id="others" role="tabpanel">
                    @include('seller.pages.product.partials.create.others')
                </div>

                <div class="tab-pane" id="seo" role="tabpanel">
                    @include('seller.pages.product.partials.create.seo')
                </div>

            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="modal-footer justify-content-center col-md-12">
                            {!! \App\Library\Html::btnReset() !!}
                            {!! \App\Library\Html::btnSubmit() !!}
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@stop
@include('admin.assets.summernote-text-editor')
@include('admin.assets.select2')
@include('seller.assets.tokenfield')
@include('seller.assets.dropMeImageUploader')
@include('seller.assets.toastr')

@include('admin.assets.datetimepicker')

@push('scripts')

    @vite('resources/seller_assets/js/pages/product/create.js')

    <script>

        $(document).ready(function(){
            $('#productTags').tokenfield({
                autocomplete: {
                    source: [],
                    delay:100
                },
                showAutocompleteOnFocus: true
            });
            $('#metaKeywords').tokenfield({
                autocomplete:{
                    source: [],
                    delay:100
                },
                showAutocompleteOnFocus: true
            });

            $('#datetimerangepicker').val("");

        });

    </script>
@endpush


@push('styles')

    <style>
        .col-form-label  {
            font-size: 0.875rem;
            vertical-align: top;
            line-height: 0rem !important;
            margin-bottom: 0rem !important;
        }

        .colorinput-label {
            margin: 0;
            cursor: pointer;
            position: relative;
            line-height: 1rem !important;
            margin-bottom: 0rem !important;
        }
        .colorinput-input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .colorinput-color {
            background-color: #fdfdff;
            border-color: #e4e6fc;
            border-width: 1px;
            border-style: solid;
            display: inline-block;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 3px;
            color: #fff;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .colorinput-color:before {
            content: "";
            opacity: 0;
            position: absolute;
            top: 0.25rem;
            left: 0.25rem;
            height: 1.25rem;
            width: 1.25rem;
            transition: 0.3s opacity;
            background: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E") no-repeat center center/70% 70%;
        }
        .colorinput-input:checked ~ .colorinput-color:before {
            opacity: 1;
        }

        .colorsFormCheck {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .variant-table {
            margin-left: 0px;
            margin-right: 0px;
        }
        .table td {
            padding: 0.125rem 1.375rem;
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
        .select2-container--default .select2-selection--single {
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid #ced4da !important;
        }

        .input-group-append .input-group-text {
            color: #3e5256;
            padding: 0.675rem 1.325rem;
        }
        .input-group-text {
            border-radius: 4px;
            cursor: pointer;

        }
        .display-input-image {
            margin-top: 0px;
            text-align: start;
        }
        .table td img {
            width: 70px;
            height: 65px;
            margin: 5px 0px;
        }
        .display-input-image img {
            padding: 4px;
            border: 1px solid #e6e5e5;
        }
        .image-remove {
            top: 0px;
            left: 70px;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            position: absolute;
            border: 1px solid red;
            background: #eaf0ed6e;
        }
        .remove {
            top: 5.9px;
            left: 6.7px;
            color: red;
            cursor: pointer;
            position: absolute;
        }
        .nav-tab .tab-error {
            color: white;
            background: red !important;
            background-color: red !important;
            border: 1px solid red !important;
            box-shadow: 0px 10px 15px rgb(229 46 46 / 40%) !important;
        }
        .input-group-error {
            border: 1px solid red;
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        @media (max-width: 767px) {
            .col-form-label  {
                font-size: 0.875rem;
                vertical-align: top;
                line-height: 0rem !important;
                margin-bottom: 0rem !important;
            }

            .nav-tab .nav-link, .nav-tabss .nav-link {
                margin-right: 5px;
                margin-bottom: 7px;
            }
            .custom-switch {
                padding-left: 0rem;
            }
        }
        /* End Custom Switch */

        .display-input-image img {
            height: 60px;
            margin-top: -6px;
        }

    </style>
@endpush
