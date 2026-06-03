<!-- Modal -->

@php
    $order_status = \App\Library\Enum::getOrderStatusType();
@endphp

<div class="modal fade" id="showChangeOrderStatus" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span> Change Status </span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.quotation.change_status', $order->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="assign_id" id="assign_id">
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
                                            @foreach($order_status as $key => $status)
                                                <option value="{{ $status }}" {{ old('status',$order?->order_status)  == $key ? "selected" : "" }}> {{ $status }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('note') error @enderror">
                                    <label class="col-sm-3 col-form-label required" for="name">{{ __('Note') }}</label>
                                    <div class="col-sm-9">
                                        <textarea type="text" name="note" class="form-control"
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
    const showChangeOrderStatus = "#showChangeOrderStatus";

    function clickUpdateStatus() {
        $(showChangeOrderStatus).modal('show');
    }
</script>
@endpush
