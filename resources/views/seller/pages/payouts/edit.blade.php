<!-- Modal -->
<div class="modal fade" id="updatePayoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="updatePayoutForm" onsubmit="updatePayout(event, this)">
        <input type="hidden" name="id" value="" id="payoutId">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2"> {{ __('Update Payout Request') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>{{ __('Amount') }}</label>
              <input name="amount" type="number" step="any" min="0" class="form-control" id="updateAmount" placeholder="Enter Amount" required>
              <small class="form-text error-message"></small>
            </div>
            <div class="form-group">
                <label>{{ __('Amount') }}</label>
                <textarea name="note" class="form-control" rows="10" id="updateNote"></textarea>
                <small class="form-text error-message"></small>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn2-light-secondary mr-3" data-dismiss="modal"><i class="fas fa-times"></i> {{ __('Close') }}</button>
            <button type="submit" class="btn btn2-secondary"><i class="fas fa-save"></i> {{ __('Update') }} </button>
          </div>
        </div>
      </form>
  
    </div>
  </div>
  