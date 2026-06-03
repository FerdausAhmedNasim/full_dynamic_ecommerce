<!-- Modal -->
<div class="modal fade" id="updateReferralModal" tabindex="-1" role="dialog" aria-labelledby="referralModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">

      <form id="updateReferralForm" onsubmit="updateReferral(event, this)">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="referralModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="referral_id" value="{{ $referral->id }}">

                <div class="form-group" id="statusField">
                    <label class="required" for="name">{{ __('Status') }}</label>
                    <select class="form-control" name="status" id="status" required>
                        <option value="" class="selected highlighted">Select One</option>
                        @foreach(\App\Library\Helper::getAvailableReferralStatus($referral->status) as $key => $value)
                        
                            <option value="{{ $key }}"
                                {{(old("status", $referral->status) == $key) ? "selected" : ""}}> {{ ucwords($value) }} 
                            </option>
                          
                        @endforeach
                    </select>
                    <small class="form-text error-message"></small>
                </div>

                <div class="form-group d-none" id="declinedField">
                    <label class="required" for="declined_by">{{ __('Declined By') }}</label>
                    <select class="form-control" name="declined_by" id="declinedBy">
                        <option value="" class="selected highlighted">Select One</option>
                        @foreach(\App\Library\Enum::getReferralDeclinedBy() as $key => $value)
                        <option value="{{ $key }}"
                            {{(old("status", $referral->declined_by) == $key) ? "selected" : ""}}> {{ ucwords($value) }} </option>
                        @endforeach
                    </select>
                    <small class="form-text error-message"></small>
                </div>

                <div class="form-group" id="rereferEmployeeField">
                    <label class="required" for="name">{{ __('Refer To') }}</label>
                    <select class="form-control" name="refer_to" id="refer_to" required>
                        <option value="" class="selected highlighted">Select One</option>
                        @foreach($users as $user)
                        <option value="{{ $user->employee->id }}"
                            {{(old("refer_to", $referral->refer_to) == $user?->employee->id) ? "selected" : ""}}> {{ $user?->full_name }} </option>
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
