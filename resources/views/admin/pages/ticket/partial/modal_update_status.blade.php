<!-- Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="post" action="{{ route('admin.ticket.change_status',$ticket->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('Status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <label class="required" for="name">{{ __('Status ') }}</label>
                    <div class="form-group mb-0 @error('status') error @enderror">
                        <select class="form-control" name="status" required>
                            <option value="" class="selected highlighted">Select Status</option>

                            @foreach(\App\Library\Enum::getTicketStatus() as $index => $value)
                                <option class="text-capitalize" value="{{ $index }}"
                                    {{ $ticket->status == $index ? "selected" : ""}}>
                                    {{ $value }}
                                </option>

                            @endforeach

                        </select>
                        @error('status')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="required mt-3" for="name">{{ __('Note ') }}</label>
                    <div class="form-group mb-0 @error('notes') error @enderror">

                        <textarea type="text" id="note" class="form-control todo-list-input" name="notes" rows="6"
                            placeholder="Add Note" required>{{ old('notes') }}</textarea>
                        @error('notes')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer justify-content-center">
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>
            </div>
        </form>

    </div>
</div>
