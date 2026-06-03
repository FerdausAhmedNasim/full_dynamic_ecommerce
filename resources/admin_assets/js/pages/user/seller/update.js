$(document).ready(function () {
    $("#gender").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#subscription").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#nominated").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#seconded").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#location").select2({
        placeholder: "Select One",
        allowClear: true
    });
});


var current_fs, next_fs, previous_fs;
var left, opacity, scale;
var animation;

var error = false;

var current = 1;
var steps = $("fieldset").length;


// ***********************************************************
//      Step 1.   Personal Information Start
// ***********************************************************

// first name validation
$("#fname").keyup(function() {
    var fname = $("#fname").val();
    if (fname == '') {
        $("#error-fname").text('Enter your first name.');
        $("#fname").addClass("box_error");
        error = true;
    } else {
        $("#error-fname").text('');
        error = false;
    }
    if (!isNaN(fname)) {
        $("#error-fname").text("Only characters are allowed.");
        $("#fname").addClass("box_error");
        error = true;
    } else {
        $("#fname").removeClass("box_error");
    }
});
// last name validation
$("#lname").keyup(function() {
    var lname = $("#lname").val();
    if (lname == '') {
        $("#error-lname").text('Enter your last name.');
        $("#lname").addClass("box_error");
        error = true;
    } else {
        $("#error-lname").text('');
        error = false;
    }
    if (!isNaN(lname)) {
        $("#error-lname").text("Only characters are allowed.");
        $("#lname").addClass("box_error");
        error = true;
    } else {
        $("#lname").removeClass("box_error");
    }
});
// work email validation
$("#workEmail").keyup(function() {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test($("#workEmail").val())) {
        $("#error-workEmail").text('Please enter an email address.');
        $("#workEmail").addClass("box_error");
        error = true;
    } else {
        $("#error-workEmail").text('');
        error = false;
        $("#workEmail").removeClass("box_error");
    }
});
// work phone validation
$("#workPhone").keyup(function() {
    var phoneReg = /^[0-9]+$/;
    var phone = $("#workPhone").val();

    if (!phoneReg.test($("#workPhone").val())) {
        $("#error-workPhone").text('Please enter an phone number.');
        $("#workPhone").addClass("box_error");
        error = true;
    } else {
        // error = false;
        $("#error-workPhone").text('');
        $("#workPhone").removeClass("box_error");
    }
    if ((phone.length <= 7) || (phone.length > 15)) {
        $("#error-workPhone").text("Mobile number must be between 8 - 15 Digits only.");
        $("#workPhone").addClass("box_error");
        error = true;
    } else {
        $("#workPhone").removeClass("box_error");
    }
});
// dob validation
$('#dob').on('change', function() {
    let dob = document.getElementById("dob").value;
    if (dob == '' || dob == null) {
        $("#error-dob").text('Please enter your Date of Birth.');
        $("#dob").addClass("box_error");
        error = true;
    } else {
        // error = false;
        $("#error-dob").text('');
        $("#dob").removeClass("box_error");
    }

});

// gender validation
$('#gender').on('change', function() {
    var gender = $(this).children(':selected').data('params');

    if (gender == '') {
        $("#error-gender").text('Enter your gender.');
        $("#gender + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-gender").text('');
        error = false;
    }
    if (gender == null) {
        $("#error-gender").text("Gender field is required.");
        $("#gender + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#gender + .select2-container .select2-selection--single").removeClass("box_error");
    }
});
// subscription validation
$('#subscription').on('change', function() {
    var subscription = $(this).children(':selected').data('params');

    if (subscription == '') {
        $("#error-subscription").text('Enter your subscription.');
        $("#subscription + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-subscription").text('');
        error = false;
    }
    if (subscription == null) {
        $("#error-subscription").text("Subscription field is required.");
        $("#subscription + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#subscription + .select2-container .select2-selection--single").removeClass("box_error");
    }
});
// nominated validation
$('#nominated').on('change', function() {
    var nominated = $(this).children(':selected').data('params');

    if (nominated == '') {
        $("#error-nominated").text('Enter your nominated.');
        $("#nominated + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-nominated").text('');
        error = false;
    }
    if (nominated == null) {
        $("#error-nominated").text("Nominated field is required.");
        $("#nominated + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#nominated + .select2-container .select2-selection--single").removeClass("box_error");
    }
});
// seconded validation
$('#seconded').on('change', function() {
    var seconded = $(this).children(':selected').data('params');

    if (seconded == '') {
        $("#error-seconded").text('Enter your seconded.');
        $("#seconded + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-seconded").text('');
        error = false;
    }
    if (seconded == null) {
        $("#error-seconded").text("Seconded field is required.");
        $("#seconded + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#seconded + .select2-container .select2-selection--single").removeClass("box_error");
    }
});

// first step validation
$(".fs_next_btn").click(function() {

    // first name
    if ($("#fname").val() == '') {
        $("#error-fname").text('Enter your first name.');
        $("#fname").addClass("box_error");
        error = true;
    } else {
        var fname = $("#fname").val();
        if (fname != fname) {
            $("#error-fname").text('First name is required.');
            error = true;
        } else {
            // error = false;
            $("#error-fname").text('');
            $("#fname").removeClass("box_error");
        }
        if (!isNaN(fname)) {
            $("#error-fname").text("Only characters are allowed.");
            error = true;
        } else {
            $("#fname").removeClass("box_error");
        }
    }
    // last name
    if ($("#lname").val() == '') {
        $("#error-lname").text('Enter your last name.');
        $("#lname").addClass("box_error");
        error = true;
    } else {
        var lname = $("#lname").val();
        if (lname != lname) {
            $("#error-lname").text('Last name is required.');
            error = true;
        } else {
            // error = false;
            $("#error-lname").text('');
            $("#lname").removeClass("box_error");
        }
        if (!isNaN(lname)) {
            $("#error-lname").text("Only Characters are allowed.");
            error = true;
        } else {
            $("#lname").removeClass("box_error");
        }
    }
    // work email
    if ($("#workEmail").val() == '') {
        // $("#error-workEmail").text('Please enter an email address.');
        // $("#workEmail").addClass("box_error");
        error = false;
    } else {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test($("#workEmail").val())) {
            $("#error-workEmail").text('Please insert a valid email address.');
            error = true;
        } else {
            $("#error-workEmail").text('');
            $("#workEmail").removeClass("box_error");
        }
    }
    // phone
    if ($("#workPhone").val() == '') {
        $("#error-workPhone").text('Please enter an phone number.');
        $("#workPhone").addClass("box_error");
        error = true;
    } else {
        var phoneReg = /^[0-9]+$/;
        var phone = $("#workPhone").val();
        if (!phoneReg.test($("#workPhone").val())) {
            $("#error-workPhone").text('Please insert a valid phone number.');
            error = true;
        } else {
            $("#error-workPhone").text('');
            $("#workPhone").removeClass("box_error");
        }
        if ((phone.length <= 7) || (phone.length > 15)) {
            $("#error-workPhone").text("Mobile number must be between 8 - 15 Digits only.");
            $("#workPhone").addClass("box_error");
            error = true;
        } else {
            $("#workPhone").removeClass("box_error");
        }
    }
    // DOB
    let dob = document.getElementById("dob").value;
    if (dob == '' || dob == null) {
        $("#error-dob").text('Please enter your Date of Birth.');
        $("#dob").addClass("box_error");
        error = true;
    } else {
        // error = false;
        $("#error-dob").text('');
        $("#dob").removeClass("box_error");
    }
    // gender
    if ($("#gender").val() == '' || $("#gender").val() == null) {
        $("#error-gender").text('Please select your gender.');
        $("#gender + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-gender").text('');
        $("#gender + .select2-container .select2-selection--single").removeClass("box_error");
    }
    // subscription
    if ($("#subscription").val() == '' || $("#subscription").val() == null) {
        $("#error-subscription").text('Please select your subscription.');
        $("#subscription + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-subscription").text('');
        $("#subscription + .select2-container .select2-selection--single").removeClass("box_error");
    }
    // nominated
    if ($("#nominated").val() == '' || $("#nominated").val() == null) {
        $("#error-nominated").text('Please select your nominated.');
        $("#nominated + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-nominated").text('');
        $("#nominated + .select2-container .select2-selection--single").removeClass("box_error");
    }
    // seconded
    if ($("#seconded").val() == '' || $("#seconded").val() == null) {
        $("#error-seconded").text('Please select your seconded.');
        $("#seconded + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-seconded").text('');
        $("#seconded + .select2-container .select2-selection--single").removeClass("box_error");
    }

    // animation
    if (!error) {
        if (animation) return false;
        animation = true;

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        $("#progressbar-2 li").eq($("fieldset").index(next_fs)).addClass("active");

        next_fs.show();
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now, mx) {
                left = (now * 50) + "%";
                opacity = 1 - now;
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({
                    'left': left,
                    'opacity': opacity
                });
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animation = false;
            },
            easing: 'easeInOutBack'
        });
        // setProgressBar(++current);
    }
});

// ***********************************************************
//      Step 1.   Personal Information End
// ***********************************************************



// previous
$(".previous").click(function() {
    if (animation) return false;
    animation = true;

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    $("#progressbar-2 li").eq($("fieldset").index(current_fs)).removeClass("active");

    previous_fs.show();
    current_fs.animate({
        opacity: 0
    }, {
        step: function(now) {
            scale = 0.8 + (1 - now) * 0.2;
            left = ((1 - now) * 50) + "%";
            opacity = 1 - now;
            current_fs.css({
                'left': left,
                'display': 'none',
                'position': 'relative'
            });
            previous_fs.css({
                'transform': 'scale(' + scale + ')',
                'opacity': opacity
            });
        },
        duration: 800,
        complete: function() {
            current_fs.hide();
            animation = false;
        },
        easing: 'easeInOutBack'
    });
    // setProgressBar(--current);
});

function setProgressBar(curStep) {
    var percent = parseFloat(100 / steps) * curStep;
    percent = percent.toFixed();
    $(".progress-bar")
        .css("width", percent + "%")
}

$(".submit").click(function() {
    if (!error){
        $('#msform').submit()
    }
    return false;
})
