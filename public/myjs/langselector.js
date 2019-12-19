$(document).on('click', '.permaLangSelector', function () {
    event.preventDefault();

    var isFormValid = true;


    if (isFormValid){
        var id = $(this).data('content_id');


            $.ajax({
                url: setNewLang,
                method: "POST",
                data: {
                    id: id,
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
                            loaderBg: '#5475b8', 
                        });
                        $('#langSelectorSpace').removeClass("visible");
                        setTimeout(function(){// wait for 5 secs(2)
                           location.reload(); // then reload the page.(3)
                        }, 3000);
                }
            })


    }


});



$(document).on('click', '.closeThisScreen', function () {
    $('#langSelectorSpace').toggleClass("visible");

});
$(document).on('click', '.resetpageclass', function () {
    setTimeout(function(){// wait for 5 secs(2)
        location.reload(); // then reload the page.(3)
    }, 500);
});
