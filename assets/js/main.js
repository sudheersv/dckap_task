$(function () {
    $body = $("body");

    $("#registerform").validate({
        rules: {
            name: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            uname: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            email: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            password: {
                minlength: 5
            },
            password_confirm: {
                minlength: 5,
                equalTo: "#Password"
            },
            mobile: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            dob: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            address: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            city: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            state: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            country: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },

        },
        submitHandler: function (form) {
            submitRegisterForm();
        }
    });

    function submitRegisterForm() {
        var form = new FormData(registerform);//$(this).serializeArray();
        $body.addClass("loading");
        $(this).find(':submit').attr("disabled", "disabled");
        $.ajax({
            url: Site.url + "user/add_user",
            method: "POST",
            data: form,
            contentType: false,
            cache: false,
            processData: false,
            success: function (result)
            {
                console.log(result)
                if (result.error)
                {
                    $.notify(result.msg, "error");
                    $body.removeClass("loading");
                } else
                {
                    $.notify(result.msg, "success");
                    $("#registerform").trigger("reset");
                    $body.removeClass("loading");
                    
                    location.href = Site.url;
                }
            },
            error: function (request, status, error)
            {
                $.notify(request.responseText, 'error');

            }
        });
    }
        
    $("#formLogin").validate({
        rules: {
            email: {
                required: true,
                normalizer: function (value) {
                    return $.trim(value);
                }
            },
            password: {
                minlength: 5
            },
        },
        submitHandler: function (form) {
            submitLoginForm();
        }
    });

    function submitLoginForm() {
        var form = new FormData(formLogin);
        $body.addClass("loading");
        $(this).find(':submit').attr("disabled", "disabled");
        $.ajax({
            url: Site.url + "user/validateLogin",
            method: "POST",
            data: form,//$(this).serializeArray(),
            contentType: false,
            cache: false,
            processData: false,
            success: function (result)
            {
                console.log(result)
                if (result.error)
                {
                    $.notify(result.msg, "error");
                    $body.removeClass("loading");
                    
                } else
                {
                    $.notify(result.msg, "success");
                    $("#formLogin").trigger("reset");
                    $body.removeClass("loading");
                    
                    location.href = Site.url;
                }
            },
            error: function (request, status, error)
            {
                $.notify(request.responseText, 'error');

            }
        });
    }

});