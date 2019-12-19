function logUserIn() {
    $(".rapletIsLoading").css('display', 'block');
    $("#logUserIn").addClass('disabled');


    // event.preventDefault();

    var isFormValid = true;

    $(".requiredLogIn").each(function () {
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
        $().attr("disabled", false);
    });

    if (isFormValid) {

        var email = $('#loginMail').val();
        var password = $('#loginPassword').val();

        if ('recap' == 'recap') {//check recaptcha
            $.ajax({
                url: loginUser,
                method: "POST",
                data: {
                    email: email,
                    password: password,
                    _token: token
                },
                success: function (data) {
                    if (data.success == 1) {// login usccessfull
                        $(".rapletIsLoading").css('display', 'none');
                        $("#logUserIn").removeClass('disabled');

                        $.toast({
                            text: loginSuccss,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 1500,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#41b883'
                        });
                        $('#loginModel').modal('hide');
                        setTimeout(function () {// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 2000);
                    } else if (data.success == 2) {
                        $(".rapletIsLoading").css('display', 'none');
                        $("#logUserIn").removeClass('disabled');
                        $("#logUserIn").attr("disabled", false);
                        $.toast({
                            text: loginUnsuccessfull,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#ff0000'
                        });
                    } else {//no such user
                        $(".rapletIsLoading").css('display', 'none');
                        $("#logUserIn").removeClass('disabled');
                        $("#logUserIn").attr("disabled", false);
                        $.toast({
                            text: noSuchUser,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',
                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#ff0000'
                        });
                    }


                }, error: function (e) {
                    $(".rapletIsLoading").css('display', 'none');
                    $("#logUserIn").removeClass('disabled');
                    $("#logUserIn").attr("disabled", false);
                    var k;
                    var res = JSON.parse(e.responseText);
                    for (k in res) {
                        $.toast({
                            text: res[k],
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#ff0000'
                        });
                    }
                }

            })
        } else {
            $(".rapletIsLoading").css('display', 'none');
            $(this).attr("disabled", true);

            $.toast({
                text: passConfirmMessage,
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                stack: 5,
                position: 'bottom-left',
                textAlign: 'left',
                loader: true,
                loaderBg: '#ff0000'
            });
        }

    } else {
        setTimeout(
            function () {
                $(".rapletIsLoading").css('display', 'none');
                $("#logUserIn").removeClass('disabled');
                $("#logUserIn").attr("disabled", false);

            }, 2000);

    }
}
