
/*
Sample usage:

    var monthsTranslationArr = [
        '{{trans('home.jenuary')}}',
        '{{trans('home.february')}}',
        '{{trans('home.march')}}',
        '{{trans('home.april')}}',
        '{{trans('home.may')}}',
        '{{trans('home.june')}}',
        '{{trans('home.july')}}',
        '{{trans('home.august')}}',
        '{{trans('home.september') }}',
        '{{trans('home.october')}}',
        '{{trans('home.november')}}',
        '{{trans('home.december')}}'

    ];
    var daysAgo = '{{ trans('home.daysago') }}';
    var hoursAgo = '{{ trans('home.hoursago') }}';
    var minsAgo = '{{ trans('home.minsAgo') }}';
    var justNow= '{{ trans('home.justNow-low') }}';


$(".dateTimeDefiner").humanoidDate({
    "daysAgo":daysAgo,
    "hoursAgo":hoursAgo,
    "years":daysAgo,
    "minsAgo":minsAgo,
    "justNow":justNow,
    "monthsTranslationArr":monthsTranslationArr
});


 */




(function($) {

    $.fn.humanoidDate = function(reqs) {

        var thisDateTexts=this;
        var now = new Date();

        for (var x = 0; x < thisDateTexts.length; x++) {
            var thisTimeText = $(thisDateTexts[x]).text();
            var timeOffsetDifference=Math.abs(now.getTimezoneOffset()/60);
            var postDate = new Date(thisTimeText);

            var timeDifference = new Date(now - postDate);
            timeDifference.setHours(timeDifference.getHours()-timeOffsetDifference);

            var mins = Math.abs(Math.round(timeDifference / 100000));
            var hours = Math.abs(Math.round(timeDifference / 36e5));
            var days = Math.round(hours / 24);
            var months = Math.round(days / 30);
            var years = Math.round(months / 12);

            var selectedDate;
            if (years > 0) {
                var newYear=postDate.getYear()+1900;
                selectedDate = postDate.getDate()+" "+monthsTranslationArr[postDate.getMonth()]+" "+newYear ;
            } else if (months > 0) {
                selectedDate = postDate.getDate()+" "+ reqs.monthsTranslationArr[(postDate.getMonth())];
            } else if (days > 0) {
                selectedDate = days + " "+reqs.daysAgo;
            }else if (hours > 0) {
                selectedDate = days + " "+reqs.hoursAgo;
            }else if (mins > 0) {
                selectedDate = mins+ " " +reqs.minsAgo;
            } else {
                selectedDate = reqs.justNow;
            }

            $(thisDateTexts[x]).text(selectedDate);

        }

    }

}(jQuery));