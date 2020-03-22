<footer>
    <div class="text-center text-black-50" style="padding:1rem">
        <div>&copy; <?php echo date('Y'); echo ' '; $this->options->owner(); ?> · Powered by Typecho · Theme by <a href="https://github.com/muzhou233/Morecho-Typecho">Morecho</a></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();
    </script>
    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.18.1/build/highlight.min.js"></script>
    <script src="<?php $this->options->themeUrl('asserts/js/SmoothScroll.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/js/Autolinker.min.js'); ?>"></script>
    
    <?php if ($this->is('post')||$this->is('page')): ?>
    <script src="<?php $this->options->themeUrl('asserts/js/clipboard.min.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/js/tocbot.min.js'); ?>"></script>
    <script>
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
    </script>
    <?php endif ?>
    
    <?php if ($this->is('archive')): ?>
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

    <script src="<?php $this->options->themeUrl('asserts/js/article.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('script.js'); ?>"></script>
    <script src="<?php $this->options->themeUrl('asserts/lib/plyr/plyr.polyfilled.min.js'); ?>"></script>
    <script>
        const player = new Plyr('#player', { controls: '' });
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
</footer>