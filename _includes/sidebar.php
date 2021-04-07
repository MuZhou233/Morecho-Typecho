<div class="dynamic-hide">
<?php if(!$this->is('author')): ?>
<div class="card card-author-meta">
    <div class="title">站点信息</div>
    <div class="site-meta row text-center">
        <div class="col-4">
            <div><?php echo get_post_num(); ?></div>
            <div>文章</div>
        </div>
        <div class="col-4">
            <div><?php echo get_comment_num(); ?></div>
            <div>评论</div>
        </div>
        <div class="col-4">
            <div><?php echo get_last_update(); ?></div>
            <div>更新</div>
        </div>
    </div>
</div>
<?php elseif(get_user($this->_archiveSlug)['group'] !== 'subscriber'): ?>
<div class="card card-site-meta">
    <div class="title">作者信息</div>
    <div class="site-meta row text-center">
        <div class="col-4">
            <div><?php echo get_post_num($this->_archiveSlug); ?></div>
            <div>文章</div>
        </div>
        <div class="col-4">
            <div><?php echo get_comment_num($this->_archiveSlug); ?></div>
            <div>评论</div>
        </div>
        <div class="col-4">
            <div><?php 
            $last_logged = get_user($this->_archiveSlug)['logged'];
            if($last_logged == 0) echo '从未';
            else echo date('y/m/d', $last_logged); 
            ?></div>
            <div>上次登录</div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($this->is('post')||$this->is('page') && (!array_key_exists('is_archive', $GLOBALS) || !$GLOBALS['is_archive'])): ?>
<div class="card card-post-meta">
    <div class="title">文章信息</div>
    <div class="site-meta row text-center">
        <div class="col-4">
            <div><?php echo (string)mb_strlen(str_replace(PHP_EOL,'',strip_tags(preg_replace('/(<code.*?>[\s|\S]*?<\/code>)/', '', $this->content))),'utf-8'); ?></div>
            <div>字数</div>
        </div>
        <div class="col-4">
            <div><?php echo date('y/m/d', $this->created) ?></div>
            <div>创建</div>
        </div>
        <div class="col-4">
            <div><?php echo date('y/m/d', $this->modified) ?></div>
            <div>修改</div>
        </div>
    </div>
    <ul class="category"><li><i data-feather="folder"></i>
        <?php $this->category('</li><li><i data-feather="folder"></i>'); ?>
    </li></ul>
    <div class="tags">
        <?php $this->tags(' ', true, ''); ?>
    </div>
</div>
<?php endif ?>
</div>

<?php if($this->options->musicUrl): ?>
<div class="card card-musicbox">
    <audio id="player"><source src="<?php $this->options->musicUrl(); ?>" type="audio/mp3" /></audio>
    <?php if($this->options->musicName): ?><div style="padding-bottom: 1rem"><?php $this->options->musicName(); ?></div><?php endif ?>
    <div class="music-controls paused">
        <!--span class="backward"><i data-feather="chevrons-left"></i></span-->
        <span class="pause"><i data-feather="pause"></i></span>
        <span class="play"><i data-feather="play"></i></span>
        <!--span class="forward"><i data-feather="chevrons-right"></i></span-->
        <span class="loading" style="display:none"><i data-feather="loader"></i></span>
        <div class="progress">
            <div class="progress-bar" role="progressbar"></div>
            <div class="progress-bar" role="progressbar" style="background-color: rgba(0,123,255,0.2)"></div>
        </div>
    </div>
</div>
<?php endif ?>

<?php if (($this->is('post') || $this->is('page')) && (!array_key_exists('is_archive', $GLOBALS) || !$GLOBALS['is_archive'])): ?>
<div class="card card-toc">
    <div class="js-toc-move"></div>
    <div class="js-toc toc"></div>
</div>
<?php endif ?>