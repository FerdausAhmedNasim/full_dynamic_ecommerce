@extends('admin.layouts.master')

@section('title', 'Attribute Values')
@section('attribute_value', 'active')

@section('content')

@php
    use App\Library\Helper;
@endphp

<div class="content-wrapper">

    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Attribute Value' )) }}</h4>
        </div>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-body">
            
            @include('admin.components.product_topbar')

        </div>
    </div>

    <div class="row pt-4">
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-body">

                    @include('admin.pages.product.attributeValue.index')

                </div>
            </div>
        </div>

        @if(Helper::hasAuthRolePermission('attribute_value_update'))
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Update Attribute Value</h4><hr>
                    <form method="post" action="{{ route('admin.attributeValue.update', $attributeValue->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $attributeValue->id }}">

                        <div class="form-group row @error('attribute_id') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Attributes') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="attribute_id" readonly
                                    value="{{ $attributeValue?->attribute?->name }}" placeholder="{{ __('Attributes') }}"
                                    required>
                                @error('attribute_id')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="attribute_id" value="{{ old('attribute_id', $attributeValue->attribute_id) }}">

                        <div class="form-group row @error('value') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Value') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="value"
                                    value="{{ old('value', $attributeValue->value) }}" placeholder="{{ __('Value') }}"
                                    required>
                                @error('value')
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
