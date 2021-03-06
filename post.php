<?php
/**
 * Morecho
 * 
 * @package Morecho Theme
 * @author MuZhou233
 * @version 0.3.1
 * @link https://typecho.mosar.in
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('_layouts/default-0.php');
 ?>

<h1 class="title"><?php $this->title() ?></h1>
<div class="stamp">
    <?php if($this->options->forceTimeliness || $this->fields->timeliness): $now = new Typecho_Date(Typecho_Date::gmtTime());?>
        <a class="timeliness" href="javascript:;">已发布 <?php echo (int)(($now->timeStamp - $this->created) / 86400) ?> 天</a>
    <?php endif ?>
    <a class="author" href="/author/<?php echo $this->author->uid ?>"><?php $this->author(); ?></a>
</div>

<article class="card card-article">
    <?php if($this->fields->headImage): ?><img class="headimg" src="<?php $this->fields->headImage() ?>"></img><?php endif ?>
    <?php if($this->fields->subtitle): ?><h2 class="subtitle"><?php $this->fields->subtitle() ?></h2><?php endif ?>
    <?php $this->content(); ?>
</article>

<?php $this->need('_includes/comments.php'); ?>
<?php $this->need('_layouts/default-1.php'); ?>