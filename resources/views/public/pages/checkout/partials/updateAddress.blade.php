<!-- Add address modal box start -->
@if ($addresses)
    @foreach ($addresses as $address)
        <div class="modal fade theme-modal" id="update-address{{ $address->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Update Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('public.pages.checkout.partials.update_form')
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
<!-- Add address modal box end -->
