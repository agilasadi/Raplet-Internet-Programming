$(".badginButton").click(function () {
    $(".badginButton").attr("disabled", true);


    var content_id = $(this).data('post_id');
    var badge_id = $(this).data('badge_id');
    var content_type = $(this).data('badge_type');

    $.ajax({
        url: badgeContent,
        method: "POST",
        data: {
            content_id: content_id,
            badge_id: badge_id,
            content_type: content_type,
            _token: token
        },
        success: function (data) {
            if (data.success === '1') {
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
                $('.postBadges').append(data.newComment);
                $(".badginButton").attr("disabled", false);
            }
            if (data.success === '2') {
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

                $('#granted' + data.badgeId).remove();
                $(".badginButton").attr("disabled", false);

            } else if (data.success === '0') {
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
                $(".badginButton").attr("disabled", false);
            } else {
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

        },
        error: function (e) {
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
