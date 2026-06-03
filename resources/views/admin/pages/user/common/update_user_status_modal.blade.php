<!-- Modal -->
@php $user = $user; @endphp
<div class="modal fade" id="updateUserStatusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span> Change Status </span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.user.update_status.api', $user->id) }}" enctype="multipart/form-data" id="updateUserStatusForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">


                            <label class="col-form-label required" for="name">{{ __('Status') }}</label>
                            <div class="form-group mb-0 @error('status') error @enderror">
                                <select class="form-control" name="status" required>
                                    <option value="" class="selected highlighted">Select Status</option>
                                    @foreach(\App\Library\Enum::getUserStatus() as $index => $value)
                                    <option class="text-capitalize" value="{{ $index }}" {{ $user->status == $index ? "selected" : ""}} >{{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('status')
                                <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <label class="col-form-label required" for="name">{{ __('Note') }}</label>
                            <div class="form-group row @error('note') error @enderror">
                                <div class="col-sm-12">
                                    <textarea type="text" name="note" class="form-control"
                                        placeholder="{{ __('Write Note') }}" rows="6"
                                        required>{{ old('note') }}</textarea>
                                    @error('note')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        {!! \App\Library\Html::btnReset() !!}
                        {!! \App\Library\Html::btnSubmit() !!}
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
