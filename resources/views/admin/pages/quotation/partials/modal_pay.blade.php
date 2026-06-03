<!-- Modal -->

@php
$order_status = \App\Library\Enum::getOrderStatusType();
$paymentMethods = getDropdown(\App\Library\Enum::CONFIG_DROPDOWN_PAYMENT_METHOD);
@endphp

<div class="modal fade" id="showPayModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa-solid fa-money-bill-1 mr-2"></i>
                    {{ __('Make Order') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mx-0 modal-content-row">
                    <div class="col-12 col-md-5 cart-border-right text-center">
                        <div class="horizontal-scroll">
                            <h5 class="text-center mb-4 font-weight-bold"> Order Pay Info</h5>

                            <div class="row mx-0 px-3 py-2 font-weight-bold border-top border-bottom">
                                <div class="col-6 p-0 text-left">
                                    Total
                                </div>
                                <div class="col-6 p-0 text-right">
                                    <span id="total"></span>
                                </div>
                            </div>

                            <div class="row mx-0 px-3 py-2 font-weight-bold border-bottom">
                                <div class="col-6 p-0 text-left">
                                    Paid Amount
                                </div>
                                <div class="col-6 p-0 text-right">
                                    <span id="payed_amount"></span>
                                </div>
                            </div>

                            <div class="row mx-0 px-3 py-2 font-weight-bold border-bottom">
                                <div class="col-6 p-0 text-left">
                                    Due
                                </div>
                                <div class="col-6 p-0 text-right">
                                    <span id="due"></span>
                                </div>
                            </div>

                            <div class="row mx-0 px-3 py-2 font-weight-bold border-bottom">
                                <div class="col-6 p-0 text-left">
                                    Current Collect
                                </div>
                                <div class="col-6 p-0 text-right">
                                    <span id="pay"></span>
                                </div>
                            </div>

                            <div class="row mx-0 px-3 py-2 font-weight-bold border-bottom">
                                <div class="col-6 p-0 text-left">
                                    Current Due
                                </div>
                                <div class="col-6 p-0 text-right">
                                    <span id="current_due"></span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="js-payment" class="col-12 col-md-7">
                        <div>
                            <div>
                                <form method="post" class="form" action="{{ route('admin.quotation.make.order', $order->id)}}" enctype="multipart/form-data">
                                    @csrf

                                    @if ($errors->any())
                                        @foreach ($errors->all() as $error)
                                            <div>{{$error}}</div>
                                        @endforeach
                                    @endif
                                    <input type="hidden" name="total_amount" id="total_amount" value="0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="payments_div">

                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="">
                                                                    <label class="">Amount</label>
                                                                    <input type="number"
                                                                        class="form-control text-right payment"
                                                                        name="amount[]" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="">
                                                                    <label>Transaction Id</label>
                                                                    <input type="number"
                                                                        class="form-control text-right trx_id"
                                                                        name="trx_id[]" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4">
                                                                <div class="">
                                                                    <label class="">Payment Type</label>
                                                                    <select class="form-control" id="payment_type_1"
                                                                        name="payment_type[]" >
                                                                        <option value="" selected disabled>Select One
                                                                        </option>
                                                                        @foreach($paymentMethods as $key =>
                                                                        $paymentMethod)
                                                                        <option value="{{ $paymentMethod }}">
                                                                            {{ $paymentMethod }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <button type="button" class="btn btn-outline-primary btn-fw"
                                                    id="add_payment_row">Add Payment Row
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="">
                                                    <label for="payment_note_1">Note</label>
                                                    <textarea type="text" class="form-control" id="payment_note_1"
                                                        name="payment_note_1" placeholder=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="payment-action">
                                    <div class="row mx-0 mt-2 ">
                                        <div class="col-12 border-top">
                                            <div class="p-3 d-flex justify-content-center">
                                                <button type="submit" class="btn cart-pay-btn">
                                                    <i class="fa fa-check mr-2"></i>
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    const showPayModal = "#showPayModal";

    function clickPay(total, due, id) {

        var payedAmount = total - due;

        $("#total").html(formatPrice(total));
        $("#payed_amount").html(formatPrice(payedAmount));
        $("#due").html(formatPrice(due));
        $("#current_due").html(formatPrice(due));
        $("#pay").html(formatPrice(0));

        // var url = BASE_URL + "/quotations/"+id+"/make/order";
        // $('.form').attr('action', url);

        $(showPayModal).modal('show');
    }

    // Add and remove payment card
    $(document).on('click', '#add_payment_row', function () {
        var whole_extra_item_add = $('#add_iteam').html();
        $('.payments_div').append(whole_extra_item_add);

    });

    $(document).on('click', '.remove', function () {
        $(this).closest('.delete_extra_item').remove();
    });

    $(document).on('keyup change', '.payment', function () {

        var due = <?php echo $order->due_amount; ?>;
        var amount = calculate_payments();

        if(amount > due) {
            $(this).val(0);
            amount = calculate_payments();
        }

        $("#pay").html(formatPrice(amount));
        $("#total_amount").val(amount);
        $("#current_due").html(formatPrice(due-amount));
    });

    function calculate_payments() {
        var amount =0;
        $(".payments_div .payment").each(function (e) {
            amount = amount + parseFloat(this.value ? this.value : 0);
        });
        return amount;

    }

</script>
@endpush

<div class="d-none" id="add_iteam">
    <div class="col-md-12  delete_extra_item mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex flex-row-reverse">
                    <button type="button" class="btn btn-box-tool mt-n4 m-3 remove"><i
                            class="fa fa-times fa-2x"></i></button>
                </div>
                <div class="row mt-n4">
                    <div class="col-md-4">
                        <div class="">
                            <label class="required">Amount</label>
                            <input type="number" class="form-control text-right payment" name="amount[]" placeholder=""
                           required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="">
                            <label>Transaction Id</label>
                            <input type="number" class="form-control text-right trx_id" name="trx_id[]" placeholder="">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="">
                            <label class="required">Payment Type</label>
                            <select class="form-control"
                                name="payment_type[]" required>
                                <option value="" selected disabled>Select One</option>
                                @foreach($paymentMethods as $key =>$paymentMethod)
                                <option value="{{ $paymentMethod }}">
                                    {{ $paymentMethod }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
