// usage sample:
// WriteMessageCokkieByHours("messageSend",2");
var viewedkeeper;
function WriteMessageCokkieByHours( message, hours) {
    var date = new Date();
    date.setHours(date.getHours() + hours);
    $.cookie(message, "OK", { expires: date });
}

$( document ).ready(function () {


    if($.cookie("messageShown")!=="OK"){
        $.ajax({
            type: "GET",
            url: getNewMessageServiceUrl,
            data: {
                _token: token
            },
            success: function(data) {
                if (data.success === '1' ){
                    var object = $.extend({}, data.notSeenKeepers, data.nativeKeeper);
                    viewedkeeper = data.notSeenKeepers.id;
                    $('#messengermodel').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                    $('#messagingcontent').append(object.content);
                    if (object.link_text != 0) {
                        $('#messagelink').append(object.link_text + "&nbsp;&nbsp;&nbsp;&nbsp;<i class=\"fas fa-external-link-alt\"></i>");
                        $("#messagelink").attr("href", object.link_url);
                        $(".messengerbtns").css("display", "block");
                    }

                    switch(object.type) {
                        case '0':
                            $('#regularmsgfooter').css("display", "flex");
                            $('#messagemodellabel').append('<i class="fas fa-info-circle"></i>&nbsp;&nbsp;' + name_translations.info);
                            break;
                        default:
                            $('#termsacceptfooter').css("display", "flex");
                            $('#messagemodellabel').append("<i class=\"fas fa-balance-scale\"></i>&nbsp;&nbsp;" + name_translations.privacyAndTerms);
                    }

                    WriteMessageCokkieByHours("messageSend",2);
                }
                else {
                }
            },
            error: function(data) {
            }
        });
    }
});

$(".iapprovethis").click(function (){
    $.ajax({
        type: "GET",
        url: keeperapproval,
        data: {
            viewedkeeper: viewedkeeper,
            _token: token
        },
        success: function(data) {
            if (data.success === "1"){
                $('#messengermodel').modal('toggle');
            }
            else {
                $('#messengermodel').modal();
                $.toast({
                    text: "Error!",
                    showHideTransition: 'fade',
                    allowToastClose: true,
                    hideAfter: 2000,
                    stack: 5,
                    position: 'bottom-left',
                    textAlign: 'left',
                    loader: true,
                    loaderBg: 'red'
                });
            }
        },
        error: function(data) {
        }
    });
});



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

