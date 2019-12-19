function toggle3() {
    var toggle = document.getElementById("toggle3");
    var circle = document.getElementById("circle3");
    $(toggle).toggleClass("toggle3-on");
    $(circle).toggleClass("circle3-on");
    if ($(".toggle3-on").length > 0) {
        $.cookie('nightMode', "on");
        $('.nightModeStyle').prop('disabled', false);
    } else {
        $.cookie('nightMode', "off");
        $('.nightModeStyle').prop('disabled', true);
    }
}
