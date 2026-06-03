<div class="modal" id="ezzicoDiscount" tabindex="-1" role="dialog" aria-labelledby="ezzicoDiscount" aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ezzicoDiscount"> <span>Add Ezzico Discount</span> </h5>
                <button type="button" class="close" onclick="closeModal()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.product.add_ezzico_discount') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-sm-3">
                                <input type="hidden" id="product_id" name="product_id">
                                <input type="hidden" value="{{authUser()->id}}" name="operator_id">
                                <div class="form-group row @error('ezzico_discount') error @enderror">
                                    <label class="col-12 col-form-label required" for="name">{{ __('Discount')
                                        }}</label>
                                    <div class="col-12">
                                        <input type="hidden" id="fromDate" value="" name="start_date">
                                        <input type="hidden" id="toDate" value="" name="end_date">
                                        <div class="input-group with-icon">
                                            <input type="text" name="date_range" class="form-control"
                                                id="daterangepicker-for-discount"
                                                value="{{ old('start_date') && old('end_date') ? App\Library\Helper::dateRange(old('start_date'), old('end_date')) : null }}"
                                                style="border-radius: 4px; background: #fff; color: #000;"
                                                placeholder="{{ inputDateFormat() }} - {{ inputDateFormat() }}" required />
                                            <i class="date-icon fa-solid fa-calendar-days"></i>
                                        </div>
                                        @error('ezzico_discount')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>