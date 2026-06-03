<!-- Modal -->
<div class="modal fade" id="showChangeAdStatus" tabindex="-1" role="dialog"
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
                <form id="action" method="post" action="" enctype="multipart/form-data">
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
                                            {{-- @foreach(\App\Library\Enum::getAdStatusType() as $key => $status)
                                                @if ()

                                                @endif
                                                <option value="{{ $status }}" {{ old('status', \App\Library\Enum::AD_STATUS_PENDING)  == $key ? "selected" : "" }}> {{ $status }}
                                                </option>
                                            @endforeach --}}
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
    const showChangeAdStatus = "#showChangeAdStatus";

    function clickUpdateStatus(id) {
        $('#action').attr('action', '/ad-request/' + id + '/status-change');
        $(showChangeAdStatus).modal('show');

        $.each($('.start_date'), function(key, value) {

            if ($(this).parent().children(":first").html() == id) {
                var status = $('#status');
                //var startDate = new Date($(this).html());
                //var endDate = new Date($(this).siblings(".end_date").html());

                // Split the date string into an array [day, month, year]
                var dateParts = $(this).html().split("-");
                // Create a new Date object using the parts (note that month is 0-based in JavaScript Date)
                var startDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);

                var dateParts2 = $(this).siblings(".end_date").html().split("-");
                var endDate = new Date(dateParts2[2], dateParts2[1] - 1, dateParts2[0]);

                var newDate = new Date();

                // Strip the time component from the dates
                startDate.setHours(0, 0, 0, 0);
                endDate.setHours(0, 0, 0, 0);
                newDate.setHours(0, 0, 0, 0);

                if (startDate >= newDate && endDate >= newDate) {
                    status.html(
                        `
                            <option value="" selected disabled>Select One</option>
                            @foreach(\App\Library\Enum::getAdStatusType() as $key => $status)
                                <option value="{{ $status }}" {{ old('status', \App\Library\Enum::AD_STATUS_PENDING)  == $key ? "selected" : "" }}> {{ $status }}</option>
                            @endforeach

                        `
                     );
                } else {
                    status.html(
                        `
                            <option value="" selected disabled>Select One</option>
                            @foreach(\App\Library\Enum::getAdStatusType() as $key => $status)
                                @if ($status != 'Approved')
                                    <option value="{{ $status }}" {{ old('status', \App\Library\Enum::AD_STATUS_PENDING)  == $key ? "selected" : "" }}> {{ $status }}</option>
                                @endif
                            @endforeach

                        `
                     );
                }
            }
        });
    }
</script>
@endpush
