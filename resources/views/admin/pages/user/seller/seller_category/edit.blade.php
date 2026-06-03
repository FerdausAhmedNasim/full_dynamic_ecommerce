@extends('admin.layouts.master')
@section('title', 'seller Category Edit')
@section('sellerCategory', 'active')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('seller Category Edit' )) }}</h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.user.seller.partials.topbar', ['user', $user??''])
    </div>
    <!-- TabMenu End -->

    <div class="card shadow-sm col-lg-8  col-md-12 mt-3">
        <div class="card-body py-sm-4">
            <form method="post" class="form" action="{{ route('admin.user.seller.category.update', [ $user->id, $sellerCategory->id??'']) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="p-sm-3">

                    <div class="form-group row @error('title') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Title') }}</label>
                        <div class="col-sm-9">
                            <select id="category_id" class="form-control select2" name="category_id" required>
                                <option value="" class="selected highlighted">Select One</option>
                                @foreach($categories as $category)
                                    <option class="text-capitalize" value="{{ $category->id }}" {{ (old("category_id", $sellerCategory->id) == $category->id) ? "selected" : "" }}>
                                        {{ $category->getTranslation('title') }} </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('commission_rate') error @enderror">
                        <label class="col-sm-3 col-form-label required"
                            for="commission_rate">{{ __('Commission Rate') }} (%)</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="commission_rate" value="{{ old('commission_rate', $sellerCategory->commission_rate) }}"
                            placeholder="{{ __('Commission Rate') }}" required>
                            @error('commission_rate')
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
@include('admin.assets.select2')
