@extends('seller.layouts.master')
@section('title', __('Ticket Reply'))
@section('content')


<div class="content-wrapper">
    <div class="content-header d-flex justify-content-start">
        {!! \App\Library\Html::linkBack(route('seller.ticket.index')) !!}
        <div class="d-block">
            <h4 class="content-title">{{ strtoupper(__('Ticket Reply')) }}</h4>
        </div>

    </div>
    <div class="row">
        <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-5 pb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="p-3">
                        <p class="clearfix">
                            <span class="float-left">
                                Submitted
                            </span>
                            <span class="float-right text-muted">
                                {{ getFormattedDateTime($ticket->created_at) }}
                            </span>
                        </p>
                        <hr>

                        <p class="clearfix">
                            <span class="float-left">
                                Status
                            </span>
                            <span class="float-right text-muted">
                                @if($ticket->status == \App\Library\Enum::TICKET_STATUS_OPEN)
                                <span class="badge btn-success">Open</span>
                                @elseif($ticket->status == \App\Library\Enum::TICKET_STATUS_HOLD)
                                <span class="badge btn-warning">Hold</span>
                                @elseif($ticket->status == \App\Library\Enum::TICKET_STATUS_CLOSED)
                                <span class="badge btn-danger">Closed</span>
                                @else
                                <span class="badge btn-warning">New</span>
                                @endif
                            </span>
                        </p>
                        <hr>

                        <p class="clearfix">
                            <span class="float-left">
                                Priority
                            </span>
                            <span class="float-right text-muted">
                                {{ App\Library\Enum::getTicketPriority($ticket->priority) }}
                            </span>
                        </p>
                        <hr>
                        <p class="clearfix">
                            <span class="float-left">
                            Issue Type
                            </span>
                            <span class="float-right text-muted">
                                {{ $ticket->department }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-8 col-xl-8 col-lg-7 col-md-7">
            <div class="card shadow-sm {{ $ticket->status == App\Library\Enum::TICKET_STATUS_CLOSED ? 'd-none' : '' }}">
                <div class="card-body">
                    <div class="add-items mb-0">
                        <form class="mb-0" action="{{ route('seller.ticket.reply', $ticket->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row @error('comment') error @enderror">
                                        <div class="col-sm-12">
                                            <textarea style="line-height: inherit;" type="text" id="ticketMessage"
                                                class="form-control todo-list-input" name="comment" rows="10"
                                                placeholder="Add Reply Text">{{ old('comment') }}</textarea>
                                            @error('comment')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @if($ticket->assign_to_id ==  auth()->id())
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label required">{{ __('Solution Time') }}</label>
                                        <div class="form-group col-sm-2 col-6 @error('hour') error @enderror">
                                            <input type="number" name="hour" value="{{ old('hour') }}" class="form-control" placeholder="Hour">
                                            @error('hour')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-2 col-6 @error('minute') error @enderror">
                                            <input type="number" name="minute" value="{{ old('minute') }}" class="form-control" placeholder="Min." required>
                                            @error('minute')
                                            <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-12">
                                    @if($ticket->status != App\Library\Enum::TICKET_STATUS_CLOSED)
                                    <button type="submit" onclick="this.disabled=true; this.form.submit();" class="btn btn-sm btn2-secondary text-white ml-0">
                                        <i class="ti-share-alt text-white me-1"></i> Reply
                                    </button>
                                    <button type="button" class=" btn btn-sm btn2-light-secondary" id="fileButton">
                                        <i class="ti-clip me-1"></i>Attach
                                    </button>
                                    @else
                                    <a href="{{ route( 'seller.ticket.reopen',  $ticket->id ) }}"
                                        class="edit btn btn-sm btn-info pr-2"> <i class="fas fa fa-envelope-open"></i>
                                        Reopen </a>
                                    <button type="button" class=" btn btn-sm btn2-light-secondary" id="fileButton">
                                        <i class="ti-clip me-1"></i>Attach
                                    </button>
                                    @endif


                                    <span id="fileName" class="ml-2"> <span class="ml-2 text-muted">(png, gif, jpeg, jpg, pdf, docx, doc)</span> </span>
                                    <input name="attachment" type="file" id="fileOpen" accept=".jpg, .jpeg, .pdf, .png, .gif, .doc, .docx"
                                        class="form-control @error('attachment') error @enderror d-none">
                                    @error('attachment')
                                    <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @foreach($ticket_assigns ?? [] as $key => $assign)
                @foreach($assign->replies ?? [] as $key => $reply)
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">
                        <div class="col-md-12 pl-1">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h5>{{$reply->user_name}}</h5>
                                    <p class="mb-3 text-capitalize">
                                        {{ $reply?->user?->user_type }}
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="mb-3">
                                        {{ App\Library\Helper::replaceWithUrl(nl2br($reply->comment)) }}
                                    </p>
                                    <p class="mb-1 @if($reply->attachment == null) d-none @endif">
                                        Attachment: <a href="{{ asset($reply->attachment) }}" download class="mb-1">
                                            <i class="fas fa-download"></i> Download</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer 1">
                        <small class="float-right">Replied: {{ getFormattedDateTime($reply->created_at) }}</small>
                    </div>
                </div>
                @endforeach

                <div class="card mt-4 shadow-sm bg-light-secondary">
                    <div class="card-body">
                        <div class="col-md-12 pl-1">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h5>{{$assign->assigned_by_name}}</h5>
                                    <p> Assigned To </p>
                                    <h5 class="mb-3">
                                        {{$assign->assign_to_name}}
                                    </h5>
                                </div>
                                <div class="col-sm-9">

                                    <p class="mb-3">
                                        {{ $assign->notes }}
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="float-right">Assigned: {{ getFormattedDateTime($assign->created_at) }}</small>
                    </div>
                </div>
            @endforeach

            <div class="card mt-4 shadow-sm">
                <div class="card-header">Ticket</div>
                <div class="card-body">
                    <div class="col-md-12 pl-1">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6>{{$ticket?->full_name}}</h6>
                            </div>
                            <div class="col-sm-9">
                                <p class="mb-3">
                                    {{  App\Library\Helper::replaceWithUrl($ticket->message) }}
                                </p>
                                <p class="mb-1 @if($ticket->attachment == null) d-none @endif">
                                    Attachment: <a href="{{asset($ticket->attachment)}}" download class="mb-1">
                                        <i class="fas fa-download"></i> Download</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('seller.assets.summernote-text-editor')
@stop

@push('scripts')
@vite('resources/admin_assets/js/pages/ticket/show.js')
@endpush
