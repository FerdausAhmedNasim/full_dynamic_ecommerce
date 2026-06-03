@extends('admin.layouts.master')

@section('title', __('Update Family'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('admin.member.family.list')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Family')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm col-md-6">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.member.family.update', $family->id) }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $family->id }}">
                <input type="hidden" name="related_client_id" value="{{ $family->related_client_id }}">
                <div class="p-sm-3">

                    <div class="form-group row @error('related_client_id') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="related_client_id">{{ __('Family Member') }}</label>
                        <div class="col-sm-9">
                            <select class="browser-default custom-select " name="related_client_id" id="related_client_id" style="width: 100%;" required>
                                <option value="{{ $family->related_client_id }}" disabled selected>{{ $family->related?->full_name }}</option>
                            </select>
                            @error('related_client_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('family_id') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="family_id">{{ __('Family ID') }}</label>
                        <div class="col-sm-9">

                            <select class="browser-default custom-select" name="family_id" id="family_id" style="width: 100%;" required>
                                <option selected disabled value="">Select One</option>
                                @foreach($familyIds as $familyid)
                                    <option value="{{ $familyid }}" {{ old('family_id', $family->family_id)  == $familyid ? "selected" : "" }}>{{ $familyid }}</option>
                                @endforeach
                            </select>

                            @error('family_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('note') error @enderror">
                        <label class="col-sm-3 col-form-label required" for="note">{{ __('Note') }}</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="note" class="form-control"
                                placeholder="{{ __('Write Note') }}" rows="3" required>{{ old('note', $family->note) }}</textarea>
                            @error('note')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
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
@stop

@push('scripts')
@endpush
