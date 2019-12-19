$('.addImageBtn').click(function () {
    event.stopPropagation();
    $('.file-upload').css("display", "block");
});
$('.file-upload').click(function () {
    event.stopPropagation();
});
$('.file-upload-btn').click(function () {
    event.stopPropagation();
    $('.file-upload').css("display", "block");
});
$(document).click(function () {
    $(".file-upload").css("display", 'none');
});


function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    document.getElementById("file-upload-image").src = "#";
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
    $('.uploadingPostPreview').css('display', 'none');
    $('.informingAboutVisualPost').css('visibility', 'hidden');
}
$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});
$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});

function readURL(input) {
    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function (e) {
            $('.image-upload-wrap').hide();

            $('.file-upload-image').attr('src', e.target.result);
            $('#file-upload-image').attr('src', e.target.result);
            $('.uploadingPostPreview').css('display', 'block');
            $('.informingAboutVisualPost').css('visibility', 'visible');
            $('.file-upload-content').show();

        };

        reader.readAsDataURL(input.files[0]);

    } else {
        removeUpload();
    }
}

$(document).on('click', '.savePostChanges', function () {
    $(".savePostChanges").attr("disabled", true);
    $(".savePostChanges").addClass('disabled');
    var content = $("#editablePostField").val();
    var category = $("#editableCategoryField").val();
    var theimagefile = ($('.file-upload-input')[0]);

    var data = new FormData();
    data.append("content", content);
    data.append("category", category);

    var lang = 'en';
    if (theimagefile.files.length == 0) {} else {
        data.append("image", theimagefile.files[0]);
    }

    data.append("_token", token);

    $.ajax({
        method: 'POST',
        url: createPost,
        data: data,
        contentType: false,
        processData: false,
        success: function (data) {
            if (data.success === '1') {

                $.toast({
                    text: data.message,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 2600,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left',
                    loader: true,
                    loaderBg: '#5475b8',
                });
                setTimeout(function () {
                    window.location = data.rotation;
                    $(".savePostChanges").addClass('disabled');
                }, 3000);
            } else if (data.success === '0') {
                $.toast({
                    text: data.message,
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 2600,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left',
                    loader: true,
                    loaderBg: '#5475b8'
                });
                setTimeout(function () {
                    $(".savePostChanges").removeClass('disabled');
                    $(".savePostChanges").attr("disabled", false);
                }, 3000);
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
                    setTimeout(function () {
                        $(".savePostChanges").removeClass('disabled');
                        $(".savePostChanges").attr("disabled", false);
                    }, 3000);
                })
            }

        }
    })


});
