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

        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('#file-upload-image').attr('src', e.target.result);
                    $('.uploadingPostPreview').css('display', 'block');
                    $('.file-upload-content').show();

                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            document.getElementById("file-upload-image").src = "#";
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
            $('.uploadingPostPreview').css('display', 'none');
        }
        $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
        });

        $(document).on('click', '.savePostChanges', function () {
            var content_id = $(this).data('content_id');
            var content = $("#editablePostField").val();
            var category = $("#editableCategoryField").val();
            var theimagefile = ($('.file-upload-input')[0]);

            var data = new FormData();
            data.append("content", content);
            data.append("category", category);
            data.append("content_id", content_id);
            data.append("image", theimagefile.files[0]);
            data.append("_token", token);

            $.ajax({
                method: 'POST',
                url: postEdit,
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
                            window.location = "../w/" + data.slug + "/" + data.local; // then reload the page.(3)
                        }, 3000);

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
