$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
$('.enterTrigger').on('keyup', function () {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        var enterFunction = $(this).parent().parent().data('enter');

        $("#" + enterFunction).click();
    }
});

$('.menuTogler').click(function () {
    $('.sideHEadersBox').toggleClass("leftTenPx");
    $('.crossButton').toggleClass('visibility');
    $(this).toggleClass('rightPositionNine');
});


$('#moreSideLoaderAnchor').click(function () {
    $(".rapletIsLoading").css('display', 'block');

    var page = $('.endless-pagination').data('next-page');

    if (page !== null) {

        clearTimeout($.data(this, "scrollCheck"));

        $.data(this, "scrollCheck", setTimeout(function () {
            $.get(page, function (data) {
                $('.paginatingSidePostsField').append(data.posts);
                $('.endless-pagination').data('next-page', data.next_page);

                if (data.next_page == null) {
                    $('#moreSideLoaderAnchor').css('display', 'none');
                }
            });
        }, 350))

    }
    $(".rapletIsLoading").css('display', 'none');
});

$('.commentExpander').click(function () {
    var content_id = $(this).data('content_id');
    $('#commentContent' + content_id).toggleClass("autoheight");
});

$(function () {
    'use strict';

    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.offcanvas-collapse').toggleClass('open')
    });

});


$(document).ready(function () {

    $(".dateTimeDefiner").humanoidDate({
        "daysAgo": daysAgo,
        "hoursAgo": hoursAgo,
        "years": daysAgo,
        "minsAgo": minsAgo,
        "justNow": justNow,
        "monthsTranslationArr": monthsTranslationArr
    });


});


$(document).ready(function () {
    var showChar = 250;
    var ellipsestext = "...";
    var moretext = showmore;
    var lesstext = showless;


    $('.commentContent').each(function () {
        var content = $(this).html();

        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").click(function () {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });

});


$('#myTab a').click(function (e) {
    e.preventDefault();
    $(this).tab('show');
});

// store the currently selected tab in the hash value
$("ul.nav-tabs > li > a").on("shown.bs.tab", function (e) {
    var theVisited = $(e.target).attr("href").substr(1);
    window.location.hash = theVisited;
});


// on load of the page: switch to the currently selected tab
$(document).ready(function () {
    var hash = window.location.hash;
    $('#myTab a[href="' + hash + '"]').tab('show');

    if($(".sencondaryNavInner").isHScrollable()){
        $(".btnSecondaryNavbarScroll").show();
        $(".secondaryNav").css({"padding-left":"20px", "padding-right":"20px"});
        $(".sencondaryNavInner").css({"margin": "0 15px"
        });
    }

    $("#secondaryNavbarLeftScroll").on("click",function(){
        var leftPos = $(".sencondaryNavInner").scrollLeft();
        $(".sencondaryNavInner").animate({scrollLeft: leftPos - 100}, 800);
    });

    $("#secondaryNavbarRightScroll").on("click",function(){
        var leftPos = $(".sencondaryNavInner").scrollLeft();
        $(".sencondaryNavInner").animate({scrollLeft: leftPos + 100}, 800);
    });


});





$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});





$.fn.isHScrollable = function () {
    return this[0].scrollWidth > this[0].clientWidth;
};