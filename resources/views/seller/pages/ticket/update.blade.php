@extends('seller.layouts.master')

@section('title', __('Update Ticket'))

@section('content')
<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
    {!! \App\Library\Html::linkBack(route('seller.ticket.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Update Ticket')) }}</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body py-sm-4">
            <form method="post" action="{{ route('seller.ticket.update', $ticket->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('department') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Issue Type') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="department" required>
                                        <option value="" class="selected highlighted">Select Department</option>
                                        @foreach($departments as $value)
                                        <option class="text-capitalize" value="{{ $value }}"
                                            {{(old("department", $ticket->department) == $value) ? "selected" : ""}}>
                                            {{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div> <!-- Column end -->
                            </div> <!-- row Group end -->

                            <div class="form-group row @error('priority') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Priority') }}</label>
                                <div class="col-sm-9">
                                    <select class="form-control select2" name="priority" required>
                                        <option value="" class="selected highlighted">Select Priority</option>
                                        @foreach(\App\Library\Enum::getTicketPriority() as $index => $value)
                                        <option class="text-capitalize" value="{{ $index }}" {{(old("priority", $ticket->priority) == $index) ? "selected" : ""}}>
                                            {{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('priority')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div> <!-- Column end -->
                            </div> <!-- row Group end -->

                            <div class="form-group row @error('subject') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Subject') }}</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="subject" value="{{ old('subject', $ticket->subject) }}"
                                        placeholder="{{ __('Ticket Subject') }}" required>
                                    @error('subject')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div> <!-- Column end -->
                            </div> <!-- row Group end -->

                            <div class="form-group row @error('attachment') error @enderror">
                                <label class="col-sm-3 col-form-label">Attachment</label>
                                <div class="col-sm-9">
                                    <div class="file-upload-section">
                                        <input name="attachment" type="file" class="form-control d-none" allowed="*">
                                        <div class="input-group col-xs-12">
                                            <input type="text" id="file_name" class="form-control file-upload-info"
                                                disabled="" readonly placeholder="Upload attachment file">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-outline-secondary"
                                                    type="button"><i class="fas fa-upload"></i> Browse</button>
                                            </span>
                                        </div>
                                    </div>
                                    @error('attachment')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div> <!-- Column end -->
                            </div> <!-- row Group end -->
                        </div>
                    </div>

                    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12">
                        <div class="p-sm-3">

                            <div class="form-group row @error('message') error @enderror">
                                <label class="col-sm-3 col-form-label required">{{ __('Message') }}</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="ticketMessage" name="message" rows="8"
                                        placeholder="Ticket Message">{{ old('message', $ticket->message) }}</textarea>
                                    @error('message')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div> <!-- Column end -->
                            </div> <!-- row Group end -->

                        </div><!-- p-sm end -->
                    </div><!-- Col-md-6 end -->
                </div><!-- Row end -->

                <div class="form-footer text-center">
                    {!! \App\Library\Html::btnSubmitWithJs() !!}
                </div><!-- Footer Button end -->

            </form><!-- Form end -->
        </div><!-- Card Body end -->
    </div><!-- Card end -->
</div>
@stop
@include('admin.assets.select2')
@include('admin.assets.summernote-text-editor')

@push('scripts')
@vite('resources/admin_assets/js/pages/ticket/create.js')
@vite('resources/admin_assets/js/select2.js')
@endpush
