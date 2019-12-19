
function submitLanguage(){

    var content = $("#summernote").summernote('code');

    $.ajax({
        url: termstranslate,
        method: "POST",
        data: {
            content: content,
            lang_id: lang_id,
            _token: token
        },
        success: function (data) {

            if(data.success == '1'){
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
            }
            else if(data.success == '2'){
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
            }
        }
    })

}