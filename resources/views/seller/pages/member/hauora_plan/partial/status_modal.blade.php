<!-- Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

      <form id="updateStatusForm" onsubmit="updateStatus(event, this)">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Change Status') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="hauora_plan_id" value="{{ $hauoraPlan->id }}">

                <div class="form-group">
                    <label class="required" for="status">{{ __('Status') }}</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="" class="selected highlighted">Select One</option>
                        @foreach(\App\Library\Enum::getHauoraPlanStatus() as $key => $value)
                        <option value="{{ $key }}"
                            {{(old("status", $hauoraPlan->status) == $key) ? "selected" : ""}}> {{ ucwords($value) }} </option>
                        @endforeach
                    </select>
                    <small class="form-text error-message"></small>
                </div>
                <div class="form-group">
                    <label class="required" for="note">{{ __('Note') }}</label>
                    <textarea type="text" class="form-control" name="notes" rows="4"
                        placeholder="Note" id="note" required>{{ old('notes') }}</textarea>
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
