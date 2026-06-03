@extends('admin.layouts.master')

@section('title', __('Update Ad Location'))

@section('content')
<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.ad.location.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Ad Location')) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('admin.ad.location.update', $adLocation->id) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-sm-3">
                            <div class="form-group row @error('location') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Location') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="location" required>
                                        <option value="" class="selected highlighted">Select One</option>
                                        @foreach($locations as $key => $location)
                                            <option class="text-capitalize" value="{{ $key }}" {{ (old("location", $adLocation->location) == $key) ? "selected" : "" }}>
                                                {{ $location }}</option>
                                        @endforeach
                                    </select>
                                    @error('location')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group row @error('amount') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Amount') }} <small>(Per day)</small></label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="amount"
                                        value="{{ old('amount', $adLocation->amount) }}" placeholder="{{ __('Amount') }}" required>
                                    @error('amount')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}

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
