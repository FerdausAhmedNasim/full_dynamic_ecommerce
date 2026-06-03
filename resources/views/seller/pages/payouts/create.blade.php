<!-- Modal -->
<div class="modal fade" id="createPayoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
    aria-hidden="true">
    <div class="modal-dialog" role="document">

        <form id="createPayoutForm" onsubmit="storePayout(event, this)"
            action="{{ route('seller.payout.store') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1"> {{ __('Send Payout Request') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="required">{{ __('Current Balance') }}</label>
                        <input type="number" readonly name="current_balance" value="{{ authSeller()->balance }}" class="form-control" placeholder="Enter Amount" required>
                        <small class="form-text error-message"></small>
                    </div>
                    <div class="form-group">
                        <label class="required">{{ __('Amount') }}</label>
                        <input name="amount" type="number" step="any" min="0" class="form-control" placeholder="Enter Amount" id="createAmount" required>
                        <small class="form-text error-message"></small>
                    </div>
                    <div class="form-group">
                        <label class="required">{{ __('Note') }}</label>
                        <textarea name="note" class="form-control" rows="10" id="createNote" required></textarea>
                        <small class="form-text error-message"></small>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn2-light-secondary mr-3" data-dismiss="modal"><i
                            class="fas fa-times"></i> {{ __('Close') }}</button>
                    <button type="submit" class="btn btn2-secondary"><i class="fas fa-save"></i> {{ __('Send') }}
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
