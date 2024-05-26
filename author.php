<?php
/**
 * author
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

if(isset($_GET['articles']) || !array_key_exists('MorechoFriends', Typecho_Plugin::export()['activated'])){
    $this->need('archive.php');
    return;
}

$db = Typecho_Db::get();

$user = get_user($this->archiveSlug);

$this->need('_layouts/default-0.php'); ?>

<h1 class="title"><?php echo $user['screenName'] ?></h1>

<article class="card card-article">
    <?php echo Widget_Abstract_Contents::markdown(empty($user['introduction'])?Typecho_Widget::widget('Widget_Options')->plugin('MorechoFriends')->default_intro:$user['introduction']); ?>
</article>
<div class="author-bottom">
<?php if(!empty($user['url'])): ?>
    <a class="btn btn-primary" href="<?php echo $user['url']; ?>">访问 <?php echo $user['screenName'] ?> 的主页</a>
<?php endif; ?>
<?php if($user['group'] !== 'subscriber'): ?>
    <a class="btn btn-primary" href="./?articles">查看 <?php echo $user['screenName'] ?> 发布的文章</a>
<?php endif; ?>
</div>

<style>
.author-bottom{
    text-align: right;
}
.author-bottom a{
    margin-top: 1rem;
}
</style>

<?php $this->need('_layouts/default-1.php'); ?>