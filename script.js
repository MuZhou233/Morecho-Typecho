$(function(){
    $('body').attr('class', localStorage.getItem('theme'))
    $('.theme-control .col div').click(function(){
        $('body').attr('class',$(this).attr('class'))
        localStorage.setItem('theme', $(this).attr('class'))
    })

    article($);

    $('.search input').focus(function(){
        $('.search').addClass('active');
    }).blur(function(){
        $('.search').removeClass('active');
    })

    $('.card-sidebar-control').click(function(){
        if($('.sidebar').hasClass('active'))
            $('.sidebar').removeClass('active');
        else $('.sidebar').addClass('active');
    })
    $('.card-fullscreen-control').click(function(){
        if($('body').hasClass('fullscreen'))
            $('body').removeClass('fullscreen');
        else $('body').addClass('fullscreen');
    })
    var lastWindowWidth = 0;
    $(window).resize(function(){
        if($(window).width() === lastWindowWidth || $(window).width() >= 768) return;
        lastWindowWidth = $(window).width();
        $('body').removeClass('fullscreen');
        $('.sidebar').removeClass('active');
    })

    $('.site-controls div[data-tab]').click(function(){
        localStorage.setItem('site-controls', $(this).attr('data-tab'));
        $('.site-controls div[data-tab]').removeClass('active');
        $(this).addClass('active');
        $('.site-control div[data-tab]').removeClass('active');
        $('.site-control div[data-tab='+$(this).attr('data-tab')+']').addClass('active')
    });
    $('.site-controls div[data-tab='+localStorage.getItem('site-controls')+']').trigger('click');

    var dynamicHideHeight = $('.dynamic-hide').height();
    var dynamicHideStat = false;
    var lastScrollH = 0;
    $('.dynamic-hide').parent().css('transition','transform 0.3s ease 0s')
    $(window).scroll(function(){
        var offset = 200;
        var thisScrollH = $(this).scrollTop()
        if( (thisScrollH > lastScrollH && thisScrollH - offset < lastScrollH) ||
            (thisScrollH < lastScrollH && thisScrollH + offset > lastScrollH) )return;
        if($(window).width() < 992 || (dynamicHideStat === true && thisScrollH < lastScrollH)){
            $('.dynamic-hide').removeClass('active').parent().css('transform','translateY(0)');
            dynamicHideStat = false;
        }else if(dynamicHideStat === false && thisScrollH > lastScrollH){
            $('.dynamic-hide').addClass('active').parent().css('transform','translateY(-'+(dynamicHideHeight + 18)+'px)');
            dynamicHideStat = true;
        }
        lastScrollH = thisScrollH;
    })
})