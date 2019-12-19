function checkKeeper() {

    var checkedStatus = 0;
    var required = 0;
    var varnable = 0;

    $( ".keeperField" ).each(function( index ) {
        if ($(this).hasClass( "musthave" )){
            var contentCheck = $.trim($(this).val());
            if (contentCheck.length < 1) {
                alert('The field ' + $(this).attr("name") + ' is required!');
                $(this).addClass('is-invalid');

                checkedStatus = checkedStatus + 1;
            }
        }
        else if($(this).hasClass( "betterhave" )){
            var contentCheck2 = $.trim($(this).val());
            if (contentCheck2.length < 1) {
                $.toast({
                    text: 'The field ' + $(this).attr("name") + ' was left empty!',
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 3000,
                    stack: 5,
                    position: 'bottom-left',

                    textAlign: 'left',
                    loader: true,
                    loaderBg: '#5475b8'
                });
                $(this).addClass('is-invalid');
            }
        }
    });

    if (checkedStatus == 0){
        addKeeper();
    }
    else {
        $.toast({
            text: 'You have empty fields that you need to fill before sharing this message!...',
            showHideTransition: 'fade',
            allowToastClose: true,
            hideAfter: 6000,
            stack: 5,
            position: 'bottom-left',
            textAlign: 'left',
            loader: false,
            loaderBg: '#5475b8'
        });
    }
}


function addKeeper(){
    $( ".fieldFiller" ).each(function( index ) {
        var contentDefualting = $.trim($(this).val());
        if (contentDefualting.length < 1) {
            $(this).val('0');
        }
    });



    var messageContent = $('#messageContent').val();
    var messageImg = ($('#messageImg')[0]);
    var linkText = $('#linkText').val();
    var linkUrl = $('#linkUrl').val();
    var messageType = $('#messageType').val();
    var messageStatus = $('#messageStatus').val();
    var message_lang = $('#message_lang').val();
    var user_type = $('#for_user_type').val();
    var messageExpireDate = $('#messageExpireDay').val() + " " + $('#messageExpireMinute').val()+":00";

    var data = new FormData();
    data.append("messageContent", messageContent);
    data.append("messageImg", messageImg.files[0]);
    data.append("linkText", linkText);
    data.append("linkUrl", linkUrl);
    data.append("messageType", messageType);
    data.append("messageStatus", messageStatus);
    data.append("message_lang", message_lang);
    data.append("user_type", user_type);
    data.append("messageExpireDate", messageExpireDate);
    data.append("_token", token);



    $.ajax({
        url: createNewKeeper,
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

}

var keeper_content_id;

$(".keeperCoverInputField").change(function() {
    keeper_content_id = $(this).attr("data-keeperEdit_id");
    keeperImageEditing(this);
});

function keeperImageEditing(input) {

    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {

            $('#keeperCoverPreview' + keeper_content_id).attr('src', e.target.result);

            $('.file-upload-content').show();

            $(".keeperCoverimagePrevievHolder" + keeper_content_id).removeClass("hideInBeginning");
            $(".DumperClassify" + keeper_content_id).removeClass("hideInBeginning");
            $("#keeperCoverName" + keeper_content_id).val("1");
        };

        reader.readAsDataURL(input.files[0]);

    }
}

$(".keeperCoverDump").click(function (){
    var keeper_content_id = $(this).attr('data-keeperEdit_id');
    $(".keeperCoverimagePrevievHolder" + keeper_content_id).addClass("hideInBeginning");
    $(".imageBannerHolder" + keeper_content_id).addClass("fieldForNoImg");
    $("#keeperCoverName" + keeper_content_id).val("0");
    $(".DumperClassify" + keeper_content_id).addClass("hideInBeginning");
});

$(".updateAKeeper").click(function() {

    var keeper_content_id = $(this).data('keeperedit_id');


    var keeperContent = $('#keeperContent'+ keeper_content_id).val();
    var keeperCover = ($("#keeperCover" + keeper_content_id)[0]);
    var keeperLinkText = $('#keeperLinkText' + keeper_content_id).val();
    var keeperLinkUrl = $('#keeperLinkUrl' + keeper_content_id).val();
    var keeperType = $('#keeperType' + keeper_content_id).val();
    var keeperStatus = $('#keeperStatus' + keeper_content_id).val();
    var keeperUserType = $('#keeperUserType' + keeper_content_id).val();
    var keeperCoverName = $('#keeperCoverName' + keeper_content_id).val();
    var keeperExpire = $('#keeperExpire' + keeper_content_id).val();



    var data = new FormData();

    data.append("messageContent", keeperContent);
    data.append("messageImg", keeperCover.files[0]);
    data.append("linkText", keeperLinkText);
    data.append("linkUrl", keeperLinkUrl);
    data.append("messageType", keeperType);
    data.append("messageStatus", keeperStatus);
    data.append("user_type", keeperUserType);
    data.append("keeperCoverName", keeperCoverName);
    data.append("messageExpireDate", keeperExpire);
    data.append("keeperId", keeper_content_id);
    data.append("_token", token);

    $.ajax({
        url: editTheKeeper,
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



$(".keeperTranslateCoverDump").click(function (){
    var keeper_content_id = $(this).attr('data-keeperEdit_id');
    $(".kTranslateCIPH" + keeper_content_id).addClass("hideInBeginning");
    $(".imageTranslateBannerHolder" + keeper_content_id).addClass("fieldForNoImg");
    $("#keeperTranslateCoverName" + keeper_content_id).val("0");
    $(".translateDumperClassify" + keeper_content_id).addClass("hideInBeginning");
});


$(".keeperTranslateCoverInputField").change(function() {
    var content_id = $(this).attr("data-keeperEdit_id");
    keeperTranslateImageEditing(this, content_id);
});

function keeperTranslateImageEditing(input, content_id) {

    if (input.files && input.files[0]) {

        var reader = new FileReader();

        reader.onload = function(e) {

            $('#keeperTranslateCoverPreview' + content_id).attr('src', e.target.result);

            $('.file-upload-content').show();

            $(".kTranslateCIPH" + content_id).removeClass("hideInBeginning");
            $(".translateDumperClassify" + content_id).removeClass("hideInBeginning");
            $("#keeperTranslateCoverName" + content_id).val("1");
        };

        reader.readAsDataURL(input.files[0]);

    }
}























