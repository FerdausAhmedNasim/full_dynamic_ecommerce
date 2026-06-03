<!-- Modal -->
<div class="modal fade" id="showNotificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-default" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> <span id="show_subject"> </span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 p-3">
                        <span id="show_msg" ></span><br><br>
                        <span class="d-none" id="show_date">Date : </span><span id="show_send_date"></span>
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

@push('scripts')
<script type="text/javascript">
    const showNotificationModal = "#showNotificationModal";

    function showViewModal(message, subject, date) {

        var formattedDate = moment(date).format(dateFormat);

        $('#show_msg').html(message);
        $('#show_subject').html(subject);
        $('#show_send_date').html(formattedDate);
        if(date){
            $('#show_date').removeClass('d-none');
        }else{
            $('#show_date').addClass('d-none');
        }
        $(showNotificationModal).modal('show');
    }
</script>
@endpush