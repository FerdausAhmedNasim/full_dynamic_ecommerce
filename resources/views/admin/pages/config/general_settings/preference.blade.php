@extends('admin.pages.config.general_settings.layout.master')
@section('title', 'Preference')
@section('preference', 'active')

@section('settingsContent')
<div class="section-title mb-4 bar-before-title fw-bold">Preference</div>

    <div class="row">
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tbody>
            
                        <tr>
                            <td> {{ __('Allow Guest Checkout') }} </td>
                            <td width="200" class="text-center">
                                <label class="custom-switch" for="guest_checkout">
                                    <input type="checkbox"
                                        onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'guest_checkout') }}', this)"
                                        class="custom-switch-input" id="guest_checkout"
                                        {{ settings('guest_checkout') ? 'checked' : '' }}
                                    >
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td>
                        </tr>
            
                        <tr>
                            <td> {{ __('Full Payment') }} </td>
                            <td width="200" class="text-center">
                                <label class="custom-switch" for="full_payment">
                                    <input type="checkbox"
                                        onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'full_payment') }}', this)"
                                        class="custom-switch-input" id="full_payment"
                                        {{ settings('full_payment') ? 'checked' : '' }}
                                    >
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td>
                        </tr>
            
                        @if (! settings('full_payment'))
                            <tr>
                                <td> {{ __('No Cost / Only Shipping Cost') }} </td>
                                <td width="200" class="text-center">
                                    <label class="custom-switch" for="advance_shipping_cost">
                                        <input type="checkbox"
                                            onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'advance_shipping_cost') }}', this)"
                                            class="custom-switch-input" id="advance_shipping_cost"
                                            {{ settings('advance_shipping_cost') ? 'checked' : '' }}
                                        >
                                        <span class="custom-switch-indicator"></span>
                                    </label>
                                </td>
                            </tr>
                        @endif
            
                        @if (false)
                            <tr>
                                <td> {{ __('Seller Product Auto Approve') }} </td>
                                <td width="300">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'seller_product_auto_approve') }}' )"
                                                    class="custom-control-input" id="seller_product_auto_approve"
                                                    {{ settings('seller_product_auto_approve') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="seller_product_auto_approve"></label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Stock Out Product Hide') }}</td>
                                <td width="300">
                                    <div class="form-group row @error('stock_out_product_hide') error @enderror">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'stock_out_product_hide') }}' )"
                                                    class="custom-control-input" id="stock_out_product_hide"
                                                    {{ settings('stock_out_product_hide') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="stock_out_product_hide"></label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Show Product SKU') }}</td>
                                <td width="300">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'show_sku') }}' )"
                                                    class="custom-control-input" id="show_sku"
                                                    {{ settings('show_sku') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="show_sku"></label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Show Weight') }}</td>
                                <td width="300">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'show_weight') }}' )"
                                                    class="custom-control-input" id="show_weight"
                                                    {{ settings('show_weight') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="show_weight"></label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Show Category') }}</td>
                                <td width="300">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'show_category') }}' )"
                                                    class="custom-control-input" id="show_category"
                                                    {{ settings('show_category') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="show_category"></label>
                                            </div>
                
                                            @error('title')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Show Review') }}</td>
                                <td width="300">
                                    <div class="form-group row @error('show_review') error @enderror">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'show_review') }}' )"
                                                    class="custom-control-input" id="show_review"
                                                    {{ settings('show_review') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="show_review"></label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Show Ratting') }}</td>
                                <td width="300">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'show_ratings') }}' )"
                                                    class="custom-control-input" id="show_ratings"
                                                    {{ settings('show_ratings') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="show_ratings"></label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Allow Guest Review') }}</td>
                                <td width="300">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'allow_guest_review') }}' )"
                                                    class="custom-control-input" id="allow_guest_review"
                                                    {{ settings('allow_guest_review') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="allow_guest_review"></label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('Back Order') }}</td>
                                <td width="300">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox"
                                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'back_order') }}' )"
                                                    class="custom-control-input" id="back_order"
                                                    {{ settings('back_order') ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="back_order"></label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@stop

@push('scripts')
<script>
    window.changeStatus = function (e, route, checkbox) {
        e.preventDefault();

        const isChecked = checkbox.checked;
        checkbox.checked = !isChecked;

        confirmFormModal(route, 'Confirmation', 'Are you sure you want to update the status?', 'Confirm', 'Cancel', function(confirmed) {
            if (confirmed) {
                checkbox.checked = isChecked;
            } else {
                checkbox.checked = !isChecked;
            }
        });

        // confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
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
</style>
@endpush