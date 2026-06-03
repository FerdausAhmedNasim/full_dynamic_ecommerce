$(document).on('change', '#sameAddress',function(){
    if (this.checked) {
        $("#postalStreetAddress").val($("#homeStreetAddress").val());
        $("#postalSubRoad").val($("#homeSubRoad").val());
        $("#postalCity").val($("#homeCity").val());
        $("#postalPostCode").val($("#homePostCode").val());
        $("#postalLatitude").val($("#homeLatitude").val());
        $("#postalLoggitude").val($("#homeLoggitude").val());
    } else {
        $("#postalStreetAddress").val('');
        $("#postalSubRoad").val('');
        $("#postalCity").val('');
        $("#postalPostCode").val('');
        $("#postalLatitude").val('');
        $("#postalLoggitude").val('');
    }
});