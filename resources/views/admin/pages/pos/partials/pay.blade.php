<!-- Modal -->
<div class="modal fade" id="pay" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fa-solid fa-money-bill-1 mr-2"></i>
                    {{ __('Make Payment') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mx-0 modal-content-row">
                    <div class="col-12 col-md-6 cart-border-right text-center">
                        <div class="horizontal-scroll">
                            <h5 class="text-center mb-4">Sales Details</h5>
                            <div class="invoiceLogo text-center"><img
                                    src="https://pos.gainhq.com/uploads/logo/default-logo.png" width="100" alt=""
                                    class="img-fluid"></div>
                            <div>
                                <div class="text-center header-line-height">
                                    <small class="text-center font-weight-bold">
                                        POS
                                    </small>
                                    <br>
                                    <small class="text-center">
                                        2023-11-25
                                    </small>
                                    <br>
                                    <small class="text-center">
                                        Sales Receipt
                                    </small>
                                    <br>
                                    <small class="text-left">
                                        Sold By: John Doe
                                    </small>
                                    <br>
                                    <small>
                                        <span>
                                            <span>
                                                Sold To: Walk-in customer
                                            </span>
                                        </span>
                                    </small>
                                    <small class="text-left invoice-show" style="display: none;">
                                        Invoice Number:
                                    </small>
                                </div>

                                <div class="invoice-table">
                                    <table class="table product-card-font">
                                        <thead class="border-top-0">
                                            <tr>
                                                <th class="cart-summary-table text-left">
                                                    Items
                                                </th>
                                                <th class="cart-summary-table text-center">Qty</th>
                                                <th class="cart-summary-table text-right">Price</th>
                                                <th class="cart-summary-table text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="cart-summary-table text-left">
                                                    Cotton Black T-shirt
                                                    <br> <span>( Black,S )</span>

                                                </td>
                                                <td class="cart-summary-table">
                                                    2.00
                                                </td>
                                                <td class="text-right cart-summary-table">
                                                    $550.00
                                                </td>

                                                <td class="text-right cart-summary-table">
                                                    $990.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="cart-summary-table text-left">
                                                    Male Red T-shirt
                                                    <br>
                                                    <!---->
                                                    <!---->
                                                </td>
                                                <td class="cart-summary-table">
                                                    10.00
                                                </td>
                                                <td class="text-right cart-summary-table">
                                                    $550.00
                                                </td>

                                                <td class="text-right cart-summary-table">
                                                    $4,950.00
                                                </td>
                                            </tr>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3" class="cart-summary-table font-weight-bold text-left">
                                                    Sub Total
                                                </td>
                                                <td class="text-right cart-summary-table">$8,865.00
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="cart-summary-table font-weight-bold text-left">
                                                    Total
                                                </td>
                                                <td class="text-right cart-summary-table ">$8,865.00
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3" class="cart-summary-table font-weight-bold text-left">
                                                    Due
                                                </td>
                                                <td class="text-right cart-summary-table">$0.00</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary mt-4 ms-2"><i class="ti-printer mr-2"></i> Print</a>
                    </div>


                    <div id="js-payment" class="col-12 col-md-6">
                        <div>
                            <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="payments_div">

                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="">
                                                                    <label>Amount</label>
                                                                    <input type="number"
                                                                        class="form-control text-right payment"
                                                                        name="amount[]" placeholder=""
                                                                        onkeyup="calculate_payments()">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="">
                                                                    <label>Payment Type</label>
                                                                    <select class="form-control" id="payment_type_1"
                                                                        name="payment_type_1">
                                                                        <option value="Cash">Cash</option>
                                                                        <option value="Card">Card</option>
                                                                        <option value="bank">Bank</option>
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
                                <div id="js-payment-action" class="payment-action">
                                    <div class="row mx-0 mt-2 no-gutters">
                                        <div class="col-12">
                                            <hr class="custom-margin"> <span>
                                                <div class="p-3 d-flex justify-content-center">
                                                    <a href="#" class="btn cart-pay-btn">
                                                        <i class="fa fa-check mr-2"></i>
                                                        Done Payment
                                                    </a>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-none" id="qus_col">
    <div class="col-md-12  delete_extra_item mt-2">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex flex-row-reverse">
                    <button type="button" class="btn btn-box-tool mt-n3 remove"><i
                            class="fa fa-times fa-2x"></i></button>
                </div>
                <div class="row mt-n3">
                    <div class="col-md-6">
                        <div class="">
                            <label>Amount</label>
                            <input type="number" class="form-control text-right payment" name="amount[]" placeholder=""
                                onkeyup="calculate_payments()">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <label>Payment Type</label>
                            <select class="form-control" id="payment_type_1" name="payment_type_1">
                                <option value="Cash">Cash</option>
                                <option value="Card">Card</option>
                                <option value="bank">Bank</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>