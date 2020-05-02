<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="renderer" content="webkit" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?>
    </title>
    <meta name="description" content="<?php $this->options->description(); ?>" />
    <meta name="keywords" content="<?php $this->options->keywords(); ?>" />
    <link rel="shortcut icon" href="<?php if($this->options->favicon)$this->options->favicon(); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('asserts/lib/bootstrap/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('style.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('asserts/lib/highlight/vscode.css'); ?>">
    <?php $this->header(); ?>
</head>

<body class="theme-front-none">
    <div class="sidebar">
        <div class="container">
            <div class="row row-nav">
                <div class="col-9 col-md-4 col-lg-3 card-nav-container">
                    <?php $this->need('_includes/nav.php'); ?>
                </div>
                <div class="col-3 col-md-8 col-lg-6 card-sidebar-control-container">
                    <div class="card card-sidebar-control">
                        <i data-control="open" data-feather="menu"></i>
                        <i data-control="close" data-feather="arrow-left"></i>
                    </div>
                </div>
                <div class="col-9 col-md-4 col-lg-3">
                    <?php $this->need('_includes/sidebar.php'); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-10 col-md-4 col-lg-3"></div>
                <div class="col-12 col-md-8 col-lg-6 col-content js-toc-content">
                    <div class="card card-fullscreen-control">
                        <i data-control="on" data-feather="maximize-2"></i>
                        <i data-control="off" data-feather="minimize-2"></i>
                    </div>