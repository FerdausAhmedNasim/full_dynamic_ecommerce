@extends('admin.layouts.master')

@section('title', __('New Withdraw'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.withdraw.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('New Withdraw')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm col-md-8">
        <div class="card-body py-sm-4">
            <form method="post" class="form" action="{{ route('admin.withdraw.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('amount') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Amount') }}</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="amount" id="amount" value="{{ old('amount') }}" step="any"
                                        placeholder="{{ __('Amount') }}" required>
                                    @error('amount')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                    <p class="text-danger d-none mt-2" id="amount_show"></p>
                                </div>
                            </div>

                            <div class="form-group row @error('note') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Note') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" rows="10" class="form-control" name="note"
                                        placeholder="{{ __('Note') }}" required>{{ old('note') }}</textarea>
                                    @error('note')
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
@stop

@include('admin.assets.select2')

@push('scripts')
@vite('resources/admin_assets/js/pages/withdraw/create.js')
@endpush
