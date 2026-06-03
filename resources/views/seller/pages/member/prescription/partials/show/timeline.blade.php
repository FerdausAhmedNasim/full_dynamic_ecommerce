<div class="accordion accordion-solid-header" id="results" role="tablist">

</div>


<div class="row d-flex justify-content-center">
    <button type="button" id="load-more" class="btn btn-outline-success btn-icon-text" onclick="loadMore()">
        <i class="ti-reload btn-icon-prepend"></i>
        Load More
    </button>
</div>

@push('scripts')
<script>
    var site_url = "{{ url('/') }}";
    var memberId = "{{ $member->id }}";
    var page = 0;
    var ppage = 0;
    var myNotePage = 0;

    loadMore();
    pLoadMore();
    myNoteLoadMore();

    function loadMore() {
        page++
        $.ajax({
            url: site_url + "/members/prescriptions/" + memberId + "?page=" + page,
            type: "get",
            datatype: "html",
            beforeSend: function() {
            //$('.ajax-loading').show();
            }
        }).done(function(data) {
            if (data.length == 0) {

                //$('.ajax-loading').html("No more records!");
                // alert('No more records!')

                $("#load-more").addClass('d-none');

                return;
            }
            //$('.ajax-loading').hide();

            $("#results").append(data);

        }).fail(function(jqXHR, ajaxOptions, thrownError) {
        });
    }

    function pLoadMore() {
        ppage++
        $.ajax({
            url: site_url + "/members/prescriptions/private/" + memberId + "?page=" + ppage,
            type: "get",
            datatype: "html",
            beforeSend: function() {
            //$('.ajax-loading').show();
            }
        }).done(function(data) {
            if (data.length == 0) {

                //$('.ajax-loading').html("No more records!");
                // alert('No more records!')

                $("#p-load-more").addClass('d-none');

                return;
            }
            //$('.ajax-loading').hide();

            $("#pResults").append(data);

        }).fail(function(jqXHR, ajaxOptions, thrownError) {

        });
    }

    function myNoteLoadMore() {
        myNotePage++
        $.ajax({
            url: site_url + "/members/prescriptions/mynote/" + memberId + "?page=" + myNotePage,
            type: "get",
            datatype: "html",
            beforeSend: function() {
            }
        }).done(function(data) {
            if (data.length == 0) {
                $("#myNote-load-more").addClass('d-none');

                return;
            }
            $("#myNoteResults").append(data);

        }).fail(function(jqXHR, ajaxOptions, thrownError) {

        });
    }
</script>
@endpush
