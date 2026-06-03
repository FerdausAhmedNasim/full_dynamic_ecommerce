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
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">

                    <input type="hidden" id="attribute_id" value="{{ $attribute->id }}">

                    @include('admin.pages.product.attributeValue.index')

                </div>
            </div>
        </div>

        @if(Helper::hasAuthRolePermission('attribute_value_create'))
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Add Attribute Value</h4><hr>
                    <form method="post" action="{{ route('admin.attribute.attributeValueStore', $attribute->id) }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">

                        <div class="form-group row @error('name') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Attribute') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" readonly
                                    value="{{ old('name', $attribute->name) }}" placeholder="{{ __('Attribute') }}"
                                    required>
                                @error('name')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row @error('value') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Attribute Value') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="value"
                                    value="{{ old('value') }}" placeholder="{{ __('Attribute Value') }}"
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
