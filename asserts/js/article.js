window.article = function ($){
    $('article pre code').each(function(){
        $(this).html(hljs.highlightAuto($(this).text()).value);
        $(this).addClass('hljs')
    })
    $('article p code').each(function(){
        var content = $(this).text();
        if(content[0] === '[' && content[content.length-1] === ']'){
            $(this).addClass('cover');
            $(this).text(content.slice(1,-1))
        }
    })
    try{
        $('article p').each(function(){
            $(this).html(Autolinker.link($(this).html()));
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
    }catch(e){}
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
        if($(this).parent().hasClass('table-responsive') === 'false') return;
        var table = '<div class="table-responsive">'+$(this).addClass('table table-hover').prop('outerHTML')+'</div>'
        $(this).after(table).remove();
    })
    $('article table tr [align]').each(function(){
        if($(this).attr('align') === 'right')$(this).css('text-align', 'right');
        if($(this).attr('align') === 'center')$(this).css('text-align', 'center');
        if($(this).attr('align') === 'left')$(this).css('text-align', 'left');
    })
    $('article ul').each(function(){
        if($(this).children('li').hasClass('custom-checkbox'))return;
        var str = $(this).text().trim().slice(0,3);
        if(str !== '[ ]' && str !=='[x]') return;
        $(this).children('li').each(function(){
            var html = $(this).html().trim();
            html = html.replace(/\[ \]/g, '<input type="checkbox" class="task-list-item-checkbox" disabled="disabled" />')
            html = html.replace(/\[\x\]/g, '<input type="checkbox" class="task-list-item-checkbox" disabled="disabled" checked="checked" />')
            $(this).html(html);
        });
    })
    $('article input[type="checkbox"]').parent().each(function(){
        var input = $(this).children('input').addClass('custom-control-input').prop('outerHTML');
        $(this).children('input').remove();
        var label = $('<label/>').addClass('custom-control-label')
        $(this).prepend(label).prepend(input);
        if($(this).prop('tagName') !== 'LI')
            $(this).parent('li').addClass('task-list-item custom-checkbox')
                .parent('ul').addClass('task-list');
        else $(this).addClass('task-list-item custom-checkbox')
                .parent('ul').addClass('task-list');
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
}