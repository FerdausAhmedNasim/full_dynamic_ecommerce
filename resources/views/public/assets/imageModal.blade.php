<div class="modal fade theme-modal view-modal" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header p-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row g-sm-4 g-2">
                    <div class="col-lg-12">
                        <div class="slider-image text-center">
                            <img id="modalImage" src="" class="img-fluid w-100" alt="Preview Review Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.preview-image').on('click', function() {
            var src = $(this).attr('data-src');
            $('#modalImage').attr('src', src);
            $('#imageModal').modal('show');
        });
    });
</script>
@endpush

@push('scripts')
    <style>
        .preview-image:hover {
            cursor: pointer
        }
    </style>
@endpush