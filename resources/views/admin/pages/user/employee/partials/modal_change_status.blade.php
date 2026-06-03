<!-- Modal -->
<div class="modal fade" id="showChangeStockStatusModal234" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span> Change Status</span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="stock_id" id="stock_id">
                    <input type="hidden" name="stock_assign_id" id="stockAssign">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-sm-3">

                                <div class="form-group row @error('status') error @enderror">
                                    <label class="col-sm-3 col-form-label required"
                                        for="name">{{ __('Status') }}</label>
                                    <div class="col-sm-9">
                                        <select class="select form-control" name="status" id="status"
                                            style="width: 100%;" required>
                                            <option value="" selected disabled>Select One</option>
                                            @foreach($stock_status as $key => $status)
                                                @if($key != App\Library\Enum::STOCK_AVAILABLE && $key != App\Library\Enum::STOCK_OUT)
                                                <option value="{{ $key }}" {{ $key == App\Library\Enum::STOCK_ASSIGNED ? 'disabled' : '' }}
                                                    {{ old('status') == $key ? "selected" : "" }}>
                                                    {{ $status }}
                                                </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div id="quanDiv" class="form-group row @error('quantity') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="name">{{ __('Quantity') }}</label>
                                    <div class="col-sm-9">
                                        <input type="number" name="quantity" value="{{ old('quantity') }}" class="form-control quantity" id="quantity">
                                        @error('quantity')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                        <span class="text-danger d-none" id="quanError">Desire quantity not available</span>
                                    </div>
                                </div>

                                <div class="form-group row @error('note') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="name">{{ __('Note') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="note" class="form-control" id="note"
                                            placeholder="{{ __('Write Note') }}"
                                            rows="4" required>{{ old('note') }}</textarea>
                                        @error('note')
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

@push('scripts')
<script type="text/javascript">
    const showChangeStockStatusModal = "#showChangeStockStatusModal234";

    let assignQuantity;

    function openChangeStockStatusModal(stockId, stockAssign, status, quantity, entryType) {
        $("#status").val(status);
        $("#stock_id").val(stockId);
        $("#stockAssign").val(stockAssign);
        // $("#quantity").val(quantity);

        assignQuantity = quantity;

        if (entryType == 1) {
            $("#quanDiv").addClass('d-none');
            $("#quantity").prop('required',false);
        } else {
            $("#quanDiv").removeClass('d-none');
            $("#quantity").prop('required',true);
        }

        $(showChangeStockStatusModal).modal('show');

        $("form").submit(function (e) {

            e.preventDefault();

            let url = BASE_URL + '/users/employees/' + stockId + '/stock/status/change';

            var form_data = {
                status: $("#status").val(),
                note: $("#note").val(),
                stockAssign: $("#stockAssign").val(),
                quantity: $("#quantity").val(),
            };

            loading('show');

            axios.post(url, form_data)
                .then(response => {
                    $("#showChangeStockStatusModal234").modal('hide');
                    notify(response.data.message, 'success', function (){
                        location.reload();
                    });
                })
                .catch(error => {
                    const response = error.response;
                    if (response) {
                        // notify(response.data.message, 'error');
                        notify(response.data.message, 'error', function (){
                            location.reload();
                        });
                    }
                })
                .finally(() => {
                    loading('hide');
                });

            $("#status").val('');
            $("#note").val('');
            $("#stockAssign").val('');
        });
    }

    $(document).ready(function () {
        $(".quantity").on('change', function () {
            let quan = $("#quantity").val();

            if (quan > assignQuantity || quan < 1) {
                $("#quanError").removeClass('d-none');
                $("#quantity").val('');
            } else {
                $("#quanError").addClass('d-none');
            }
        });
    });

</script>
@endpush
