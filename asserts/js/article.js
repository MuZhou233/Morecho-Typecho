window.article = function ($){
    window.setTimeout(function(){
        var headers = [];
        $('article h1,article h2,article h3,article h4,article h5').each(function(){
            if($(this).attr('id')===undefined)
                $(this).attr('id', $(this).text().replace(' ', '-'));
            headers.push($(this).attr('id'));
        });
        $('article h1,article h2,article h3,article h4,article h5').each(function(){
            var repeatHeaders = [];
            headers.sort().sort(function (a,b) {
                if(a === b && repeatHeaders.indexOf(a) === -1){
                    repeatHeaders.push(a);
                }
            })
            repeatHeaders.forEach(function(v){
                $('article #'+v).each(function(i){
                    $(this).attr('id', v+'-'+(i+1));
                })
            })
        })
    }, 0)
    
    window.setTimeout(function(){
        $('article p code').each(function(){
            var content = $(this).text();
            if(content[0] === '[' && content[content.length-1] === ']'){
                $(this).addClass('cover');
                $(this).text(content.slice(1,-1))
            }
        })
    })

    window.setTimeout(function(){
        var eachcount = $('article pre code').length;
        var url = document.scripts[document.scripts.length - 1].src;
        const worker = new Worker(url = url.substring(0, url.lastIndexOf('/'))+'/asserts/js/highlight-worker.js');
        $('article pre code').each(function(){
            var id;
            do{
                id = 'code-'+parseInt(Math.random()*10000);
            }while(document.getElementById(id))
            var copybtn = '<a class="copy-btn" data-clipboard-action="copy" data-clipboard-target="#'+id+'"><i data-feather="copy"></i></a>';
            $(this).attr('id',id).prepend(copybtn);
            feather.replace();

            $(this).addClass('hljs');
            worker.onmessage = (event) => { 
                $('#'+event.data[0]).get(0).innerHTML = event.data[1];
            }
            worker.postMessage(Array(id, $(this).text()));

            var lines = $(this).text().split('\n').length;
            var numbering = $('<ul/>').addClass('hljs').addClass('hljs-line-number');
            var headtags = ['H1','H2','H3','H4','H5'];

            $(this)
                .parent()
                .addClass('hljs').addClass('hljs-line-numbered')
                .prepend(numbering);
            if(lines > 2){
                $(this).parent().addClass('control-bar');
                var startnum = $(this).attr('data-startnum');
                if(startnum == undefined || parseInt(startnum) == NaN) startnum = 1; 
                else startnum = parseInt(startnum)
                for (i = 1; i <= lines; i++) {
                    numbering.append($('<li/>').text(i-1+startnum));
                }
            }
            if(headtags.indexOf($(this).parent().prev().prop('tagName')) >= 0 && $(this).parent().prev().text()[0] === '!'){
                $(this).parent().addClass('control-bar');
                var tagname = $(this).parent().prev().prop('tagName')
                var title = $(this).parent().prev().text().slice(1);
                $(this).parent().prepend('<'+tagname+' id="'+title+'" class="hljs-title">'+title+'</'+tagname+'>');
                $(this).parent().prev().remove();
            }
            eachcount--;
            if(eachcount == 0)
                try{
                var clipboard = new ClipboardJS('.copy-btn');
                clipboard.on('success', function(e) {
                    toast('复制成功');
                    e.clearSelection();
                }).on('error', function(e){
                    toast('复制失败');
                    e.clearSelection();
                });
                }catch(e){console.log(e)}
        })
    }, 0)
    
    window.setTimeout(function(){
        $('article img').each(function(){
            if($(this).attr('alt') === undefined || $(this).attr('alt').length === 0) return 0;
            var $imgalt = $('<div/>').addClass('alt').text($(this).attr('alt'));
            $(this).parent().append($imgalt);
            $(this).attr('alt',' ');
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
    }, 0)
    
    window.setTimeout(function(){
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
    }, 0)

    window.setTimeout(function(){
        $('article blockquote.card-meta').each(function(){
            var img = $(this).find('img').remove().get(0).outerHTML;
            var res = $(this).html();
            $(this).html(img+'<span>'+res+'</span>');
        })
        $('article blockquote.card-meta').find('img').bind('load',function(){
            $(this).after('<span class="card-meta-background" style="background-image:url('+$(this).prop('src')+')"></span>');
            var image = new Image()
            image.src = $(this).prop('src');
            var sizescale = image.width > image.height ? 1 : image.width/image.height;
            $(this).css('max-width', parseInt(sizescale*30)+'%');
        })
        try{
            lazyload(document.querySelectorAll('img.lazy'), {
                thresholds: "2000px 10%",
                use_native: true,
                cancel_on_exit: true
            });
        }catch(e){console.log(e)}
    }, 0)
    
    window.setTimeout(function(){
        try{
            tocbot.init({
                tocSelector: '.js-toc',
                contentSelector: '.js-toc-content',
                headingSelector: 'h1, h2, h3, h4',
                hasInnerContainers: true,
                scrollEndCallback: function(){
                    var padding = 5;
                    $('.js-toc-move').css('top', $('.is-active-li a').offset().top - $('.js-toc').offset().top - padding)
                    $('.js-toc-move').css('height', $('.is-active-li a').height() + padding*2)
                }
            });
        }catch(e){console.log(e)}
    }, 0)
    window.setTimeout(function(){
        try{
            /*
            $('article p').each(function(){
                $(this).html(Autolinker.link($(this).html()));
            })
            */
            $('article a').each(function(){
                var href = $(this).attr('href')+'';
                if(href !== 'undefined' && href.length > 0){
                    href = href.trim();
                    if(href.slice(0,4) === 'http' && href[4] != 's')
                        href = '<strong>不安全 http</strong>' + href.slice(4)
                    $(this).tooltipster({
                        contentAsHTML: true,
                        content: href,
                        theme: ['tooltipster-punk', 'tooltipster-punk-customized']
                    })
                }
            })
        }catch(e){console.log(e)}
    }, 0)
}