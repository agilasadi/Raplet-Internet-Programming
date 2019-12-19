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


/*
 //calling


 $(".nightModeSpan").setNightModeToggle({
        "background": "#1b242d",
        "color": "#dedede",
        "additiveStyle": ".headersContainer,.headersContainer *,.sideHEadersBox,.sideHEadersBox *,.secondaryNav,.secondaryNav * {background: #1d2a36!important;}.interractWithPost{box-shadow:-6px 0 11px 0 #1d2a36!important;}.cookieFixer,.cookieFixer *{background:#1d2a36!important}.border-gray{border-color:#1b242d!important;}.articleBox{border:1px solid #1b242d!important;}.searchBox,.searchBox *,input,.btn,button,{background:#1b2732!important;background-color:#1b2732!important;}.innerSideHeaders::-webkit-scrollbar-thumb {background: #35495e;}.innerSideHeaders::-webkit-scrollbar-track {background: #273847;}.roundimg{border: 1px solid #35495e!important;}.searchDropdownHeader,.searchDropdownHeader *,.searchEntireAutocompleteResult,.searchEntireAutocompleteResult *{background:#1d2a36!important}.eachsearchrow{border-left: 3px solid #1b242d!important;border-top: 1px solid #1b242d!important;}.searchBoxTittle{background:#faebd700!important;}.profileBox,.profileBox *,.editableprofile{background:#1d2a36!important;}.card-header,.input-group-prepend,.input-group-text{background:#273745!important}.form-control{background-color:#1b242d!important;border-color:#273745!important;color:#dedede!important}#collapsePassInfo>.card{background:#1d2a36!important;}"
    });


    //span
     <a class="dropdown-item">
        {{ trans('home.NightMode') }}
        <span class="nightModeSpan">

        </span>
     </a>

*/

(function ($) {

    var globalOptions;

    $.fn.nightModeOn = function (prop) {

        // Default parameters
        var options = $.extend({
            "background": "black",
            "color": "white",
            "border": "white",
            "borderLeft": "white",
            "borderRight": "white",
            "borderBottom": "white",
            "borderTop": "white",
            "additiveStyle": ""
        }, prop);

        if ($(".asarNightModeStyle").length > 0) {

            nightModeOpen();
        } else {
            nightModeOff();
        }

        function nightModeOpen() {
            $("head").append(
                $("<style class='asarNightModeStyle' type='text/css'>" +
                    "header,body,footer,nav,div,button,a,p,h1,h2,h3,h4,h5,h6,image,span,i,input,.bg-white{" +
                    "background:" + options.background + "!important;" +
                    "background-color:" + options.background + "!important;" +
                    "color:" + options.color + " !important;" +
                    "border:" + options.border + ";" +
                    "border-left:" + options.borderLeft + ";" +
                    "border-right:" + options.borderRight + ";" +
                    "border-bottom:" + options.borderBottom + ";" +
                    "border-top:" + options.borderTop + ";" +
                    "}" + options.additiveStyle + "</style>"
                )
            );
            $.cookie('asar-night-mode', "on");
        }

        function nightModeOff() {
            $(".asarNightModeStyle").remove();
            $.cookie('asar-night-mode', "off");
        }


        return this;
    };

    $.fn.setNightModeToggle = function (prop) {

        // Default parameters
        var options = $.extend({
            "background": "black",
            "color": "white",
            "border": "white",
            "borderLeft": "white",
            "borderRight": "white",
            "borderBottom": "white",
            "borderTop": "white",
            "additiveStyle": ""
        }, prop);
        globalOptions = options;
        var selectedArea = $(this);

        setNightModeToggle();

        function setNightModeToggle() {

            var NMtoggleContainer = $("<div>", {
                "class": "nmToggle nmToggle-on"
            });

            var NMtoggle3 = $("<div>", {
                "class": "toggle3 toggle3-on",
                "id": "toggle3"
            });

            var NMcircle3 = $("<div>", {
                "class": "circle3 circle3-on",
                "id": "circle3"
            });

            NMtoggle3.on("click", function () {
                var toggle = document.getElementById("toggle3");
                var circle = document.getElementById("circle3");
                $(toggle).toggleClass("toggle3-on");
                $(circle).toggleClass("circle3-on");
                $("body").nightModeOn(options);
                setNightModeToggleStyles();

            });

            selectedArea.append(
                NMtoggleContainer.append(
                    NMtoggle3,
                    NMcircle3
                )
            );
            setNightModeToggleStyles();

            function setNightModeToggleStyles() {

                $('.toggle3').css({
                    'margin': '10px',
                    'height': '55px',
                    'width': '130px',
                    'background-color': 'skyblue!important',
                    'border-width': '5px',
                    'border-radius': '80px',
                    'border-style': 'solid',
                    'border-color': 'white',
                    'box-shadow': '0px 4px 5px 0px rgba(0, 0, 0, 0.05)',
                    'display': 'flex',
                    'align-items': 'center',
                    'transition': '0.2s ease-in-out'
                });

                $('.circle3').css({
                    'height': '45px',
                    'width': '45px',
                    'border-radius': '45px',
                    'background-color': 'white !important',
                    'margin': '0px 5px',
                    'transition': '0.2s ease-in-out',
                    'transform-origin': 'center',
                    'transform': 'rotate(-45deg)'
                });

                $('.toggle3-on').css({
                    'background-color': '#444'
                });

                $('.circle3-on').css({
                    'background-color': 'white !important',
                    ' margin-left': 'calc(78px + 45px /2)',
                    ' width': 'calc(45px /2)',
                    ' border-radius': '0px 45px 45px 0px',
                    ' transform-origin': 'left center',
                    ' transform': 'rotate(45deg)'
                });
            }
        }


        $("body").nightModeOn(globalOptions);

        return this;
    };


})(jQuery);


/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD (Register as an anonymous module)
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {

    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch (e) {
        }
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write

        if (arguments.length > 1 && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setMilliseconds(t.getMilliseconds() + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path ? '; path=' + options.path : '',
                options.domain ? '; domain=' + options.domain : '',
                options.secure ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {},
            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all. Also prevents odd result when
            // calling $.cookie().
            cookies = document.cookie ? document.cookie.split('; ') : [],
            i = 0,
            l = cookies.length;

        for (; i < l; i++) {
            var parts = cookies[i].split('='),
                name = decode(parts.shift()),
                cookie = parts.join('=');

            if (key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, {expires: -1}));
        return !$.cookie(key);
    };

}));