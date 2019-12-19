/*
Sample usage:

  $('.wordPostCompleteImage').previewModal();

$('.wordPostCompleteImage').previewModal({
    height: "70",
    width: "80",
    top: "10%",
    left: "10%"
});

 */


(function ($) {

    $.fn.previewModal = function (prop) {

        // Default parameters
        var options = $.extend({
            height: "98",
            width: "80",
            title: "JQuery Modal Box Demo",
            description: "Example of how to create a modal box.",
            top: "10px",
            left: "10%"
        }, prop);


        var width = $(window).width();
        $(window).on('resize', function () {
            if ($(this).width() != width) {
                width = $(this).width();
                $('.bg_overlay').click();
            }
        });

        this.css({
            "cursor": "zoom-in"
        });
        var imgSrc = this.attr("src");

        return this.click(function (e) {
            add_bg_overlay();
            add_popup_box();
            add_styles();
            $('.modal_box').fadeIn();
        });

        function add_styles() {
            $('.modal_box').css({
                'position': 'absolute',
                'left': options.left,
                'top': options.top,
                'display': 'none',
                'height': options.height + 'vh',
                'width': options.width + '%',
                'border-radius': '10px',
                '-moz-border-radius': '10px',
                '-webkit-border-radius': '10px',
                'z-index': '50'


            });
            $('.modal_box').attr("style",$('.modal_box').attr("style")+"background:url('" + imgSrc + "')no-repeat center center / contain !important");

            $('.modal_close').css({
                "position": "fixed",
                "cursor": "pointer",
                "text-shadow": "0 0 1px black",
                "border": "none",
                "color": "#ffffff",
                "top": "3%",
                "right": "4%",
                "border-radius": "50%",
                "background": "black",
                "font-size": "24px",
                "width": "40px",
                "height": "40px",
                "text-align": "center",
                "padding": "0"
            });

            $('.previewModalBody').css({
                'background-color': '#fff',
                'height': (options.height - 2) + '%',
                'width': (options.width - 2) + '%',
                'padding': '10px',
                'margin': '15px',
                'border-radius': '10px',
                '-moz-border-radius': '10px',
                '-webkit-border-radius': '10px'
            });

            $('.bg_overlay').css({
                'position': 'fixed',
                'top': '0',
                'left': '0',
                'background-color': 'rgba(0,0,0,0.6)',
                'height': $(document).height(),
                'width': $(window).width(),
                'z-index': '10000',
                "cursor": "zoom-out"
            });

            $('.previewImage').css({
                'width': '100%',
                'height': '100%',
                "object-fit": "contain"

            });
        }

        function add_popup_box() {

            var previewModal = $("<div>", {
                "class": "modal_box"
            });


            var previewModalA = $("<button>", {
                "class": "closerCross modal_close"
            });

            var previewModalIcon = $("<i>", {
                "href": "#",
                "class": "fas fa-times transitionSlow"
            });
            previewModal.append(
                previewModalA.append(
                    previewModalIcon
                )
            );
            $(previewModal).appendTo('.bg_overlay');

            $('.modal_close').click(function () {
                $(this).parent().fadeOut().remove();
                $('.bg_overlay').fadeOut().remove();
            });

        }

        function add_bg_overlay() {
            var block_page = $('<div>', {
                "class": "bg_overlay"
            });
            $(block_page).appendTo('body');

            $('.bg_overlay').click(function () {
                $('.bg_overlay').fadeOut().remove();
            });
        }

        return this;
    };

})(jQuery);