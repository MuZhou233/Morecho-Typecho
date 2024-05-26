<?php
/**
 * 一个简单的响应式三栏主题，需与配套插件共同使用
 * 
 * @package Morecho Theme
 * @author MuZhou233
 * @version 0.6.0.1
 * @link https://typecho.mosar.in
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('_layouts/default-0.php');
 ?>

<h1 class="title"><?php $this->options->title(); ?></h1>

<?php while($this->next()): ?>

<div class="card card-post-list">
    <a href="<?php $this->permalink(); ?>">
        <div class="post-title">
            <?php $this->title(); ?>
        </div>
        <?php if($this->fields->foldInIndex !== "true"): ?>
        <?php if(isset($this->fields->subtitle)): ?>
        <div class="post-subtitle">
            <?php $this->fields->subtitle(); ?>
        </div>
        <?php endif ?>
        <div class="post-content-preview">
            <?php $this->excerpt(100 , '...'); ?>
        </div>
        <div class="post-meta">
            <i data-feather="edit-3"></i> <?php $this->author(); ?>
            <i data-feather="calendar"></i> <?php $this->date('Y年m月d日'); ?>
            <i data-feather="clock"></i> <?php echo (string)mb_strlen(str_replace(PHP_EOL,'',strip_tags(preg_replace('/(<code.*?>[\s|\S]*?<\/code>)/', '', $this->content))),'utf-8'); echo ' 字' ?>
        </div>
        <?php endif ?>
    </a>
</div>

<?php endwhile; ?>

<nav class="Page-navigation">
    <?php
        $this->pageNav('<span class="backward"><i data-feather="chevrons-left"></i></span>', '<span class="forward"><i data-feather="chevrons-right"></i></span>', 3, '...', array(
            'wrapTag' => 'ul', 
            'wrapClass' => 'pagination justify-content-center', 
            'itemTag' => 'li', 
            'itemClass' => 'page-item',
            'linkClass' => 'page-link',
            'currentClass' => 'active'
        ));
    ?>
</nav>

<?php $this->need('_layouts/default-1.php'); ?>