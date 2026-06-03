<!-- Modal -->
<div class="modal fade" id="updateImmunizationModal" tabindex="-1" role="dialog" aria-labelledby="referralModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

      <form id="updateImmunizationForm" onsubmit="updateImmunization(event, this)">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="referralModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="immunization_id" value="{{ $immunization->id }}">

                <div class="form-group" id="statusField">
                    <label class="required" for="name">{{ __('Status') }}</label>
                    <select class="form-control" name="status" id="status" required>
                        <option class="text-capitalize" value="" class="selected highlighted">Select One</option>
                        @foreach($status as $key => $st)
                        <option class="text-capitalize" value="{{ $key }}"
                            {{(old("status", $immunization->status) == $key) ? "selected" : ""}}> {{ $st }} </option>
                        @endforeach
                    </select>
                    <small class="form-text error-message"></small>
                </div>

                <div class="form-group">
                    <label class="required" for="notes">{{ __('Note') }}</label>
                    <textarea type="text" class="form-control" name="notes" rows="4"
                        placeholder="Note" id="notes" required></textarea>
                    <small class="form-text error-message"></small>
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn2-light-secondary mr-3" data-dismiss="modal"><i class="fas fa-times"></i> {{ __('Close') }}</button>
                <button type="submit" class="btn btn2-secondary"><i class="fas fa-save"></i> {{ __('Save') }} </button>
            </div>

        </div>
      </form>

    </div>
</div>
