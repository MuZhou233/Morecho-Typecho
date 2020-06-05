<footer>
    <div class="text-center text-black-50" style="padding:1rem">
        <?php if(strlen($this->options->footerCopyright)>0): echo $this->options->footerCopyright; else: ?>
        <div>&copy; <?php echo date('Y'); echo ' '; $this->options->owner(); ?> · Powered by Typecho · Theme by <a href="https://github.com/muzhou233/Morecho-Typecho">Morecho</a></div>
        <?php endif ?>
    </div>
    <script src="<?php $this->options->themeUrl('asserts/lib/jquery-3.4.1.slim.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/js.cookie.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/bootstrap/popper.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/bootstrap/bootstrap.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/feather.min.js'); ?>"></script>
    <script>
        feather.replace();
    </script>
    <script src="<?php $this->options->themeUrl('asserts/lib/highlight/highlight.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/SmoothScroll.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/Autolinker.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/pangu.min.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            pangu.autoSpacingPage();
        });
    </script>
    
    <?php if (($this->is('post')||$this->is('page')) && (!array_key_exists('is_archive', $GLOBALS) || !$GLOBALS['is_archive'])): ?>
    <script src="<?php $this->options->themeUrl('asserts/lib/clipboard.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/tocbot.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/lazyload.min.js'); ?>"></script>
    <?php endif ?>

    <?php if(($this->is('page') || $this->is('post')) && $this->fields->textIndent === 'true'): ?>
    <script>$(function(){$('article p > br').after('<span style="margin-left: 2em;"></span>');});</script>
    <style>article p{text-indent: 2em;}</style>
    <?php endif; ?>

    <script src="<?php $this->options->themeUrl('asserts/js/article.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('script.js'); ?>"></script>

    <?php if (array_key_exists('is_archive', $GLOBALS) && $GLOBALS['is_archive']): ?>
    <script src="<?php $this->options->themeUrl('asserts/js/archive.js') ?>"></script>
    <script>
        $(function () {
            $.fn.tagcloud.defaults = {
                color: { start: '#95C7E0', end: '#3CC4C5' },
            };
            $('#tag_cloud a').tagcloud();
        })
    </script>
    <?php endif ?>

    <script src="<?php $this->options->themeUrl('asserts/lib/plyr/plyr.polyfilled.min.js'); ?>"></script>
    <script>
        const player = new Plyr('#player', { controls: '',loadSprite: false });
        /*
        player.source = {
            type: 'audio',
            sources: [
                {
                    src: '/asserts/lib/plyr/test.mp3',
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
    <?php $this -> footer(); ?>
</footer>