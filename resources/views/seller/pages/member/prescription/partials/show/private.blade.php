<div class="accordion accordion-solid-header" id="pResults" role="tablist">
    {{-- @forelse ($privatePrescriptions as $privatePrescription)
    <div class="card">
        <div class="card-header" role="tab" id="heading-{{ $privatePrescription->id }}">
            <h6 class="mb-0">
                <a class="text-center" data-bs-toggle="collapse" href="#collapse-{{ $privatePrescription->id }}" aria-expanded="true"
                    aria-controls="collapse-{{ $privatePrescription->id }}">
                    <span class="float-left">
                        <i class="ti-calendar mr-1"></i>
                        {{ $privatePrescription->date_time->format('d-M-Y') }}
                    </span>
                    <span class="text-center">{{ $privatePrescription->title }}</span>
                </a>
            </h6>
        </div>
        <div id="collapse-{{ $privatePrescription->id }}" class="collapse show" role="tabpanel" aria-labelledby="heading-{{ $privatePrescription->id }}"
            data-parent="#accordion-4" style="">
            <div class="card-body p-3">
                <div class="profile-feed">
                    <div class="profile-feed-item">
                        <div class="row">
                            <div class="col-md-3 p-3 bg-light-secondary rounded">
                                <span class="text-muted">
                                    <i class="ti-time mr-1"></i>
                                    {{ $privatePrescription->created_at->diffForHumans() }}
                                </span>
                                <p class="span text-muted mt-2">
                                    @foreach($privatePrescription->attachments as $attachment)
                                    <a href="{{ $attachment->getAttachment() }}" target="_blank" class="text-decoration-none text-muted">
                                        @if(! str_contains($attachment->attachment, '.pdf'))
                                            <i class="ti-image mr-1"></i>
                                        @else
                                            <i class="ti-file mr-1"></i>
                                        @endif
                                    </a>
                                    @endforeach
                                </p>
                                <span class="text-muted mt-2">
                                    <i class="ti-calendar mr-1"></i>
                                    {{ $privatePrescription->date_time->format('m-d-Y h:i A') }}
                                </span>
                            </div>
                            <div class="col-md-9">
                                <h6> {{ $privatePrescription->category }}</h6>
                                <p>
                                    {!! $privatePrescription->description !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @empty
    <p class="text-center">No private note found</p>
    @endforelse --}}
</div>

<div class="row d-flex justify-content-center">
    <button type="button" id="p-load-more" class="btn btn-outline-success btn-icon-text" onclick="pLoadMore()">
        <i class="ti-reload btn-icon-prepend"></i>
        Load More
    </button>
</div>