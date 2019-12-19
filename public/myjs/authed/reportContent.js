$(document).on('click', '.reportAnything', function () {
    var content_id = $(this).data('content_id');
    var type = $(this).data('type');


    $('#reportingID').val(content_id);
    $('#reportingTYPE').val(type);
    $('#reportModel').modal();

});

$(document).ready(function () {
    $('#sendReport').on('click', function () {
        var content_id = $("#reportingID").val();
        var type = $("#reportingTYPE").val();
        var reason = $("#reportREASON").val();

        $.ajax({
            method: 'POST',
            url: reportCreate,
            data: {
                content_id: content_id,
                reason: reason,
                type: type,
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
                        loaderBg: '#5475b8',
                    });
                    $('#reportModel').modal('hide');
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
});
