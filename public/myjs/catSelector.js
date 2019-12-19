$('.acategory').click(function () {
    var content_id = $(this).data('content_id');
    var selectedCat = $(this);
    $.ajax({
        type: "POST",
        url: catSelector,
        data: {
            content_id: content_id,
            _token: token
        },
        success: function (data) {
            if (data.success === '1') {
                $("#sideBox").parent().load(location.href + " #sideBox");
                $(".acategory").removeClass("active");
                selectedCat.addClass("active");
            }
            else {

            }
        },
        error: function (data) {
            console.log("error");
        }
    });
});

