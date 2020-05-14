console.log("%c%s%c%s",
    "color: white; background: #007bff; border: solid 1px #007bff; font-weight: bold; line-height: 1em; padding: .5em; border-top-left-radius: .5em; border-bottom-left-radius: .5em;",
    "Morecho",
    "color: #007bff; background: white; border: solid 1px #777; font-weight: bold; line-height: 1em; padding: .5em; border-top-right-radius: .5em; border-bottom-right-radius: .5em;",
    "by 沐雨橙舟");
console.log("%c%s%c%s",
    "color: white; background: #007bff; border: solid 1px #007bff; font-weight: bold; line-height: 1em; padding: .5em; border-top-left-radius: .5em; border-bottom-left-radius: .5em;",
    "访问",
    "color: #007bff; background: white; border: solid 1px #777; font-weight: bold; line-height: 1em; padding: .5em; border-top-right-radius: .5em; border-bottom-right-radius: .5em;",
    "typecho.mosar.in");

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
    $('#site-search input').bind('keydown',function(event){
        if(event.keyCode == "13")    
        {
            window.location.href = $('#site-search').attr('action') + $('#site-search input').val();
        }
    });
    $('#site-search div').click(function(){
        if($('#site-search input').val().length !== 0)
            window.location.href = $('#site-search').attr('action') + $('#site-search input').val();
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
    });

    $('.comment-list a[data-rel=delete]').on('click', function(){
        var e = $(this);
        toast('删除 '+$(this).parent().parent().find('.avatar').attr('alt')+' 的评论', '', '', 0, function(res){
            if(res === true)
                window.location.href = e.data('href');
        })
    })

    var cookies = Cookies.get();
    for(var k in cookies){
        if(k.slice(-21) !== '__typecho_notice_type') continue;
        if(cookies[k] === 'success')
            toast(unescape(cookies[k.slice(0, -21)+'__typecho_notice'].slice(2, -2).replace(/\\u/gi, '%u')));
        else
            toast(cookies[k], unescape(cookies[k.slice(0, -21)+'__typecho_notice'].slice(2, -2).replace(/\\u/gi, '%u')));
        Cookies.remove(k);
        Cookies.remove(k.slice(0, -21)+'__typecho_notice');
    }
})

function toast(title, content="", subtitle="", delay=5000, call=false){
    var autohide;
    if(delay === 0)autohide = 'false';
    else autohide = 'true';
    if(typeof call === 'function') content += '<div class="btn btn-link" data-value="true">确定</div><div class="btn btn-link" data-value="false">取消</div>'
    var toastItem = `
    <div class="toast card" data-autohide="${autohide}" data-delay="${delay}">
        <div class="toast-header">
            <strong class="mr-auto">${title}</strong>
            <small class="text-muted">${subtitle}</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            ${content}
        </div>
    </div>
    `
    $('#toast-wrap').append(toastItem);
    $('#toast-wrap > div:last-child').toast('show').on('hidden.bs.toast', function(){
        $(this).remove();
    }).find('div.btn').on('click', function(){
        if(typeof call === 'function')
            call($(this).data('value'));
        $(this).parents('.toast').toast('hide');
    });
}