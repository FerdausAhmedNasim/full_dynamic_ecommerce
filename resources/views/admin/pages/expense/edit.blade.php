@extends('admin.layouts.master')

@section('title', __('Update Expense'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.expense.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Expense')) }}</h4>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.expense.update', $expense->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <input type="hidden" name="user_type" value="{{ $user_type }}">

                            <div class="form-group row @error('category') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Category') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="category" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ (old("category", $expense->category) == $category) ? "selected" : "" }}>
                                            {{ $category }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('title') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Title') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $expense->title) }}"
                                        placeholder="{{ __('Title') }}" required>
                                    @error('title')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-sm-3">

                            <div class="form-group row @error('amount') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Amount') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="amount" value="{{ old('amount', $expense->amount) }}"
                                        placeholder="{{ __('Amount') }}" step="0.01" required>
                                    @error('amount')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row @error('note') error @enderror">
                                <label class="col-sm-3 col-form-label">{{ __('Notes') }}</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control" name="note" placeholder="{{ __('Notes') }}" rows="10"> {{ old('note', $expense->note) }} </textarea>
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
@vite('resources/admin_assets/js/select2.js')
@endpush
