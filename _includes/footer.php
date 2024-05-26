<footer>
    <div class="footer-copyright text-center text-black-50" style="padding:1rem">
        <div>
            <?php if(strlen($this->options->footerCopyright)>0): echo $this->options->footerCopyright; else: ?>
            <div>&copy; <?php echo date('Y'); echo ' '; $this->options->owner(); ?> · Powered by Typecho · Theme by <a href="https://github.com/muzhou233/Morecho-Typecho">Morecho</a></div>
            <?php endif ?>
        </div>
        <div style="display: none;">
            <?php 
                if(strlen($this->options->footerCopyrightPrint)>0) echo $this->options->footerCopyrightPrint;
                else if(strlen($this->options->footerCopyright)>0): echo $this->options->footerCopyright; else: ?>
                <div>&copy; <?php echo date('Y'); echo ' '; $this->options->owner(); ?> · Powered by Typecho · Theme by <a href="https://github.com/muzhou233/Morecho-Typecho">Morecho</a></div>
            <?php endif ?>
        </div>
    </div>
    <script src="<?php echo get_libUrl('assets/lib/jquery-3.4.1.slim.min.js', 'https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.slim.min.js'); ?>"></script>
    <script src="<?php echo get_libUrl('assets/lib/js.cookie.min.js', 'https://cdn.jsdelivr.net/npm/js-cookie@2.2.1/src/js.cookie.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo get_libUrl('assets/lib/tooltipster/tooltipster.bundle.min.css', 'https://cdn.jsdelivr.net/npm/tool-tip@4.2.5/dist/css/tooltipster.bundle.min.css'); ?>"></link>
    <link rel="stylesheet" href="<?php echo get_libUrl('assets/lib/tooltipster/theme/tooltipster-sideTip-punk.min.css', 'https://cdn.jsdelivr.net/npm/tool-tip@4.2.5/dist/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-punk.min.css'); ?>"></link>
    <script src="<?php echo get_libUrl('assets/lib/tooltipster/tooltipster.bundle.min.js', 'https://cdn.jsdelivr.net/npm/tool-tip@4.2.5/dist/js/tooltipster.bundle.min.js'); ?>"></script>
    <script src="<?php echo get_libUrl('assets/lib/feather.min.js'); ?>"></script>
    <script>
        feather.replace();
    </script>
    <?php
        if($this->options->mathEnable === "true"): 
            if(!empty($this->options->mathCustom)):
            ?>
            <script>
                <?php echo $this->options->mathCustom; ?>
            </script>
            <script async src="<?php echo get_libUrl('', 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/startup.js'); ?>"></script>
        <?php else: ?>
            <script async src="<?php echo get_libUrl('assets/lib/tex-mml-chtml.js', 'https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js'); ?>"></script>
        <?php endif; ?>
    <?php endif; ?>
    <script src="<?php echo get_libUrl('assets/lib/SmoothScroll.min.js'); ?>"></script>
    <script src="<?php echo get_libUrl('assets/lib/pangu.min.js', 'https://cdn.jsdelivr.net/npm/pangu@4.0.7/dist/browser/pangu.min.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            pangu.autoSpacingPage();
        });
    </script>
    
    <?php if (($this->is('post')||$this->is('page')) && (!array_key_exists('is_archive', $GLOBALS) || !$GLOBALS['is_archive'])): ?>
    <script src="<?php echo get_libUrl('assets/lib/clipboard.min.js', 'https://cdn.jsdelivr.net/npm/clipboard@2.0.6/dist/clipboard.min.js'); ?>"></script>
    <script src="<?php echo get_libUrl('assets/lib/tocbot.min.js', 'https://cdn.jsdelivr.net/npm/tocbot@4.12.0/dist/tocbot.min.js'); ?>"></script>
    <?php endif ?>

    <?php if(($this->is('page') || $this->is('post')) && $this->fields->textIndent === 'true'): ?>
    <script>$(function(){$('article p > br').after('<span style="margin-left: 2em;"></span>');});</script>
    <style>article p{text-indent: 2em;}article p>img{transform:translateX(-2rem);}</style>
    <?php endif; ?>

    <script src="<?php echo get_libUrl('assets/lib/lazyload.min.js', 'https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('assets/js/article.js'); ?>"></script>
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/lib/highlight/vscode.css'); ?>">
    <script src="<?php $this->options->themeUrl('script.js'); ?>"></script>

    <?php if (array_key_exists('is_archive', $GLOBALS) && $GLOBALS['is_archive']): ?>
    <script src="<?php $this->options->themeUrl('assets/js/archive.js') ?>"></script>
    <script>
        $(function () {
            $.fn.tagcloud.defaults = {
                color: { start: '#95C7E0', end: '#3CC4C5' },
            };
            $('#tag_cloud a').tagcloud();
        })
    </script>
    <?php endif ?>

    <?php if($this->options->blurCard === "true"): ?>
    <style>
    .card{
        backdrop-filter: blur(10px) saturate(1.8);
        background-color: rgba(255,255,255,.75);
    }
    </style>
    <?php endif; ?>
    <?php if($this->options->musicUrl): ?>
    <script src="<?php echo get_libUrl('assets/lib/plyr/plyr.min.js', 'https://cdn.jsdelivr.net/npm/plyr@3.6.3/dist/plyr.min.js'); ?>"></script>
    <script>
        const player = new Plyr('#player', { controls: '',loadSprite: false });
        /*
        player.source = {
            type: 'audio',
            sources: [
                {
                    src: '/assets/lib/plyr/test.mp3',
                    type: 'audio/mp3',
                },
            ],
        };
        */
        $('.music-controls .play').click(function () {
            player.play();
            $('.music-controls').removeClass('paused');
            $('.music-controls .loading').css('display', 'unset');
        })
        $('.music-controls .pause').click(function () {
            player.pause();
            $('.music-controls').addClass('paused');
        })
        $('.music-controls .progress').click(function (e) {
            var progress = (e.clientX - $(this).offset().left) / $(this).width();
            player.currentTime = parseInt(progress * player.duration);
            $('.music-controls .play').click();
        })
        player.on('ended', function () {
            $('.music-controls').addClass('paused');
        });
        player.on('timeupdate', function () {
            $('.music-controls .loading').css('display', 'none');
            if (player.duration == 0)
                var progress = 0;
            else
                var progress = parseInt(player.currentTime * 100 / player.duration);
            $('.music-controls .progress-bar:first-child').css('width', progress + '%')
            restbuffered = parseInt(player.buffered * 100) - progress
            $('.music-controls .progress-bar:last-child').css('width', restbuffered + '%')
            setTimeout(function (progress) {
                if (progress + '%' === $('.music-controls .progress-bar:first-child').css('width'))
                    $('.music-controls .loading').css('display', 'unset');
                else
                    $('.music-controls .loading').css('display', 'none');
            }, 2000)
        })
    </script>
    <?php endif; ?>
    <?php $this -> footer(); ?>
</footer>