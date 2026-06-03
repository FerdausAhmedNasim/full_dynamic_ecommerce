@extends('admin.layouts.master')

@section('title', 'Quotation')

@section('content')

<div class="content-wrapper">
    <Quotation />
</div>

@stop
@include('admin.assets.quantity-change-input')
@push('scripts')
@vite('resources/admin_assets/js/pages/pos/quotation.js')
@endpush