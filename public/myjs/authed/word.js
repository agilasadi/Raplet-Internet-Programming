var anonymousmode = 0;

$("#submitComment").click(function () {
    $(".rapletIsLoading").css('display', 'block');
    $('#submitComment').prop('disabled', true);
    var content = $('textarea#commentContent').val();
    var linkers = $('.extraContentBead').html();
    var post_id = $(this).data('content_id');

    if (post_id == null || post_id === "") {
        post_id = $("#submitComment").data("post_id");
    }
    var submitCommentData = $("#submitComment").data("comment-id");
    var commentCode = (submitCommentData == undefined || submitCommentData === 0) ? "newComment" : $("#submitComment").data("comment-id");


    var backEndUrl = createComments;
    if (commentCode !== "newComment") {
        var regex = new RegExp('/[^/]*$');
        backEndUrl = createComments.replace(regex, '/') + "editComments";
    }

    $.ajax({
        url: backEndUrl,
        method: "POST",
        data: {
            content: content,
            comment_id: commentCode,
            jsonObj: jsonObj,
            post_id: post_id,
            anonymousmode: anonymousmode,
            lang: lang,
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
                    loaderBg: '#41b883'
                });

                if ($(location).attr("href").split('/').pop() == "w") {

                    createNewCommentLine(data);
                }else{
                    location.reload();
                }

            } else if (data.success === '0') {
                $("#submitComment").attr("disabled", false);
                $.toast({
                    text: data.message,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left',
                    loader: true,
                    loaderBg: '#db4c4c'
                });
                setTimeout(
                    function () {
                        $(".rapletIsLoading").css('display', 'none');
                        $('#submitComment').prop('disabled', false);
                    }, 2000);
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
                        loaderBg: 'red'
                    });
                });
                setTimeout(
                    function () {
                        $(".rapletIsLoading").css('display', 'none');
                        $('#submitComment').prop('disabled', false);
                    }, 2000);
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
                    loaderBg: '#db4c4c'
                });
            });
            setTimeout(
                function () {
                    $(".rapletIsLoading").css('display', 'none');
                    $('#submitComment').prop('disabled', false);
                }, 2000);
        }

    })
});

var createNewCommentLine = function (data) {
    $("#theEntrieCommentInABox" + data.theComment.id).parent().remove();
    clearCommentSection();
    if (data.commentLinks !== '') {
        console.log(data.commentLinks);
        var commentLinkContent = data.commentLinks;
        var linkContentParsed = JSON.parse(commentLinkContent);

        var linkHtml = '';

        for (var i = 0; i < linkContentParsed.length; i++) {
            if (linkContentParsed[i].type === "l") {
                linkHtml = linkHtml +
                    '<li class="linklinks linkchains">' +
                    '<a href="' + linkContentParsed[i].url + '">' +
                    '<i class="fas fa-link"></i>&nbsp;&nbsp;' +
                    linkContentParsed[i].text +
                    '</a>' +
                    '</li>';
            }

            else if (linkContentParsed[i].type === "v") {
                linkHtml = linkHtml +
                    '<li class="videolinks linkchains">' +
                    '<a href="' + linkContentParsed[i].url + '">' +
                    '<i class="fas fa-link"></i>&nbsp;&nbsp;' +
                    linkContentParsed[i].text +
                    '</a>' +
                    '</li>';
            }


            else if (linkContentParsed[i].type === "t") {
                linkHtml = linkHtml +
                    '<li class="tolooklinks linkchains">' +
                    '<a href="' + linkContentParsed[i].url + '">' +
                    '<i class="fas fa-link"></i>&nbsp;&nbsp;' +
                    linkContentParsed[i].text +
                    '</a>' +
                    '</li>';
            }
        }
    }
    else {
        linkHtml = '';
    }

    var addedCommentIs = '<div class="outherCommentDiv">' +
        '<div class="commentEntirityBlock" id="theEntrieCommentInABox' + data.theComment.id + '">' +
        '<div class="comment-field-circle">' +
        '<div>' +
        '<a href="' + data.entryRoute + '">' +
        '<img class="roundimg" src="' + data.userImg + '">' +
        '</a>' +
        '</div>' +
        '</div>' +
        '<div class="entireCommentContentContainer">' +
        '<div class="listTitleLines">' +
        '<a href="#">' +
        '<span class="bolderHeading">' + data.userinfo.name + '</span>' +
        '<span class="slimUserSlug">' + ' @' + data.userinfo.name + '</span>' +
        '</a>' +
        '</div>' +
        '<a href="' + data.entryRoute + '"><div class="commentContent" id="commentContent' + data.theComment.id + '">' + data.theComment.content + '</div></a>' +
        '<div class="linkInsideCommentBox">' + linkHtml + '</div>' +
        '</div>' +
        '<div class="commentInterract">' +
        '<button class="interactive-bar-button like" id="likedbtn' + data.theComment.id + '" data-content_id="' + data.theComment.id + '"><i class="fas fa-chevron-up"></i>&nbsp;&nbsp;<span id="likecount' + data.theComment.id + '">0</span></button>' +
        '<button class="interactive-bar-button dislike" id="dislikedbtn' + data.theComment.id + '" data-content_id="' + data.theComment.id + '"><i class="fas fa-chevron-down"></i>&nbsp;&nbsp;<span id="dislikecount' + data.theComment.id + '">0</span></button>' +
        '<div class="float-right row">' +
        '<div class="d-inline dateAsigner">' + data.justNowPosted + '</div>' +
        '</div>' +
        '</div>' +
        '<div class="interractWithComment">' +
        '<div class="btn-group d-inline">' +
        '<button type="button" class="noBackgroundBtns " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-chevron-down"></i></button>' +
        '<div class="dropdown-menu dropdown-menu-right">' +
        '<a class="dropdown-item reportAnything" data-type="2" data-content_id="' + data.theComment.id + '"><i class="far fa-flag"></i>&nbsp;&nbsp;&nbsp;' + reporterTrans + '</a>' +
        '<a class="dropdown-item editComment" data-content_id="' + data.theComment.id + '"><i class="far fa-edit"></i>&nbsp;&nbsp;' + editerTrans + '</a>' +
        '<a class="dropdown-item deleteComment" data-content_id="' + data.theComment.id + '"><i class="far fa-trash-alt"></i>&nbsp;&nbsp;&nbsp;' + deleterTrans + '</a>' +
        '<a class="dropdown-item disabled" href="#">' + shareTrans + '</a>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>';

    $('.newCommentBeenAdded').prepend(addedCommentIs);

    document.getElementById("commentContent").value = "";
    $(".extraContentBead").empty();
    jsonObj = [];
    $('.niceShapedLinkin').val('');

    setTimeout(
        function () {
            $(".rapletIsLoading").css('display', 'none');
            $('#submitComment').prop('disabled', false);
        }, 2000);

};

$('.activateAnonymous ').click(function () {
    $(this).toggleClass('checkSomethingOutActive');
    $('.isitanonymous').toggleClass('d-none');
    if (anonymousmode === 0) anonymousmode = 1;
    else anonymousmode = 0;
});

$('#clearCommentSection ').click(function () {
    clearCommentSection();
});

$('#clearCommentText ').click(function () {
    document.getElementById("commentContent").value = "";
});

var clearCommentSection = function () {
    document.getElementById("commentContent").value = "";
    $(".extraContentBead").empty();
    linkerCount = 5;
    $("#linkerObjectCounter").html(linkerCount);
    $("#submitComment").data("comment-id", 0);
    commentSectionClose();

};
