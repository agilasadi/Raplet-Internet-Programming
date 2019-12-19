// user registeration
// user registeration
// user registeration
$('#registerUser').click(function () {
    event.preventDefault();
    $(".rapletIsLoading").css('display', 'block');
    $("#registerUser").addClass('disabled');
    $("#registerUser").attr("disabled", true);
    var isFormValid = true;

    $(".requiredSignUp").each(function () {
        if ($.trim($(this).val()).length == 0) {
            $(this).addClass("fillIt");
            isFormValid = false;
            var contentType = $(this).data('content');

            $.toast({
                text: contentType + ' ' + required,
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                stack: 5,
                position: 'bottom-left',

                textAlign: 'left',
                loader: true,
                loaderBg: 'red'
            });

        }
    });


    if (isFormValid) {
        var name = $('#inputName').val();
        var email = $('#inputEmail').val();
        var password = $('#inputPassword').val();
        var passwordConfirm = $('#confirmPassword').val();
        var specialisedRecaptcha = $('#g-recaptcha-response').val();
        var field = '';

        if (password == passwordConfirm) {
            $.ajax({
                url: createUser,
                method: "POST",
                data: {
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirm,
                    specialisedRecaptcha: specialisedRecaptcha,
                    _token: token
                },
                success: function (data) {
                    if (data.success == 1) {
                        $.toast({
                            text: data.message,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#41b883'
                        });
                        $('#registerModal').modal('hide');
                        $('#langSelectorSpace').css("display", 'block');
                    } else if (data.success == 0) {
                        $(".rapletIsLoading").css('display', 'none');
                        $.toast({
                            text: data.message,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#ff0000'
                        });
                    } else {
                        jQuery.each(data.errors, function (key, value) {
                            if (key == 0) {
                                field = name;
                            } else if (key == 1) {
                                field = email;
                            } else if (key == 2) {
                                field = password;
                            }

                            $.toast({
                                text: field + ' ' + value,
                                showHideTransition: 'fade',
                                allowToastClose: true,
                                hideAfter: 3000,
                                stack: 5,
                                position: 'bottom-left',
                                textAlign: 'left',
                                loader: true,
                                loaderBg: 'red'
                            });
                        });
                        grecaptcha.reset();
                        $(".rapletIsLoading").css('display', 'none');
                        $("#registerUser").removeClass('disabled');
                        $("#registerUser").attr("disabled", false);

                    }
                }
            })
        } else {
            $(".rapletIsLoading").css('display', 'none');
            $("#registerUser").removeClass('disabled');
            $("#registerUser").attr("disabled", false);
            $.toast({
                text: passConfirmMessage,
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                stack: 5,
                position: 'bottom-left',
                textAlign: 'left',
                loader: true,
                loaderBg: 'red'
            });
        }

    } else {
        setTimeout(
            function () {
                $(".rapletIsLoading").css('display', 'none');
                $("#registerUser").removeClass('disabled');
                $("#registerUser").attr("disabled", false);
            }, 2000);
    }
});

