<?php
/**
 * archive
 * 
 * @package custom
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

if($this->is('tag')){
    $url = Typecho_Router::getPathInfo();
    if(substr($url, -1) == '/')$url = substr($url, 0, strlen($url)-1);
    if(!array_key_exists('MorechoCore', Typecho_Plugin::export()['activated']))
        Header("Location: ".$this->options->siteUrl.'archive.html/?tag='.trim(strrchr($url, '/'),'/'));
    else
        Header("Location: ".$this->options->siteUrl.'archive/?tag='.trim(strrchr($url, '/'),'/'));
}

$GLOBALS['is_archive'] = true;
$article = $this;

$this->need('_layouts/default-0.php');
?>

<div class="title">
    <h1>
    <?php $this->archiveTitle(array(
        'category'  =>  _t('%s'),
        'search'    =>  _t('包含关键字 %s 的文章'),
        'tag'       =>  _t('标签 %s 下的文章'),
        'author'    =>  _t('%s 发布的文章')
    ), '', ''); ?>
    </h1>
    <p>
    <?php echo $this->getDescription(); ?>
    </p>
</div>

<?php if(!$this->is('tag')): ?>
<div id='tag_cloud' class="tags js-tags">
    <a class="tag-button--all" data-encode="">
        Show All
        <sup><?php echo $article->length ?></sup>
    </a>
<?php 
    $tags = array();
    if ($article->have()) while($article->next()) {
        foreach ($article->tags as $tag) {
            if(array_key_exists($tag['name'], $tags))
                $tags[$tag['name']] += 1;
            else $tags[$tag['name']] = 1;
        }
    }
    foreach($tags as $tag => $num):
?>
    <a data-sort="<?php echo get_post_num() - $num ?>"
        data-encode="<?php echo urlencode($tag) ?>" class="tag-button" title="<?php echo $tag ?>" rel="<?php echo $num ?>">
        <?php echo $tag ?>
        <sup><?php echo $num ?></sup>
    </a>
<?php endforeach; ?>
</div>
<?php endif; ?>

<div style="overflow:hidden">
<div class="archive timeline">
    <div class="js-result <?php if($this->is_archive_all) echo 'd-none'; ?>">
        <?php if ($article->have()): $lastDate = 1000000 ?>
        <?php 
        while($article->next()): 
        if(date('Ym', $article->date->timeStamp) < $lastDate):
            if($lastDate != 1000000)echo '</section>';
            $lastDate = date('Ym', $article->date->timeStamp);
        ?>
        <section>
        <div class="tl-head">
            <div class="tl-title"><?php $article->date('y年m月'); ?></div>
        </div>
        <?php endif ?>
        <div class="post-preview item tl-item" data-tags="<?php 
        if ($article->tags) {
            $result = array();
            foreach ($article->tags as $tag) {
                $result[] = urlencode($tag['name']);
            }

            echo implode(',', $result);
        }
        ?>">
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
</div>
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