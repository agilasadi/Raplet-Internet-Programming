$(document).ready(function () {

    $image_crop = $('#profile_img').croppie({
        enableExif: true,
        viewport: {
            width: 320,
            height: 320,
            type: 'square' //circle
        },
        boundary: {
            width: 340,
            height: 340
        }
    });

    $('#upload_image').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function () {});
        };
        reader.readAsDataURL(this.files[0]);
        $('#uploadimageModal').modal('show');
    });

    $('.crop_image').click(function (event) {
        $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (response) {
            $.ajax({
                url: uploadProfileImage,
                type: "POST",
                data: {
                    "userImg": response,
                    _token: token
                },
                success: function (res) {
                    $('#uploadimageModal').modal('hide');
                    var sourceLink = "storage/profile/" + res.res;
                    $("#profileImagePreview").attr("src", sourceLink);
                    $.toast({
                        text: "Resim yükleme başarılı",
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'bottom-left',

                        textAlign: 'left',
                        loader: true,
                        loaderBg: '#5475b8',
                        beforeShow: function () {}, // will be triggered before the toast is shown
                        afterShown: function () {}, // will be triggered after the toast has been shown
                        beforeHide: function () {}, // will be triggered before the toast gets hidden
                        afterHidden: function () {} // will be triggered after the toast has been hidden
                    });

                }
            });
        })
    });

});


//update javascript
$(document).on('click', '#updateProfile', function () {
    event.preventDefault();

    var isFormValid = true;

    $(".requiredUpdate").each(function () {
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
                loaderBg: 'red',
            });

        }
    });


    if (isFormValid) { // slug, name, email, about, password
        var slug = $('#updateSlug').val();
        var name = $('#updateUsername').val();
        var about = $('#updateAbout').val();
        var email = $('#updateEmail').val();
        var oldpassword = $('#oldPassword').val();
        var password = $('#updatePassword').val();
        var passwordConfirm = $('#confirmEditPassword').val();
        var field = '';

        if (password == passwordConfirm) {
            $.ajax({
                url: updateProfile,
                method: "POST",
                data: {
                    slug: slug,
                    name: name,
                    email: email,
                    bio: about,
                    oldpassword: oldpassword,
                    password: password,
                    password_confirmation: passwordConfirm,
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
                            loaderBg: '#5475b8',
                        });
                        setTimeout(function () {
                            window.location = data.profilelink;
                        }, 3000);
                    } else if (data.success == 0) {
                        $.toast({
                            text: data.message,
                            showHideTransition: 'fade',
                            allowToastClose: true,
                            hideAfter: 3000,
                            stack: 5,
                            position: 'bottom-left',

                            textAlign: 'left',
                            loader: true,
                            loaderBg: '#5475b8',
                        });
                    } else {
                        jQuery.each(data.errors, function (key, value) {

                            switch (key) {
                                case 0:
                                    field = slug;
                                    break;
                                case 1:
                                    field = name;
                                    break;
                                case 4:
                                    field = email;
                                    break;
                                case 5:
                                    field = oldpassword;
                                    break;
                                case 6:
                                    field = password;
                                    break;
                                default:
                                    field = passwordConfirm;
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

                        })
                    }
                }
            })

        } else {
            $.toast({
                text: passwordNotMAtch,
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                stack: 5,
                position: 'bottom-left',

                textAlign: 'left',
                loader: true,
                loaderBg: 'red',
            });
        }


    }


});
