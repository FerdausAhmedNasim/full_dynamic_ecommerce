<div class="row">
    <div class="col-12">
        <h6>
            Roles: {{ $user->roles->pluck('name')->implode(', ') }}
        </h6>
        <hr>

        <form method="post" action="{{ route('seller.moderator.security.update', $employee->id) }}" enctype="multipart/form-data">
            @csrf

            @if(auth()->user()->role()->slug != \App\Library\Enum::USER_TYPE_MODERATOR)
            <hr>

            <div class="form-group row @error('role_id') error @enderror">
                <label class="col-sm-3 col-form-label required">{{ __('Role') }}</label>
                <div class="col-sm-9">
                    <select class="form-control select2" name="role_id[]" id="role_id" multiple required>
                        @foreach($roles as $value)
                            <option value = "{{ $value->id }}" {{(old("role_id") == $value->id) ? "selected" : ""}}>
                                {{ $value->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            @endif

            <div class="row">
                <div class="modal-footer justify-content-center col-md-12">
                    {!! \App\Library\Html::btnReset() !!}
                    {!! \App\Library\Html::btnSubmit() !!}
                </div>
            </div>
        </form>
    </div>
</div>

@include('admin.assets.select2')
@push('scripts')

<script>
    $(document).ready(function () {
        $("#role_id").select2({
            placeholder: "Select One",
            allowClear: true
        });

        var roles = <?php echo $user->getRole() ?> ;

        var roleArr = [];
        $.each(roles, function(index, row) {
            roleArr.push(row.id)
        });

        $('#role_id').val(roleArr).trigger("change");
    });
</script>

@endpush
