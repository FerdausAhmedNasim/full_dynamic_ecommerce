@extends('admin.layouts.master')

@section('title', __('New Team'))

@section('content')
    <div class="content-wrapper">

        <div class="content-header d-flex justify-content-start">
            {!! \App\Library\Html::linkBack(route('admin.team.index')) !!}
            <div class="d-block">
                <h4 class="content-title">{{ strtoupper(__('New Team')) }}</h4>
            </div>

        </div>

        <div class="card shadow-sm col-md-6">
            <div class="card-body py-sm-4">
                <form method="post" action="{{ route('admin.team.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="p-sm-3">

                                <div class="form-group row @error('name') error @enderror">
                                    <label class="col-md-3 col-form-label required">{{ __('Name') }}</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="{{ __('Name') }}" required>
                                        @error('name')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('parent_id') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Parent Team') }}</label>
                                    <div class="col-sm-9">

                                        <select class="form-control select2" name="parent_id" required>
                                            <option value="" class="selected highlighted">Select One</option>
                                            @foreach ($team as $key => $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>

                                                @foreach ($category->childrenTeams as $key => $subCategory)
                                                    @if ($subCategory->teams)
                                                        <option class="text-capitalize" value="{{ $subCategory->id }}"
                                                            {{ old('parent_id') == $subCategory->id ? 'selected' : '' }}>
                                                            &nbsp;-{{ $subCategory->name }}
                                                        </option>
                                                    @endif

                                                    @foreach ($subCategory->childrenTeams as $key => $subSubCat)
                                                        @if ($subSubCat->teams)
                                                            <option class="text-capitalize" value="{{ $subSubCat->id }}"
                                                                {{ old('parent_id') == $subSubCat->id ? 'selected' : '' }}>
                                                                &nbsp;&nbsp;--{{ $subSubCat->name }}
                                                            </option>
                                                        @endif

                                                        @foreach ($subSubCat->childrenTeams as $key => $subSub2Cat)
                                                            @if ($subSub2Cat->teams)
                                                                <option class="text-capitalize"
                                                                    value="{{ $subSub2Cat->id }}"
                                                                    {{ old('parent_id') == $subSub2Cat->id ? 'selected' : '' }}>
                                                                    &nbsp;&nbsp;&nbsp;---{{ $subSub2Cat->name }}
                                                                </option>
                                                            @endif

                                                            @foreach ($subSub2Cat->childrenTeams as $key => $subSub3Cat)
                                                                @if ($subSub3Cat->teams)
                                                                    <option class="text-capitalize"
                                                                        value="{{ $subSub3Cat->id }}"
                                                                        {{ old('parent_id') == $subSub3Cat->id ? 'selected' : '' }}>
                                                                        &nbsp;&nbsp;&nbsp;----{{ $subSub3Cat->name }}
                                                                    </option>
                                                                @endif

                                                                @foreach ($subSub3Cat->childrenTeams as $key => $subSub4Cat)
                                                                    @if ($subSub4Cat->teams)
                                                                        <option class="text-capitalize"
                                                                            value="{{ $subSub4Cat->id }}"
                                                                            {{ old('parent_id') == $subSub4Cat->id ? 'selected' : '' }}>
                                                                            &nbsp;&nbsp;&nbsp;-----{{ $subSub4Cat->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </select>
                                        @error('parent_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('team_leader_id') error @enderror">
                                    <label class="col-sm-3 col-form-label required">{{ __('Team Manager/Leader') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" name="team_leader_id" required>
                                            <option value="" class="selected highlighted">Select One</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ old('team_leader_id') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->full_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('team_leader_id')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row @error('description') error @enderror">
                                    <label class="col-md-3 col-form-label">{{ __('Description') }}</label>
                                    <div class="col-md-9">
                                        <textarea type="text" name="description" class="form-control" id="summernote" value="{{ old('description') }}"
                                            placeholder="Description"></textarea>
                                        @error('description')
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
@include('admin.assets.summernote-text-editor')

@push('scripts')
    @vite('resources/admin_assets/js/select2.js')

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 400
            });
        });
    </script>
@endpush
