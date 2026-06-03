<!-- Modal -->
<div class="modal fade" id="editClientAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <form method="post" action="" enctype="multipart/form-data" id="editClientAlertForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{ __('Edit Client Alert') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0 @error('alert_id') error @enderror">
                        <select class="form-control" name="alert_id" id="alert_id" required>
                            <option value="" class="selected highlighted">Select One</option>
                            @foreach($alerts as $key => $value)
                            <option value="{{ $value->id }}" >{{ ucwords($value->name) }}</option>
                            @endforeach
                        </select>
                        @error('alert_id')
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