<?php
/**
 * 与 Morecho 主题共同使用，请启用前查看使用说明
 * 
 * 
 * @package Morecho Theme Plugin - Core
 * @author MuZhou233
 * @version 0.3.4
 * @link https://typecho.mosar.in
 */
class MorechoCore_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 插件版本号
     * @var string
     */
    const _VERSION = '0.3.4';
    
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Helper::addRoute('Morecho_archive_page', '/archive/', 'Widget_Archive', 'render');
        Typecho_Plugin::factory('Widget_Archive')->handle = array('MorechoCore_Plugin', 'archive');
        Typecho_Plugin::factory('admin/header.php')->header = array('MorechoCore_Plugin', 'header');
        Typecho_Plugin::factory('admin/footer.php')->end = array('MorechoCore_Plugin', 'footer');
        Typecho_Plugin::factory('Widget_Abstract_Contents')->markdown = array('MorechoCore_Plugin', 'markdown');
        Typecho_Plugin::factory('Widget_Abstract_Comments')->markdown = array('MorechoCore_Plugin', 'markdown_safemod');
        Typecho_Plugin::factory('admin/editor-js.php')->markdownEditor = array('MorechoCore_Plugin', 'markdown_editor');
        Typecho_Plugin::factory('admin/write-post.php')->richEditor = array('MorechoCore_Plugin', 'editor');
        Typecho_Plugin::factory('admin/write-page.php')->richEditor = array('MorechoCore_Plugin', 'editor');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
        Helper::removeRoute('Morecho_archive_page');
    }
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        // 主题文件文件名
        $theme_folder_name = new Typecho_Widget_Helper_Form_Element_Text(
            'theme_folder_name',
            NULL, 'Morecho', _t('主题文件位置'), _t('Morecho 主题的文件夹名，默认为“Morecho”，如果你使用了其他名字可以在此修改')
        );
        $form->addInput($theme_folder_name);
        // 是否修改后台样式
        $no_change_dashboard_style = new Typecho_Widget_Helper_Form_Element_Radio(
            'no_change_dashboard_style',
            array('0' => _t('不修改'), '1' => _t('修改')), '1', _t('是否修改后台外观'), _t('后台外观包括对移动端的适配修复')
        );
        $form->addInput($no_change_dashboard_style);
        // 是否启用lazyload
        $lazyload = new Typecho_Widget_Helper_Form_Element_Radio(
            'lazyload',
            array('0' => _t('不启用'), '1' => _t('启用')), '1', _t('是否启用图片lazyload'), _t('lazyload在图片较多的长文章中效果更好')
        );
        $form->addInput($lazyload);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

    /**
     * 后台插入 css 调用代码
     * 
     * @access public
     * @return void
     */
    public static function header($header)
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('MorechoCore');
        if($options->no_change_dashboard_style != '0')
            $header .= '<link rel="stylesheet" href="'.Helper::options()->pluginUrl.'/MorechoCore/style.css"/>';
        $header .=  '<link rel="stylesheet" href="'.Helper::options()->siteUrl.'usr/themes/'.$options->theme_folder_name.'/asserts/css/article.css">';
        $header .= '<link rel="stylesheet" href="'.Helper::options()->siteUrl.'usr/themes/'.$options->theme_folder_name.'/asserts/css/morecho.css">';
        return $header;
    }

    /**
     * 后台插入 js 调用代码
     * 
     * @access public
     * @return void
     */
    public static function footer()
    {
        $options = Helper::options();
        echo '<script src="'.$options->pluginUrl.'/MorechoCore/script.js"></script>';
    }

    /**
     * 使用 Parsedown 解析
     * 
     * @access public
     * @return void
     */
    public static function markdown($text)
    {
        require_once dirname(__FILE__) . '/ParsedownExtend.php';
        return ParsedownExtend::instance()
            ->setBreaksEnabled(true)
            ->text($text);
    }
    
    /**
     * 使用 Parsedown 解析（开启安全模式）
     * 
     * @access public
     * @return void
     */
    public static function markdown_safemod($text)
    {
        require_once dirname(__FILE__) . '/ParsedownExtend.php';
        return ParsedownExtend::instance()
            ->setSafeMode(true)
            ->setBreaksEnabled(true)
            ->text($text);
    }
        
    /**
     * 修改markdown编辑器
     * 
     * @access public
     * @return void
     */
    public static function editor($page)
    {
        Typecho_Widget::widget('Widget_Options')->to($options);
        list($prefixVersion, $suffixVersion) = explode('/', $options->version);
        $options->theme_folder_name = Typecho_Widget::widget('Widget_Options')->plugin('MorechoCore')->theme_folder_name;
        require dirname(__FILE__) . '/editor-js.php';
    }
    
    /**
     * archive页面支持
     * 
     * @access public
     * @return void
     */
    public static function archive($parameterType, $data, Typecho_Db_Query $select)
    {
        if($parameterType != 'Morecho_archive_page') return false;

        $select->where('table.contents.type = ?', 'post');

        $data->setThemeFile('archive.php');

        $data->setArchiveType = 'date';

        /** 设置头部feed */
        /** RSS 2.0 */
        $data->setFeedUrl($data->feedUrl);

        /** RSS 1.0 */
        $data->setFeedRssUrl($data->feedRssUrl);

        /** ATOM 1.0 */
        $data->setFeedAtomUrl($data->feedAtomUrl);

        /** 设置标题 */
        $data->setArchiveTitle($data->title);

        /** 设置关键词 */
        $data->setKeywords(implode(',', Typecho_Common::arrayFlatten($data->tags, 'name')));

        /** 设置描述 */
        $data->setDescription($data->description);

        return false;
    }
}