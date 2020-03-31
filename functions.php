<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

define('__TYPECHO_DEBUG__',true);

function themeInit($data)
{
    if($data->is('category')||$data->is('search')||$data->is('tag')||$data->is('author'))
        $data->parameter->pageSize = 2^32;
}

function themeConfig($form)
{
    // 自定义站点图标
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('站点图标'), _t('在这里填入一张图片的地址，不填则使用默认图标'));
    $form->addInput($favicon->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义头像
    $avatar = new Typecho_Widget_Helper_Form_Element_Text('avatar', NULL, NULL, _t('头像'), _t('在这里填入一张图片的地址，不填则使用默认图标'));
    $form->addInput($avatar->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义名称
    $owner = new Typecho_Widget_Helper_Form_Element_Text('owner', NULL, NULL, _t('博主名称'), _t('在这里填入侧栏要显示的博主名称'));
    $form->addInput($owner->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义音乐名称
    $musicName = new Typecho_Widget_Helper_Form_Element_Text('musicName', NULL, NULL, _t('音乐播放器显示的标题'), _t(''));
    $form->addInput($musicName->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义音乐源
    $musicUrl = new Typecho_Widget_Helper_Form_Element_Text('musicUrl', NULL, NULL, _t('音乐播放器的音乐地址'), _t('留空则不显示播放器'));
    $form->addInput($musicUrl->addRule('xssCheck', _t('请不要使用特殊字符')));
}

function themeFields($layout)
{
    /*
    if (preg_match("/write-page.php/", $_SERVER['REQUEST_URI'])) {
        $title = new Typecho_Widget_Helper_Form_Element_Text('title', NULL, NULL, _t('标题'), _t('首页模板功能'));
        $layout->addItem($title);
        $intro = new Typecho_Widget_Helper_Form_Element_Text('intro', NULL, NULL, _t('介绍'), _t('首页模板功能'));
        $layout->addItem($intro);
    }
    */
    if (preg_match("/write-post.php/", $_SERVER['REQUEST_URI'])) {
        //$mood = new Typecho_Widget_Helper_Form_Element_Select('mood', array('一般' => '一般', '开心' => '开心', '伤心' => '伤心', '沉闷' => '沉闷', '无聊' => '无聊', '紧张' => '紧张', '愤怒' => '愤怒', '迷茫' => '迷茫', '心酸' => '心酸', '绝望' => '绝望'), '一般', '心情如何');
        //$layout->addItem($mood);
        $subtitle = new Typecho_Widget_Helper_Form_Element_Text('subtitle', NULL, NULL, _t('副标题'), _t('首页模板功能'));
        $layout->addItem($subtitle);
    }
}

function get_post_num($id = false){
    $db = Typecho_Db::get();
    if($id == false) $postnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'allpostnum'))->from ('table.contents')->where('table.contents.type=?', 'post'));
    else $postnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'allpostnum'))->from ('table.contents')->where ('table.contents.authorId=?',$id)->where('table.contents.type=?', 'post'));
    $postnum = $postnum['allpostnum'];
    return $postnum;
}

function get_comment_num($id = false){
    $db = Typecho_Db::get();
    if($id == false) $commentnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'commentnum'))->from ('table.comments')->where ('table.comments.authorId=?',$id)->where('table.comments.type=?', 'comment'));
    else $commentnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'commentnum'))->from ('table.comments')->where('table.comments.type=?', 'comment'));
    $commentnum = $commentnum['commentnum'];
    return $commentnum;
}

function get_last_update(){
    $num   = '1'; //取最近的一笔就好了
    $now = time();
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $create = $db->fetchRow($db->select('created')->from('table.contents')->limit($num)->order('created',Typecho_Db::SORT_DESC));
    $update = $db->fetchRow($db->select('modified')->from('table.contents')->limit($num)->order('modified',Typecho_Db::SORT_DESC));
    if($create>=$update){  //发表时间和更新时间取最近的
      echo date('y/m/d',$create['created']); //转换为更通俗易懂的格式
    }else{
      echo date('y/m/d',$update['modified']);
    }
}

class Typecho_Widget_Helper_PageNavigator_Box extends Typecho_Widget_Helper_PageNavigator
{
    /**
     * 输出盒装样式分页栏 - 增加对 itemClass linkClass 的支持
     *
     * @access public
     * @param string $prevWord 上一页文字
     * @param string $nextWord 下一页文字
     * @param int $splitPage 分割范围
     * @param string $splitWord 分割字符
     * @param string $currentClass 当前激活元素class
     * @return void
     */
    public function render($prevWord = 'PREV', $nextWord = 'NEXT', $splitPage = 3, $splitWord = '...', array $template = array())
    { 
        if ($this->_total < 1) {
            return;
        }

        $default = array(
            'itemTag'       =>  'li',
            'itemClass'     =>  '',
            'textTag'       =>  'span',
            'currentClass'  =>  'current',
            'prevClass'     =>  'prev',
            'nextClass'     =>  'next'
        );

        $template = array_merge($default, $template);
        extract($template);

        // 定义item
        $itemBegin = empty($itemTag) ? '' : ('<' . $itemTag . (empty($itemClass) ? '' : ' class="'.$itemClass.'"') . '>');
        $itemCurrentBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($currentClass)&&empty($itemClass) ? '' : ' class="' . $currentClass . ' ' . $itemClass . '"') . '>');
        $itemPrevBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($prevClass)&&empty($itemClass) ? '' : ' class="' . $prevClass . ' ' . $itemClass . '"') . '>');
        $itemNextBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($nextClass)&&empty($itemClass) ? '' : ' class="' . $nextClass . ' ' . $itemClass . '"') . '>');
        $itemEnd = empty($itemTag) ? '' : ('</' . $itemTag . '>');
        $textBegin = empty($textTag) ? '' : ('<' . $textTag . (empty($textClass) ? '' : ' class="' . $textClass . '"') . '>');
        $textEnd = empty($textTag) ? '' : ('</' . $textTag . '>');
        $linkBegin = '<a ' . (empty($linkClass) ? '' : 'class="' . $linkClass . '"') . 'href="%s">';
        $linkCurrentBegin = empty($itemTag) ? ('<a ' . (empty($linkClass) ? '' : 'class="' . $linkClass . '"') . 'href="%s"'
            . (empty($currentClass) ? '' : ' class="' . $currentClass . '"') . '>')
            : $linkBegin;
        $linkPrevBegin = empty($itemTag) ? ('<a ' . (empty($linkClass) ? '' : 'class="' . $linkClass . '"') . 'href="%s"'
            . (empty($prevClass) ? '' : ' class="' . $prevClass . '"') . '>')
            : $linkBegin;
        $linkNextBegin = empty($itemTag) ? ('<a ' . (empty($linkClass) ? '' : 'class="' . $linkClass . '"') . 'href="%s"'
            . (empty($nextClass) ? '' : ' class="' . $nextClass . '"') . '>')
            : $linkBegin;
        $linkEnd = '</a>';

        $from = max(1, $this->_currentPage - $splitPage);
        $to = min($this->_totalPage, $this->_currentPage + $splitPage);

        //输出上一页
        if ($this->_currentPage > 1) {
            echo $itemPrevBegin . sprintf($linkPrevBegin,
                str_replace($this->_pageHolder, $this->_currentPage - 1, $this->_pageTemplate) . $this->_anchor)
                . $prevWord . $linkEnd . $itemEnd;
        }

        //输出第一页
        if ($from > 1) {
            echo $itemBegin . sprintf($linkBegin, str_replace($this->_pageHolder, 1, $this->_pageTemplate) . $this->_anchor)
                . '1' . $linkEnd . $itemEnd;

            if ($from > 2) {
                //输出省略号
                echo $itemBegin . $textBegin . $splitWord . $textEnd . $itemEnd;
            }
        }

        //输出中间页
        for ($i = $from; $i <= $to; $i ++) {
            $current = ($i == $this->_currentPage);
            
            echo ($current ? $itemCurrentBegin : $itemBegin) . sprintf(($current ? $linkCurrentBegin : $linkBegin),
                str_replace($this->_pageHolder, $i, $this->_pageTemplate) . $this->_anchor)
                . $i . $linkEnd . $itemEnd;
        }

        //输出最后页
        if ($to < $this->_totalPage) {
            if ($to < $this->_totalPage - 1) {
                echo $itemBegin . $textBegin . $splitWord . $textEnd . $itemEnd;
            }
            
            echo $itemBegin . sprintf($linkBegin, str_replace($this->_pageHolder, $this->_totalPage, $this->_pageTemplate) . $this->_anchor)
                . $this->_totalPage . $linkEnd . $itemEnd;
        }

        //输出下一页
        if ($this->_currentPage < $this->_totalPage) {
            echo $itemNextBegin . sprintf($linkNextBegin,
                str_replace($this->_pageHolder, $this->_currentPage + 1, $this->_pageTemplate) . $this->_anchor)
                . $nextWord . $linkEnd . $itemEnd;
        }
    }
}

/**
 * 文章页面列表组件
 *
 * @author qining
 * @category typecho
 * @package Widget
 * @copyright Copyright (c) 2008 Typecho team (http://www.typecho.org)
 * @license GNU General Public License 2.0
 */
class Widget_Contents_Post_List extends Widget_Abstract_Contents
{
    /**
     * 执行函数
     *
     * @access public
     * @return void
     */
    public function execute()
    {
        $select = $this->select()->where('table.contents.type = ?', 'post')
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.created < ?', $this->options->time)
        ->order('table.contents.order', Typecho_Db::SORT_ASC);

        //去掉自定义首页
        $frontPage = explode(':', $this->options->frontPage);
        if (2 == count($frontPage) && 'post' == $frontPage[0]) {
            $select->where('table.contents.cid <> ?', $frontPage[1]);
        }

        $this->db->fetchAll($select, array($this, 'push'));
    }
}
