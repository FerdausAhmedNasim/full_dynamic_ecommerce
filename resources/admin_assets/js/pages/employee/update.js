$(document).ready(function () {
    $("#role_id").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#gender").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#location").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#ethnicity").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#jobTitle").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#employmentType").select2({
        placeholder: "Select One",
        allowClear: true
    });
    $("#branch_id").select2({
        placeholder: "Select One",
        allowClear: true,
    });
});


$("#userAccessTypeAdmin").click(function () {
    if ($('input[name="user[user_type]"]:checked').val() == "admin") {
        // $("#role_id").val([]).trigger("change");
        $("#role").removeClass("d-none");
    }
});

$("#userAccessTypeEmployee").click(function () {
    if ($('input[name="user[user_type]"]:checked').val() == "employee") {
        // $("#role_id").val([]).trigger("change");
        $("#role").addClass("d-none");
    }
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
    if (!isNaN(gender)) {
        $("#error-gender").text("Please select a gender.");
        $("#gender + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#gender + .select2-container .select2-selection--single").removeClass("box_error");
    }
});

// job title validation
$('#jobTitle').on('change', function() {
    var jobTitle = $(this).children(':selected').data('params');
    if (jobTitle == '') {
        $("#error-jobTitle").text('Enter your job title.');
        $("#jobTitle + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-jobTitle").text('');
        error = false;
    }
    if (!isNaN(jobTitle)) {
        $("#error-jobTitle").text("Please select a job title.");
        $("#jobTitle + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#jobTitle + .select2-container .select2-selection--single").removeClass("box_error");
    }
});
// employment type validation
$('#employmentType').on('change', function() {
    var employmentType = $(this).children(':selected').data('params');
    if (employmentType == '') {
        $("#error-employmentType").text('Enter your employment type.');
        $("#employmentType + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-employmentType").text('');
        error = false;
    }
    if (!isNaN(employmentType)) {
        $("#error-employmentType").text("Please select a employment type.");
        $("#employmentType + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#employmentType + .select2-container .select2-selection--single").removeClass("box_error");
    }
});

// first step validation
$(".fs_next_btn").click(function() {

    error = false;

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
            $("#error-fname").text('');
            // error = false;
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
            $("#error-lname").text('');
            // error = false;
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
    if ($("#workEmail").val() == '' || $("#workEmail").val() == null) {
        $("#error-workEmail").text('Please enter an email address.');
        $("#workEmail").addClass("box_error");
        error = true;
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

    // job title
    if ($("#jobTitle").val() == '' || $("#jobTitle").val() == null) {
        $("#error-jobTitle").text('Please select your job title.');
        $("#jobTitle + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-jobTitle").text('');
        $("#jobTitle + .select2-container .select2-selection--single").removeClass("box_error");
    }
    // employment type
    if ($("#employmentType").val() == '' || $("#employmentType").val() == null) {
        $("#error-employmentType").text('Please select your employment type.');
        $("#employmentType + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-employmentType").text('');
        $("#employmentType + .select2-container .select2-selection--single").removeClass("box_error");
    }

    // animation
    if (!error) {
        if (animation) return false;
        animation = true;

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

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


// ***********************************************************
//      Step 3.   Security Start
// ***********************************************************

// role id validation
$('#role_id').on('change', function() {
    var role_id = $(this).children(':selected').data('params');
    if (role_id == '' || role_id == null) {
        $("#error-role_id").text('Select role.');
        $("#role_id + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-role_id").text('');
        error = false;
    }
});

// final step validation
$(".tse_next_btn").click(function() {

    // role id
    var userAccessType = $('input[name="user[user_type]"]:checked').val();

    if (userAccessType == "employee") {
        error = false;
    } else if ($("#role_id").val() == '' || $("#role_id").val() == null) {
        $("#error-role_id").text('Please select role.');
        $("#role_id + .select2-container .select2-selection--single").addClass("box_error");
        error = true;
    } else {
        $("#error-role_id").text('');
        $("#role_id + .select2-container .select2-selection--single").removeClass("box_error");
        error = false;
    }

    // animation
    if (!error) {
        if (animation) return false;
        animation = true;

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

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
//      Step 3.   Security End
// ***********************************************************


// previous
$(".previous").click(function() {
    if (animation) return false;
    animation = true;

    current_fs = $(this).parent();
    previous_fs = $(this).parent().prev();

    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

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
                'right': (now * 50) + "%",
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
    setProgressBar(--current);
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
