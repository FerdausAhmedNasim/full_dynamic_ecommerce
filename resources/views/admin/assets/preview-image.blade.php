<!-- Modal -->
<div class="modal fade" id="showImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span id="show_subject"> </span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body showImage">
                <div class="row">
                    <div class="col-md-12">
                        <img src="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        </form>

    </div>
</div>

@push('styles')

    <style>
        .showImage {
            text-align: center;
        }
    </style>

@endpush

@push('scripts')

    <script>
        function clickImage(image) {
            $('#showImageModal').modal('show');
            $(".showImage img").attr("src", image);
        }
    </script>

@endpush


