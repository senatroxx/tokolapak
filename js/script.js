$(document).ready(function () {
    // $('#view').load('home.php',function() {
    //     $('#view').height($('.content2').height());
    //     return false;
    // });
    // $('.autoload a').click(function () {
    //     $('#view').height($('.content2').height());
    //     var hal = $(this).attr('href');
    //     $('#view').load(hal + '.php');
    //     return false;
    // });
    // function GetURLParameter(sParam) {
    //     var sPageURL = window.location.search.substring(1);
    //     var sURLVariables = sPageURL.split('&');
    //     for (var i = 0; i < sURLVariables.length; i++) {
    //         var sParameterName = sURLVariables[i].split('=');
    //         if (sParameterName[0] == sParam) {
    //             return sParameterName[1];
    //         }
    //     }
    // }​
    // let page = GetURLParameter('page');


    let position = $(window).scrollTop();
    $(window).scroll(function() {
        let scroll = $(window).scrollTop();
        if(scroll > position){
            $('.topmenu').css("top", "-45px");
        }else{
            $('.topmenu').css("top", "0px");
        }
        position = scroll;
    });

    (function () {

        $('.shopping-cart').each(function () {
            var delay = $(this).index() * 50 + 'ms';
            $(this).css({
                '-webkit-transition-delay': delay,
                '-moz-transition-delay': delay,
                '-o-transition-delay': delay,
                'transition-delay': delay
            });
        });
        $('#cart, .shopping-cart').hover(function (e) {
            $(".shopping-cart").stop(true, true).addClass("active");
        }, function () {
            $(".shopping-cart").stop(true, true).removeClass("active");
        });
    })();

    (function () {
        $('.dropdown, .dropdown-content').hover(function (e) {
            $(".dropdown-content").stop(true, true).addClass("active");
        }, function () {
            $(".dropdown-content").stop(true, true).removeClass("active");
        });
    })();

    $(document).ready(function () {
        $('[data-toggle="toggle"]').change(function () {
            $(this).parents().next('.hide').toggle();
        });
    });
    // $(".description").text(function (index, currentText) {
    //     return currentText.substr(0, 25);
    // });
})
