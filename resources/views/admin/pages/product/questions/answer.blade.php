<!-- Modal -->
<div class="modal fade" id="answerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form id="answerForm" onsubmit="storeAnswer(event, this)">

        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2"> {{ __('Answers') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" value="" id="question_id">
            <input type="hidden" name="product_id" value="" id="product_id">
            <div class="form-group">
              <label class="required">{{ __('Question') }}</label>
              <input name="question" type="text" class="form-control" id="question" required readonly>
              <small class="form-text error-message"></small>
            </div>
            <div class="form-group">
                <label class="required">{{ __('Answer') }}</label>
                <textarea name="answer" class="form-control" rows="10" id="answer" required></textarea>
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
  