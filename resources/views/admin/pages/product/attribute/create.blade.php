@extends('admin.layouts.master')

@section('title', 'Attributes')
@section('attribute', 'active')

@section('content')

@php
    use App\Library\Helper;
@endphp

<div class="content-wrapper">
    
    <div class="content-header d-flex justify-content-between">
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Attributes' )) }}</h4>
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

                    @include('admin.pages.product.attribute.index')

                </div>
            </div>
        </div>
        
        @if(Helper::hasAuthRolePermission('attribute_create'))
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4>Add New</h4><hr>
                    <form method="post" action="{{ route('admin.attribute.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row @error('name') error @enderror">
                            <label class="col-sm-3 col-form-label required">{{ __('Name') }}</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" placeholder="{{ __('Name') }}"
                                    required>
                                @error('name')
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
