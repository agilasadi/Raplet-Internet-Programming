$('.addonbtns').click(function () {
    $('.linkers-container').removeClass('d-none');
    $('.addonbtns').removeClass("on");
    $(this).toggleClass("on");
    var content_name = $(this).data('content_name');
    $('.linkenterence').removeClass('blocker');
    $("#" + content_name).toggleClass("blocker");
});

$('.closeLinkersDiv').click(function () {
    $('.linkers-container').addClass('d-none');
});

var linkerIndex = 0;
var jsonObj = [];
var linkerCount = 5;


$('.addtheextra').click(function () {
    var type = $(this).data('type');
    var idlinker = $(this).data('idlinker');
    var content = $("#" + idlinker).val();
    var visualname = $("#" + idlinker + 'v').val();
    var visualnamev = $("#" + idlinker + 'l').val();

    if (visualname === "") {
        visualname = content;
    }
    createLinks(type, visualname, visualnamev, content);
});

var createLinks = function (type, visualname, visualnamev, content) {

    linkerIndex = linkerIndex + 1;

    if (type === 'v') {


        $('.extraContentBead').append('<li class="videolinks linkchains"><a href="' + content + '" target="_blank" id="' + content + '">' + '<i class="fas fa-play"></i>&nbsp;&nbsp;' + visualname + '</a><button class="noBackgroundBtns linkerdeleter" data-linker_index="' + linkerIndex + '"><i class="fas fa-times"></i></button></li>');

        var item = {};
        item['text'] = visualname;
        item['url'] = content;
        item['type'] = "v";
        item['index'] = linkerIndex;
        jsonObj.push(item);
    } else if (type === 't') {

        $('.extraContentBead').append('<li class="tolooklinks linkchains"><a href="' + tolooklinksRoute + '/' + content + '" target="_blank" id="' + content + '">' + '<i class="fas fa-hashtag"></i>&nbsp;&nbsp;' + content + '</a><button class="noBackgroundBtns linkerdeleter" data-linker_index="' + linkerIndex + '"><i class="fas fa-times"></i></button></li>');
        var item = {};
        item['text'] = content;
        item['url'] = tolooklinksRoute + "/" + content;
        item['type'] = "t";
        item['index'] = linkerIndex;
        jsonObj.push(item);
    } else {

        if (visualnamev === "") {
            visualnamev = content;
        }

        $('.extraContentBead').append('<li class="linklinks linkchains"><a href="' + content + '" target="_blank" id="' + content + '">' + '<i class="fas fa-link"></i>&nbsp;&nbsp;' + visualnamev + '</a><button class="noBackgroundBtns linkerdeleter" data-linker_index="' + linkerIndex + '"><i class="fas fa-times"></i></button></li>');
        var item = {};
        item['text'] = visualnamev;
        item['url'] = content;
        item['type'] = "l";
        item['index'] = linkerIndex;
        jsonObj.push(item);
    }
    linkerDeleter();
    countLinkers(1);


};

var linkerDeleter = function () {
    $('.linkerdeleter').click(function (e) {
        $(e.currentTarget).parent("li").remove();
        var givenindex = $(this).data('linker_index');
        $.each(jsonObj, function (i, v) {
            if (v.index == givenindex) {
                jsonObj.splice(i, 1);
                countLinkers(0);
                return false;
            }
        });
    });
};


$('#enterYourCommentPlaceholder').focus(function () {

    commentSectionOpen();
});

$('#closeCommentSection').click(function () {
    commentSectionClose();
});

var commentSectionOpen = function () {
    $('.commentOutherBeforePlaceholder').fadeOut(200, function () {
        $('.commentOutherBeforePlaceholder').css('display', 'none');
        $('.commentSectionOuther').fadeIn(200, function () {
            $('.commentSectionOuther').addClass('visible');
            $('#commentContent').focus();
        });
    });


};

var commentSectionClose = function () {

    $('.commentSectionOuther').fadeOut(200, function () {
        $('.commentSectionOuther').removeClass('visible');

        $('.commentOutherBeforePlaceholder').fadeIn(200, function () {
            $('.commentOutherBeforePlaceholder').css('display', 'block');
        });
    });

};


$(".commentSectionOuther").click(function (e) {
    e.stopPropagation();
});


function countLinkers(action) {
    if (action === 1) {
        linkerCount = linkerCount - 1;
    }
    else {
        linkerCount = linkerCount + 1;
    }


    $(".addtheextra").attr("disabled", true);
    $(".addtheextra").addClass('disabled');
    $(".linkerObjectCounter").css('box-shadow', "0 0 0 0.2rem #f55666");

    if (linkerCount !== 0) {
        $(".addtheextra").attr("disabled", false);
        $(".addtheextra").removeClass('disabled');
        $(".linkerObjectCounter").css('box-shadow', "0 0 0 0.2rem rgb(220, 220, 220)");
    }

    $("#linkerObjectCounter").html(linkerCount);
}