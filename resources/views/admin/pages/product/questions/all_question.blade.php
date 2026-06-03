@extends('admin.layouts.master')

@section('title', 'All Questions')

@section('content')

<div class="content-wrapper">
    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('All Questions' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="questionDataTable" class="table table-bordered ticket-data-table">
                <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Question</th>
                        <th>Status</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    {{-- <input type="hidden" id="product_id" value="{{ $product->id }}"> --}}
</div>

@include('admin.pages.product.questions.answer')
@include('admin.pages.product.questions.showModal')

@stop

@include('admin.assets.dt')
@include('admin.assets.dt-buttons')
@include('admin.assets.dt-buttons-export')

@push('scripts')
@vite('resources/admin_assets/js/pages/product/questions/questions.js')
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