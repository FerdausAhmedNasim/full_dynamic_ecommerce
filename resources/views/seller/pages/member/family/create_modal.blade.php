<!-- Modal -->
<div class="modal fade" id="addNewFamilyMember" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-m" role="document">
        <form method="post" action="{{ route('seller.member.family.store', $member->id) }}" enctype="multipart/form-data" id="updateStatusForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('Add New Client to Family') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="mb-2 @error('related_client_id') error @enderror">
                        <label class="col-form-label required" for="related_client_id">{{ __('Client') }}</label>
                        <select class="form-control" name="related_client_id" required>
                            <option value="" class="selected highlighted">Select One</option>
                            @foreach($getMembers as $key => $member)
                                <option value="{{ $member?->user?->id }}" >
                                    {{ $member->user?->full_name }} --- {{ $member?->user?->phone }}
                                </option>
                            @endforeach
                        </select>
                        @error('related_client_id')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-2 @error('note') error @enderror">
                        <label class="col-form-label required" for="note">{{ __('Note') }}</label>
                        <textarea class="form-control" id="summernote" name="note" required>{{ old('note') }}</textarea>

                        @error('note')
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
