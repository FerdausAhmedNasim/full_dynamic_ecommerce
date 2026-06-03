@extends('admin.layouts.master')
@section('title', 'Receive Money Create')
@section('receiveMoney', 'active')

@section('content')

@php
    $paymentMethods = getDropdown(\App\Library\Enum::CONFIG_DROPDOWN_PAYMENT_METHOD);
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Receive Money Create' )) }}</h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.user.seller.partials.topbar', ['user', $user??''])
    </div>
    <!-- TabMenu End -->

    <div class="card shadow-sm col-lg-8  col-md-12 mt-3">
        <div class="card-body py-sm-4">
            <form method="post" class="form" action="{{ route('admin.user.seller.receive.money.create', $user->id??'') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="p-sm-3">
                    <div class="form-group row @error('commission_rate') error @enderror">
                        <label class="col-sm-3 col-form-label required"
                            for="commission_rate">{{ __('Current Balance') }}</label>
                        <div class="col-sm-9">
                            <input type="number" readonly class="form-control" name="commission_rate" value="{{ $user->balance }}"
                            placeholder="{{ __('Commission Rate') }}" required>
                            @error('commission_rate')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('amount') error @enderror">
                        <label class="col-sm-3 col-form-label required"
                            for="amount">{{ __('Top Up Amount') }}</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="amount" value="{{ old('amount') }}"
                            placeholder="{{ __('Top Up Amount') }}" required>
                            @error('amount')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('note') error @enderror">
                        <label class="col-sm-3 col-form-label required"
                            for="note">{{ __('Note') }}</label>
                        <div class="col-sm-9">
                            <textarea type="number" class="form-control" name="note"
                            placeholder="{{ __('Note') }}" required> {{ old('note') }}</textarea>
                            @error('note')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        {{-- <label class="col-sm-3 col-form-label"
                            for="amount">{{ __('Payment Method') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="payment_method" value="{{ old('payment_method') }}"
                            placeholder="{{ __('Payment Method') }}">
                        </div> --}}
                        <label class="col-sm-3 col-form-label required">Payment Type</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="payment_type_1"
                                name="payment_method" required>
                                <option value="" selected disabled>
                                    Select One
                                </option>
                                @foreach ($paymentMethods as $key => $paymentMethod)
                                    <option value="{{ old('payment_method', $paymentMethod) }}">
                                        {{ $paymentMethod }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label"
                            for="amount">{{ __('Transaction Id') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="transaction_id" value="{{ old('transaction_id') }}"
                            placeholder="{{ __('Transaction Id') }}">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@stop
@include('admin.assets.select2')
