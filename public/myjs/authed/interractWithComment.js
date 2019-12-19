$(document).on('click', '.like', function () {
    event.preventDefault();

    var content_id = $(this).data('content_id');


    $.ajax({
        url: likeComment,
        method: "POST",
        data: {
            content_id: content_id,
            _token: token
        },
        success: function (data) {
            if (data.success === '1') {
                $("#likecount" + content_id).text(data.likecount);
                $("#dislikecount" + content_id).text(data.dislikecount);

                $("#likedbtn" + content_id).toggleClass("on");
                $("#dislikedbtn" + content_id).removeClass("on");
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
                    loaderBg: '#5475b8',
                });
            }

        }
    })
});

$(document).on('click', '.dislike', function () {
    event.preventDefault();

    var content_id = $(this).data('content_id');


    $.ajax({
        url: dislikeComment,
        method: "POST",
        data: {
            content_id: content_id,
            _token: token
        },
        success: function (data) {
            if (data.success === '1') {

                $("#likecount" + content_id).text(data.likecount);
                $("#dislikecount" + content_id).text(data.dislikecount);

                $("#likedbtn" + content_id).removeClass("on");
                $("#dislikedbtn" + content_id).toggleClass("on");
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
                    loaderBg: '#5475b8',
                });
            }

        }
    })
});


$(document).on('click', '.editComment', function () {
    if ($(".postInterractOptionsDown").length == 0) {
        $('#editModel').modal();
    }
    var content_id = $(this).data('content_id');
    $("#submitComment").data("comment-id", content_id);
    var post_id=$(this).data("post_id");
    $("#submitComment").data("post_id", post_id);
    var content = $("#commentContent" + content_id).text();
    $('#enterYourCommentPlaceholder').focus().focus();

    $("#commentContent").val(content);

    var selectedCommentLinks = $("#theEntrieCommentInABox" + content_id + " .linkInsideCommentBox li");
    $(".extraContentBead").html("");

    for (var i = 0; i < selectedCommentLinks.length; i++) {

        var c_type = $(selectedCommentLinks[i]).attr("class").charAt(0);
        var c_first_name = $(selectedCommentLinks[i]).find("a").text().replace(/\s\s+/g, ' ');
        var c_second_name = $(selectedCommentLinks[i]).find("a").text().replace(/\s\s+/g, ' ');
        var c_href = $(selectedCommentLinks[i]).find("a").attr("href");

        if (c_type === "t") {
            var regex = new RegExp('/[^/]*$');
            var baseUrl = window.location.href.replace(regex, '/');
            c_href = c_href.replace(baseUrl, "");
        }

        createLinks(
            c_type,
            c_first_name,
            c_second_name,
            c_href
        );

    }


    /*
        $('#commentToEdit').val(content);
        $('#commentToEditID').val(content_id);
        $('#editModel').modal();
        */

});


$(document).on('click', '.updateTheComment', function () {
    event.preventDefault();

    var content_id = $("#commentToEditID").val();
    var content = $("#commentToEdit").val();

    $.ajax({
        url: editComments,
        method: "POST",
        data: {
            content: content,
            content_id: content_id,
            _token: token
        },
        success: function (data) {
            if (data.success === '1') {

                $("#commentContent" + content_id).text(content);

                $('#editModel').modal('hide');
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
            } else if (data.success == '0') {
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
            }

        },
        error: function (e) {
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
                    loaderBg: 'red',

                });
            }


        }
    })
});

$(document).on('click', '.deleteComment', function () {
    var content_id = $(this).data('content_id');
    var content = $("#commentContent" + content_id).text();


    $('#commentToDelete').val(content);
    $('#commentToDeleteID').val(content_id);
    $('#deleteModel').modal();

});

$(document).on('click', '#deleteAComment', function () {
    event.preventDefault();

    var content_id = $("#commentToDeleteID").val();

    $.ajax({
        url: deleteComments,
        method: "POST",
        data: {
            content_id: content_id,
            _token: token
        },
        success: function (data) {
            if (data.success === '1') {

                $("#theEntrieCommentInABox" + content_id).remove();

                $('#deleteModel').modal('hide');
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
            } else if (data.success == '0') {
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
            }

        },
        error: function (e) {
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
                    loaderBg: 'red',

                });
            }


        }
    })
});
