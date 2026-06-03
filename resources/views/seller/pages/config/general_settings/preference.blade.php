@extends('admin.pages.config.general_settings.layout.master')
@section('title', 'Preference')
@section('preference', 'active')

@section('settingsContent')
<div class="section-title mb-4 bar-before-title fw-bold">Preference</div>
<div class="table-responsive">
    <table class="table table-bordered table-md">
        <tbody class="text-center">

            <tr>
                <td>
                    {{ __('Seller Product Auto Approve') }}
                </td>

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
                <td>
                    {{ __('Stock Out Product Hide') }}
                </td>

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
                <td>
                    {{ __('Guest Checkout') }}
                </td>

                <td width="300">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                    onchange="changeStatus(event, '{{ route('admin.website.setting.update.status', 'guest_checkout') }}' )"
                                    class="custom-control-input" id="guest_checkout"
                                    {{ settings('guest_checkout') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="guest_checkout"></label>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    {{ __('Show Product SKU') }}
                </td>

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
                <td>
                    {{ __('Show Weight') }}
                </td>

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
                <td>
                    {{ __('Show Category') }}
                </td>

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
                <td>
                    {{ __('Show Review') }}
                </td>

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
                <td>
                    {{ __('Show Ratting') }}
                </td>

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
                <td>
                    {{ __('Allow Guest Review') }}
                </td>

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
                <td>
                    {{ __('Back Order') }}
                </td>

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
        </tbody>
    </table>
</div>
@stop

@push('scripts')
<script>
    window.changeStatus = function (e, route) {
        e.preventDefault();
        confirmFormModal(route, 'Confirmation', 'Are you sure Update Status.');
        table.ajax.reload();
    }
</script>
@endpush