// JavaScript Document
function showLoader() {
    $(".ajax-loader").show();
    $(".main-container").css('opacity', 0.1).html("");
}
function hideLoader() {
    $(".ajax-loader").hide();
    $(".main-container").css('opacity', 1);
}
$(document).ready(function(e) {
    //remove autocomplete from all fields
    $("input:text").prop('autocomplete', 'off');
    //ajax loader
    $(".ajax-loader").css({'left': $(window).width() / 2 - 64 + 'px', 'top': $(window).height() / 2 - 64 + 'px'})
    //Show login form
    $(".login-container").css({'opacity': 0, 'display': 'block'});
    //$(".feedback").css('opacity',0).show();
    $("#init-button").click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        $(".login-init").show().animate({
            'top': $(".login-init").position().top + 150 + 'px',
            'opacity': 0
        }, 300, function() {
            $(".login-init").css({'display': 'none'});

            //Show login form
            $(".login-container").stop().animate({
                'top': 0,
                'opacity': 1
            }, 300);
            //Feedback button
            /*$(".feedback").stop().animate({
             'top' : 420,
             'opacity' : 1
             },300);*/
        });
    });
    //Show password reset field
    $("#rm-link").click(function(event) {
        event.preventDefault();
        event.stopPropagation();

        //Hide login form
        $(".login-container").stop().animate({
            'top': 300,
            'opacity': 0
        }, 300, function() {
            $(".login-container").css('display', 'none');
            $(".pass-forgot-block").fadeIn('fast');
        });
    })

    //login form text effects
    //username
    var usrInitalVal = $("#username").val();
    $("#username").focus(function(event) {
        if ($(this).val() == usrInitalVal) {
            $(this).val("");
        }
    });
    $("#username").blur(function(event) {
        if ($(this).val() == "") {
            $(this).val(usrInitalVal);
        }
    });
    //password
    $("#password").blur(function(event) {
        if ($(this).val() == "") {
            $(".pass-label").css('display', 'block');
        }
    });

    $("#password-wrap").on("click", function(event) {
        $(".pass-label").css('display', 'none');
        $("#password").focus();
    });

    //Load home page
    $("#home-link").click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        showLoader();
        $(".main-container").load("index.php", function(data) {
            hideLoader();
        });
    });
    //Load register type page
    $("#register-type").click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        showLoader();
        $(".main-container").load("register-type.php", function(data) {
            hideLoader();
        });
    });

    //Load regular register page
    $(".regular-register").click(function(event) {
        event.preventDefault();
        event.stopPropagation();
        showLoader();
        $(".main-container").load("registration.php", {resetdata: 1}, function(data) {
            hideLoader();
        });
    });

    //password
    $(".form-row").each(function(index, element) {
        $(this).click(function(event) {
            if ($(this).find(".pass-labels").length) {
                $(this).find(".pass-labels").css('display', 'none');
                $(this).find("input").focus();
            }
        });
    });

    $(".form-row input").each(function(index, element) {
        $(this).blur(function(event) {
            if ($(this).val() == "") {
                $(this).parent().find(".pass-labels").css('display', 'block');
            }
        });
        $(this).focus(function(event) {
            if ($(this).val() == "") {
                $(this).parent().find(".pass-labels").css('display', 'none');
            }
        });
    });
    //////////////////////////////////////////////////////////////////
    //Upload image
    $("#profileimg").change(function(event) {
        $("#placeholder").css('opacity', 0.3);
        $(".loaderp").show();
        document.getElementById("upload-form").submit();
    });

    //Send password resquest
    $("#pass-forgot").click(function(event) {
        $("#pass-forgot").prop('disabled',true);
        $.ajax({
            url: "lib/tools.php",
            type: "post",
            dataType: "text",
            data: {
                user_email: $("#usr-email").val(),
                pass_reset: 1
            },
            success: function(data) {
                // alert(data);
                if (data == "1") {
                    $(".pass-forgot-block").append("<div style='color:#fff; margin-top:10px;'>Request sent.</div>");
                }
                else {
                    
                }
                $("#pass-forgot").removeProp('disabled');
            }

        });
    });
});



function uploadFinished(data) {
    //Set image to placeholder
    if (data != "0") {
        $(".loaderp").hide();
        var thumbnail = $("<img>");
        thumbnail.prop({'width': '241', 'height': '151', 'src': data});
        thumbnail.on("load", function() {
            $("#placeholder").prop('src', data);
            $("#placeholder").css('opacity', 1);
            $("#profile-image").val(data);
        });

        return true;
    }
    alert("Error occured while uploading");
}

//Registration form validation
$(document).ready(function(e) {

    $("#register-form").bind("submit", function(event) {
        event.preventDefault();
        validator.errors.length = 0;

        validator.requiredField("first-name");
        validator.requiredField("last-name");
        validator.validateEmail("email-address");
        validator.requiredField("password");

        if ($("#confirm-password").val() != $("#password").val()) {
            validator.errors.push({ID: "confirm-password", errorMessage: "Please enter same password again"});
        }

        validator.validateDate("birth-date");
        validator.requiredField("gender");

        validator.displayErrors(callback);
    });
});

function callback() {

    $("#submit-button").prop('disabled', 'disabled');
    $.ajax({
        url: "lib/tools.php",
        type: "post",
        dataType: "text",
        data: {
            first_name: $("#first-name").val(),
            last_name: $("#last-name").val(),
            email: $("#email-address").val(),
            password: $("#password").val(),
            birth_date: $("#birth-date").val(),
            gender: $("#gender").val(),
            profile_image: $("#profile-image").val(),
            reg: 1

        },
        success: function(data) {
            // alert(data);
            if (data == "1") {
                showLoader();
                $(".main-container").load("index.php", function(data) {
                    hideLoader();
                });
            }
            else {
                $("#login-response").show();
            }
            $("#submit-button").removeProp('disabled');
        }

    });
}