var wto;
var resultcounter = 0;
var postiimglink = '';

$(document).on('keyup', '#search', function () {

    event.preventDefault();
    var contentCheck = $.trim($('#search').val());

    if (contentCheck.length > 0) {

        $('#searcheAutocompleteDiv').css("display", 'block');
        $('#search').addClass("connectedfromTop");
        $("#searchSubmitButton").css('color', '#41b983');

        $("#searchConnectionIcon").css('display', 'block');

        var content = $("#search").val();


        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            hardSearch();
        }
        $("#searchSubmitButton").attr('disabled', false);

        $('#searchingword').text(content);
        clearTimeout(wto);
        wto = setTimeout(function () {


            $.ajax({
                url: navSearch,
                method: "POST",
                data: {
                    content: content,
                    _token: token
                },
                success: function (data) {
                    $('#searchResultAutocompleteCount').text(data.count);

                    resultcounter = data.count;
                    $(".searchNavPostResults").empty();
                    $(".searchNavCommentResults").empty();
                    $(".searchNavUserResults").empty();

                    if (data.postcount > 0) {
                        $('.searchNavPostResults').append('<div class="searchResultTitles">' + headingTransName + '</div>');
                        $.each(data.posts, function () {
                            if (this.type == 1) {
                                postiimglink = '<div class="searchPostImages"><img src="' + data.postimgurl + '/' + this.postmedia.image + '"></div>';
                            }
                            else {
                                postiimglink = '';
                            }
                            $('.searchNavPostResults').append('<div class="foundthreepost eachsearchrow transitionSlow">' +
                                '<a class="transitionSlow" href="' + data.postlink + '/' + this.slug + '">' + postiimglink +
                                '<div class="postTitle">' + this.content + '</div>' +
                                '<div class="postDetails transitionSlow">' +
                                '<div>' +
                                '<button class="searchButtons" disabled><i class="fas fa-heart" ></i>&nbsp;&nbsp;<span>' + this.likecount + '</span></button>' +
                                '<button class="searchButtons" disabled><i class="far fa-comment-alt"></i>&nbsp;&nbsp;<span>' + this.entrycount + '</span></button>' +
                                '<button class="searchButtons" disabled>@<span>' + this.userprofile.slug + '</span></button>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '</div>');
                        });
                    }
                    if (data.commentcount > 0) {
                        $('.searchNavCommentResults').append('<div class="searchResultTitles">' + entryTransName + '</div>');
                        $.each(data.comments, function () {
                            $('.searchNavCommentResults').append('<div class="foundthreecomment eachsearchrow transitionSlow">' +
                                '<a class="transitionSlow" href="' + data.commentlink + '/' + this.slug + '">' +
                                '<div class="postTitle commentSearchTitle">' + this.content + '</div>' +
                                '<div class="postDetails transitionSlow">' +
                                '<div>' +
                                '<button class="searchButtons" disabled><i class="fas fa-chevron-up"></i>&nbsp;&nbsp;<span>' + this.likecount + '</span></button>' +
                                '<button class="searchButtons" disabled><i class="fas fa-chevron-down"></i>&nbsp;&nbsp;<span>' + this.dislikecount + '</span></button>' +
                                '<button class="searchButtons" disabled>@<span>' + this.userprofile.slug + '</span></button>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '</div>');
                        });
                    }
                    if (data.usercount > 0) {
                        $('.searchNavUserResults').append('<div class="searchResultTitles">' + userTransName + '</div>');
                        $.each(data.users, function () {
                            $('.searchNavUserResults').append('<div class="foundthreeuser eachsearchrow transitionSlow">' +
                                '<a class="transitionSlow" href="' + data.userlink + '/' + this.slug + '">' +
                                '<div class="searchUserImages"><img src="' + data.userimgurl + '/' + this.userImg + '"></div>' +
                                '<div class="postTitle">' + this.name + '</div>' +
                                '<div class="postDetails transitionSlow">' +
                                '<div class="interactWithAPost">' +
                                '<button class="searchButtons" disabled><span>@' + this.slug + '</span></button>' +
                                '<button class="searchButtons" disabled>•&nbsp;<span>' + this.reputation + '</span></button>' +
                                '</div>' +
                                '</div>' +
                                '</a>' +
                                '</div>');
                        });
                    }


                    $("#searchConnectionIcon").css('display', 'none');

                    if (resultcounter < 1) {
                        $(".searchNavPostResults").empty();
                        $(".searchNavCommentResults").empty();
                        $(".searchNavUserResults").empty();
                        $("#searchConnectionIcon").css('display', 'none');
                    }
                }
            })
        }, 1000);


        $("#searchSubmitButton").addClass('right26px');
        $("#btnAutocompleteClose").show();

    }
    else {
        $("#searchSubmitButton").attr('disabled', true);
        $("#searchConnectionIcon").css('display', 'none');
        killAutoComplete();
    }
});


//Search field hide when clicking outside of the form
$(document).click(function () {
    killAutoComplete();

});


var killAutoComplete = function () {
    $("#searcheAutocompleteDiv").css("display", 'none');
    $('#search').removeClass("connectedfromTop");
    $("#searchSubmitButton").css('color', '#2a567d').removeClass('right26px');
    $("#btnAutocompleteClose").hide();
};

//Prevent search hiding when clicking inside the form
$("#navbarSearchForm").click(function (e) {
    e.stopPropagation();
});

// preventing Enter from getting ahead of itself
$(document).ready(function () {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $("#btnAutocompleteClose").on("click", function () {
        killAutoComplete();
    })
});

function hardSearch() {
    var searchRequest = $("#search").val();

    $.ajax({
        type: "POST",
        url: checkSearch,
        data: {
            searchRequest: searchRequest,
            _token: token
        },
        success: function (data) {
            window.location = data.searchlink + '/' + data.searched;
        },
        error: function (data) {
        }
    });
}
