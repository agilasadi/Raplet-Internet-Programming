$(".createAKT").click(function () {

    var keeper_id = $(this).data('keeper_id');
    var coverName = $("#keeperTranslateCoverName" + keeper_id).val();

    var setVariable = localStorage.getItem('value') || 0;

    var messageContent = $('#keeperTranslateContent'+keeper_id).val();
        var messageImg = ($('#keeperTranslateImage'+keeper_id)[0]);
        var linkText = $('#keeperTranslateLinkText'+keeper_id).val() || 0;
        var linkUrl = $('#keeperTranslateLinkUrl'+keeper_id).val() || 0;
        var message_lang = lang_id;

        var data = new FormData();
        data.append("messageContent", messageContent);
        if (coverName !== 0) {
            data.append("messageImg", messageImg.files[0]);
        }
        data.append("coverName", coverName);
        data.append("linkText", linkText);
        data.append("linkUrl", linkUrl);
        data.append("message_lang", message_lang);
        data.append("keeper_id", keeper_id);
        data.append("_token", token);

    $.ajax({
        url: createAKT,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function (data) {
            $.toast({
                text: data.message,
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                stack: 5,
                position: 'bottom-left',

                textAlign: 'left', 
                loader: false, 
                loaderBg: '#5475b8' 
            });
            /*
            setTimeout(function(){// wait for 5 secs(2)
                location.reload(); // then reload the page.(3)
            }, 3000);
            */
        }
    })



});


//update excisting translation
$(".updateAKT").click(function () {

    var trans_id = $(this).data('trans_id');
    var coverName = $("#keeperTranslateCoverName" + trans_id).val();

    var setVariable = localStorage.getItem('value') || 0;

    var messageContent = $('#keeperTranslateContent'+trans_id).val();
    var messageImg = ($('#keeperTranslateImage'+trans_id)[0]);
    var linkText = $('#keeperTranslateLinkText'+trans_id).val() || 0;
    var linkUrl = $('#keeperTranslateLinkUrl'+trans_id).val() || 0;

    var data = new FormData();
    data.append("messageContent", messageContent);
    if (coverName !== 0) {
        data.append("messageImg", messageImg.files[0]);
    }
    data.append("coverName", coverName);
    data.append("linkText", linkText);
    data.append("linkUrl", linkUrl);
    data.append("trans_id", trans_id);
    data.append("_token", token);


    $.ajax({
        url: updateAKT,
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
        success: function (data) {
            $.toast({
                text: data.message,
                showHideTransition: 'fade',
                allowToastClose: true,
                hideAfter: 3000,
                stack: 5,
                position: 'bottom-left',

                textAlign: 'left', 
                loader: false, 
                loaderBg: '#5475b8' 
            });
            /*
            setTimeout(function(){// wait for 5 secs(2)
                location.reload(); // then reload the page.(3)
            }, 3000);
            */
        }
    })

});
