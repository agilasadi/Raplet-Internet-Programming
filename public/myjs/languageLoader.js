var Linguals = [];
$(document).ready(function() {
    $('.lingerContent').each(function() {
        var content_id = $(this).data('content_id');
        var content_type = $(this).data('content_type');

        Linguals.push(content_type +'-'+content_id);
    });

    if (Linguals.length > 0) {
        $.ajax({
            url: rapletTranslator,
            method: "POST",
            data: {
                Linguals: Linguals,
                _token: token
            },
            success: function (data) {
                $.each(data.translations, function () {
                    $(".translation" + this.content_id).attr("data-original-title", this.transname);
                });
            }
        })
    }
    });
