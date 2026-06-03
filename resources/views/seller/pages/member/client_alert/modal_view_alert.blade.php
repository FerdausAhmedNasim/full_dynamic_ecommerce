<!-- Modal -->
<div class="modal fade" id="alertDetailsModal" tabindex="-1" role="dialog" aria-labelledby="alertDetailsModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"> <span id="show_subject"> </span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 ">
                        <span id="details" ></span><br><br>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                {!! \App\Library\Html::btnClose() !!}
            </div>
        </div>
        </form>

    </div>
</div>
