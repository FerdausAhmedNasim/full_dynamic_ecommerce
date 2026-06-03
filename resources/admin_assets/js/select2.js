$(document).ready(function () {
    $('.select_2_multiple').select2({
        placeholder: "Select One",
        allowClear: true
    });

    // $('.productSelect2').select2({
    //     placeholder: "Select One",
    //     allowClear: true
    // });

  function formatState(state) {
    // Ensure state.element is defined before accessing dataset
    if (!state.element || !state.element.dataset.thumbnail) {
      return state.text;
    }

    // Get the thumbnail URL from the data attribute
    var thumbnailUrl = BASE_URL  + "/" + state.element.dataset.thumbnail;

    // Construct the HTML with the image and text
    var $state = $(
      '<span><img width="50" src="' + thumbnailUrl + '" class="img-flag" /> ' + state.text + '</span>'
    );

    return $state;
  }

  $(".productSelect2").select2({
    templateResult: formatState
  });

});
