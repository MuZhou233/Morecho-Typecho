<?php
/**
 * archive
 * 
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('_layouts/default-0.php');
 ?>

<h1 class="title">
<?php $this->archiveTitle(array(
    'category'  =>  _t('分类 %s 下的文章'),
    'search'    =>  _t('包含关键字 %s 的文章'),
    'tag'       =>  _t('标签 %s 下的文章'),
    'author'    =>  _t('%s 发布的文章')
), '', ''); ?>
</h1>

<?php
if($this->is('search'))$article = $this;
else $article = $this->widget('Widget_Contents_Post_List');
?>

<!--
<div id='tag_cloud' class="tags js-tags">
    <a class="tag-button--all" data-encode="">
        Show All
        <sup>{{site.posts.size}}</sup>
    </a>

    {% capture tags %}
    {% for tag in site.tags %}
    <a data-sort="{{ site.posts.size | minus: tag[1].size | prepend: '0000' | slice: -4, 4 }}"
        data-encode="{{ tag[0] | strip | url_encode }}" class="tag-button" title="{{ tag[0] }}" rel="{{ tag[1].size }}">
        {{ tag[0] }}
        <sup>{{tag[1].size}}</sup>
    </a>
    {% endfor %}
    {% endcapture %}
    {{ tags | split:'</a>' | sort | join:'</a>' }}
    </a>
</div>
-->
<div class="archive timeline">
    <?php if ($article->have()): $lastDate = 1000000 ?>
    <section>
    <?php 
    while($article->next()): 
    if(date('Ym', $article->date->timeStamp) < $lastDate):
        $lastDate = date('Ym', $article->date->timeStamp);
    ?>
    </section><section>
    <div class="tl-head">
        <div class="tl-title"><?php $article->date('y年m月'); ?></div>
    </div>
    <?php endif ?>
    <div class="js-result d-none">
        <div class="post-preview item tl-item" data-tags="<?php $article->tags(',', false, ''); ?>">
            <div class="tl-date"><?php $article->date('d日') ?></div>
            <div class="tl-body">
                <div class="tl-content">
                    <a href="<?php $article->permalink() ?>">
                        <h2 class="post-title">
                            <?php $article->title() ?>
                        </h2>
                        <?php if($article->fields->subtitle): ?>
                            <h3 class="post-subtitle">
                                <?php $article->fields->subtitle() ?>
                            </h3>
                        <?php endif ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
    </section>
    <div class="tl-head">
        <div class="tl-title bg-white" style="color: #777;">BEGIN</div>
    </div>
    <?php else: ?>
        <article>
            <h2 class="post-title"><?php _e('没有找到内容'); ?></h2>
        </article>
    <?php endif; ?>
</div>

<style>
    .archive{
        padding: 1rem;
    }
    .archive.timeline{
        margin-left: 3rem;
    }
    .timeline .tl-title{
        color: #fff;
    }
    .archive .post-title{
        font-size: 1.1rem;
        color: #fff;
        margin-bottom: 0;
    }
    .archive .post-subtitle{
        font-size: 0.9rem;
        margin-top: .2em;
        margin-bottom: 0;
    }
    body{
        overflow-y: scroll;
    }
</style>

<?php $this->need('_layouts/default-1.php'); ?>