    <!-- Add address modal box start -->
    <div class="modal fade theme-modal" id="add_address" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add a new address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    @if(authUser())
                        @include('public.member_dashboard.address.partials.create_form')
                    @else
                        @include('public.pages.checkout.partials.create_form')
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Add address modal box end -->