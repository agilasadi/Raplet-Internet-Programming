

$(".scrollMyContent").click(function() {
    var mycontent = $(this).data('mycontent');


    $('html,body').animate({
            scrollTop: $("#" + mycontent).offset().top},
        'slow');
});




/*
 // When the user scrolls down 20px from the top of the document, slide down the navbar
 window.onscroll = function() {scrollFunction()};

 function scrollFunction() {
 if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
 document.getElementById("navbarish").style.top = "56px";
 } else {
 document.getElementById("navbarish").style.top = "-50px";
 }
 }
 */
/*
$(function() {
    $(window).scroll(sticktothetop);
    sticktothetop();
});

function sticktothetop() {
    var window_top = $(document).scrollTop();
    var top = $('#commentPost').offset().top;
    if (window_top > top) {
        $('.navbarish').addClass('stick');
    } else {
        $('#navbarish').removeClass('stick');
    }
}
*/


$(document).ready(function() {


    $(window).scroll(function() {
        var distanceFromTop = $(window).scrollTop();
        if(distanceFromTop > 600) {
            $(".navbarish").addClass("stick");
            $(".navbar").addClass("noShadow");
        }
        else {
            $(".navbarish").removeClass("stick");
            $(".navbar").removeClass("noShadow");
        }
    });
});
