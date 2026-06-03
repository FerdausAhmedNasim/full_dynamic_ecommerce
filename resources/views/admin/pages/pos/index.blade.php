@extends('admin.layouts.master')
@section('title', 'Pos')

@section('content')

<div class="content-wrapper">
    <Pos :invoice-logo="'{{ settings('invoice_logo') ? asset(settings('invoice_logo')) : Vite::asset(App\Library\Enum::NO_IMAGE_PATH) }}'" />
</div>

@stop

@include('admin.assets.quantity-change-input')

@push('scripts')
@vite('resources/admin_assets/js/pages/pos/index.js')
@endpush
