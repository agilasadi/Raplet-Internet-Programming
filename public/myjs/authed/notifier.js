$('.active-notification').click(function () {
    $.ajax({
        url: get_notifications,
        data: {
            _token: token
        },
        success: function (data) {
            if (data.notifyCount != "0")
            {
                $.each(data.notifications, function () {
                    var caseContent = null;
                    switch (this.content_type) {
                        case 0:
                            //some assigment
                            if(this.name === 'postBanned'){
                                caseContent = this.post.content.substr(0, 35);
                            }
                            else
                            {
                                caseContent = this.userprofile.name;
                            }
                            break;
                        case 1:
                            //some assigment
                            caseContent = this.post.content.substr(0, 35);
                            break;
                        default:
                            //some assigment
                            caseContent = this.comment.content.substr(0, 35);
                    }
                    var notification_name = this.name;

                    $('.notificationContainer').append(
                        '<a href="'+ this.url +'">' +
                        '<div class="notificationNode">' +
                        '<div class="notificationNode-header">' +
                        '<span>'+  name_translations[notification_name] +'</span>' +
                        '<span class="float-right">2019-05-04 16:00:47</span>' +
                        '</div>' +
                        '<div class="notificationNode-title">' +
                        title_translations[notification_name] +
                        '</div>' +
                        '<div>'+ caseContent +'</div>' +
                        '</div>' +
                        '</a>'
                    );
                });
            }
            else
            {
                $('.notificationContainer').html('<a class="dropdown-item pl-3 text-black-50">'+ title_translations.nonotificationsyet +'</a>');
            }
        },
        error: function (msg) {
            return false;
        }
    });

    setTimeout(function () {
        $('#notification-loader').css('display', 'none');
    }, 1000);
});
