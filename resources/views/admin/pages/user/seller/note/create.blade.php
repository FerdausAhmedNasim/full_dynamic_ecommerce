@extends('admin.layouts.master')
@section('title', 'Note Create')
@section('notes', 'active')

@section('content')

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('admin.user.seller.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Note Create' )) }}</h4>
        </div>
    </div>

    <!-- TabMenu Start -->
    <div class="card shadow-sm">
        @include('admin.pages.user.seller.partials.topbar', ['user', $user??''])
    </div>
    <!-- TabMenu End -->

    <div class="card shadow-sm col-lg-8  col-md-12 mt-3">
        <div class="card-body py-sm-4">
            <form method="post" class="form" action="{{ route('admin.user.seller.note.create', $user->id??'') }}"
                enctype="multipart/form-data">
                @csrf

                <div class="p-sm-3">

                    <div class="form-group row @error('title') error @enderror">
                        <label class="col-sm-3 col-form-label required">{{ __('Title') }}</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                placeholder="{{ __('Title') }}" required>
                            @error('title')
                            <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('description') error @enderror">
                        <label class="col-sm-3 col-form-label required"
                            for="description">{{ __('Description') }}</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="summernote" name="description"
                                placeholder="Write here Description About Note....">{{ old('description') }}</textarea>

                            @error('description')
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
@include('admin.assets.summernote-text-editor')

@push('scripts')
@vite('resources/admin_assets/js/pages/user/seller/note/create.js')
@endpush