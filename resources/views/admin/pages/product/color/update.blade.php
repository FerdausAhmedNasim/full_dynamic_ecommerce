@extends('admin.layouts.master')

@section('title', 'Colors')
@section('color', 'active')

@section('content')

@php
    use App\Library\Helper;
@endphp

<div class="content-wrapper">
    
    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Colors' )) }}</h4>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            
            @include('admin.components.product_topbar')

        </div>
    </div>

    <div class="row pt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    @include('admin.pages.product.color.index')

                </div>
            </div>
        </div>

        @if(Helper::hasAuthRolePermission('color_update'))
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Update Color</h4><hr>
                    <form method="post" action="{{ route('admin.color.update', $color->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $color->id }}">
                        <div class="form-group row @error('name') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $color->name) }}" placeholder="{{ __('Name') }}"
                                    required>
                                @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row @error('color_code') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Color Code') }}</label>
                            <div class="col-sm-9">
                                <input type="color" class="form-control" name="color_code"
                                    value="{{ old('color_code', $color->color_code) }}" placeholder="{{ __('Color Code') }}"
                                    required>
                                @error('color_code')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
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
        @endif

    </div>

</div>

@stop
