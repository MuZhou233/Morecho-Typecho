$(function(){
    $('body').attr('class', localStorage.getItem('theme'))
    $('.theme-control .col div').click(function(){
        $('body').attr('class',$(this).attr('class'))
        localStorage.setItem('theme', $(this).attr('class'))
    })

    $('article p code').each(function(){
        var content = $(this).text();
        if(content[0] === '[' && content[content.length-1] === ']'){
            $(this).addClass('cover');
            $(this).text(content.slice(1,-1))
        }
    })
    $('article p').each(function(){
        var reg = /([ \n]{1})(http|https)(:\/\/[\w\-_]+)(\.[\w\-_]+)+([\w\-\.,@?^=%&:/~\+#]*[\w\-\@?^=%&/~\+#])([ \n]{1})/g;
        content = $(this).html();
        //$(this).html(content.replace(reg, '$1<a href="$2$3$4$5">$1$2$3$4$5</a>$6'));
        $(this).html(Autolinker.link(content));
    })
    $('article a').each(function(){
        var href = $(this).attr('href').trim();
        if(href.slice(0,4) === 'http' && href[4] != 's')
            href = '<strong>不安全 http</strong>' + href.slice(4)
        $(this).tooltip({
            html: true,
            title: href
        })
    })
    $('article pre code').each(function () {
        var id;
        do{
            id = 'code-'+parseInt(Math.random()*10000);
        }while(document.getElementById(id))
        var copybtn = '<a class="copy-btn" data-clipboard-action="copy" data-clipboard-target="#'+id+'"><i data-feather="copy"></i></a>';
        $(this).attr('id',id).prepend(copybtn);
        feather.replace();
        new ClipboardJS('.copy-btn');

        var lines = $(this).text().split('\n').length - 1;
        var numbering = $('<ul/>').addClass('hljs').addClass('hljs-line-number');
        $(this)
            .parent()
            .addClass('hljs').addClass('hljs-line-numbered')
            .prepend(numbering);
        if(lines > 3){
            $(this).parent().addClass('control-bar')
            for (i = 1; i <= lines; i++) {
                numbering.append($('<li/>').text(i));
            }
        }
    });
    $('article img').each(function(){
        if($(this).attr('alt').length === 0) return 0;
        var $imgalt = $('<div/>').addClass('alt').text($(this).attr('alt'));
        $(this).parent().append($imgalt);
    })
    $('article thead').addClass('thead-light')
    $('article table').each(function(){
        var table = '<div class="table-responsive">'+$(this).addClass('table table-hover').prop('outerHTML')+'</div>'
        $(this).after(table).remove();
    })
    $('article input[type="checkbox"]').parent().each(function(){
        var input = $(this).children('input').addClass('custom-control-input').prop('outerHTML');
        $(this).children('input').remove();
        $(this).addClass('custom-checkbox')
        var label = $('<label/>').addClass('custom-control-label')
        $(this).prepend(label).prepend(input);
    })

    $('article blockquote').each(function(){
        if($(this).text().trim().slice(0,8) !== 'METACARD')return;
        $(this).addClass('card-meta')
        $(this).children('p:contains(METACARD)').remove();
        var img = $(this).find('img').first().prop('outerHTML')
        $(this).find('img').remove();
        $(this).find('.alt').remove();
        $(this).append(img)
    })

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
        $('.site-controls div[data-tab]').removeClass('active');
        $(this).addClass('active');
        $('.site-control div[data-tab]').removeClass('active');
        $('.site-control div[data-tab='+$(this).attr('data-tab')+']').addClass('active')
    })

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