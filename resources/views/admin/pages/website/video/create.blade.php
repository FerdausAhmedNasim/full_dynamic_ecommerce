<div class="col-md-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4>Add New Video</h4>
            <hr>
            <form method="post" action="{{ route('admin.website.video.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-2">
                            <div class="form-group @error('link') error @enderror">
                                <label class="required">{{ __('Link') }}</label>
                                <div class="">
                                    <input type="text" class="form-control" name="link"
                                        value="{{ old('link') }}"
                                        placeholder="{{ __('Link') }}" required>
                                    @error('link')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="modal-footer justify-content-center col-md-12">
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>