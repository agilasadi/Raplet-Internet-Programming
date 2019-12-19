$(document).on('click', '.likepost', function () {
    event.preventDefault();

    var content_id = $(this).data('content_id');


    $.ajax({
        url: likePost,
        method: "POST",
        data: {
            content_id: content_id,
            _token: token
        },
        success: function (data) {
            if (data.success === '1') {
                $("#postlikes" + content_id).text(data.likecount);
                $("#postlikesbtn" + content_id).toggleClass("likedHeart");
            } else {
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

        }
    })
});

$('.delete_post').click(function () {
    var post_id = $(this).data('post_id');

    $.ajax({
        url: delete_post,
        method: "POST",
        data: {
            post_id: post_id,
            _token: token
        },
        success: function (data) {
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

    })
});
$('.enablePost').click(function () {
    var post_id = $(this).data('post_id');

    $.ajax({
        url: enablePost,
        method: "POST",
        data: {
            post_id: post_id,
            _token: token
        },
        success: function (data) {
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

    })
});
