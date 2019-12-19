$(".aNewRoleAsign").click(function () {
    $(".aNewRoleAsign").attr("disabled", true);


    var user_id = $(this).data('user_id');
    var role_id = $(this).data('role_id');

    $.ajax({
        url: moderateUser,
        method: "POST",
        data: {
            user_id: user_id,
            role_id: role_id,
            _token: token
        },
        success: function (data) {
            if(data.success === '1'){
                $.toast({
                    text: data.message,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left', 
                    loader: true, 
                    loaderBg: '#5475b8' 
                });
                $('.newCommentBeenAdded').append(data.newComment);
                $('.linkInsideCommentBox' + data.newCommentId).append(data.commentLinks);
                $(".aNewRoleAsign").attr("disabled", false);

            }
            else if(data.success === '0'){
                $.toast({
                    text: data.message,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left', 
                    loader: true, 
                    loaderBg: '#5475b8' 
                });
            }
            else{
                jQuery.each(data.errors, function (key, value) {
                    $.toast({
                        text: value,
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'bottom-left',

                        textAlign: 'left', 
                        loader: true, 
                        loaderBg: 'red', 
                    });
                })
            }

        },error:function (e) {
            jQuery.each(data.errors, function (key, value) {
                $.toast({
                    text: value,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left', 
                    loader: true, 
                    loaderBg: 'red', 
                });
            })
        }

    })
});




$(".regulatePostis_featured").click(function () {
    $(".regulatePostis_featured").attr("disabled", true);


    var content_id = $(this).data('content_id');
    var is_featured_type = $(this).data('is_featured_type');

    $.ajax({
        url: verify_duplicate_ban,
        method: "POST",
        data: {
            content_id: content_id,
            is_featured_type: is_featured_type,
            _token: token
        },
        success: function (data) {
            if(data.success === '1'){
                $.toast({
                    text: data.message,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left', 
                    loader: true, 
                    loaderBg: '#5475b8' 
                });
                $(".regulatePostis_featured").attr("disabled", false);

            }
            else if(data.success === '0'){
                $.toast({
                    text: data.message,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left', 
                    loader: true, 
                    loaderBg: '#5475b8' 
                });
            }
            else{
                jQuery.each(data.errors, function (key, value) {
                    $.toast({
                        text: value,
                        showHideTransition: 'fade',
                        allowToastClose: true,
                        hideAfter: 3000,
                        stack: 5,
                        position: 'bottom-left',

                        textAlign: 'left', 
                        loader: true, 
                        loaderBg: 'red', 
                    });
                })
            }

        },error:function (e) {
            jQuery.each(data.errors, function (key, value) {
                $.toast({
                    text: value,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left', 
                    loader: true, 
                    loaderBg: 'red', 
                });
            })
        }

    })
});










