<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

function themeInit($data)
{
    if($data->is('category')||$data->is('search')||$data->is('tag')||$data->is('author')||$data->parameter->type == 'Morecho_archive_page')
        $data->parameter->pageSize = 2<<30;
}

function themeConfig($form)
{
    $title1 = new Typecho_Widget_Helper_Layout('div', array('class=' => 'typecho-page-title'));
    $title1->html('<h2>基本信息</h2>
    <p>图片和音乐仅支持网络位置，你可以放在服务器上typecho的文件夹里，也可以通过下载站或cdn实现<br/>
    左侧栏头像的显示逻辑为：已登录即显示登录用户头像，否则显示作者头像，无作者显示博主头像</p>');
    $form->addItem($title1);

    // 自定义站点图标
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('站点图标'), _t('在这里填入一张图片的地址'));
    $form->addInput($favicon->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义头像
    $avatar = new Typecho_Widget_Helper_Form_Element_Text('avatar', NULL, NULL, _t('头像'), _t('在这里填入一张图片的地址'));
    $form->addInput($avatar->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义名称
    $owner = new Typecho_Widget_Helper_Form_Element_Text('owner', NULL, NULL, _t('博主名称'), _t('在这里填入侧栏要显示的博主名称'));
    $form->addInput($owner->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 隐藏分类
    $hideCategory = new Typecho_Widget_Helper_Form_Element_Text('hideCategory', NULL, NULL, _t('在归档中隐藏分类'), _t('填入分类缩略名，仅支持一个'));
    $form->addInput($hideCategory->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 关于链接
    $linkAbout = new Typecho_Widget_Helper_Form_Element_Text('linkAbout', NULL, NULL, _t('添加“关于”链接'), _t('仅在启用MorechoFriends插件时生效，填入你的用户id（一般为1）即显示地址为<code>/author/ID</code>名为“关于”的链接，填入0不显示链接'));
    $form->addInput($linkAbout->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 友链链接
    $linkFriends = new Typecho_Widget_Helper_Form_Element_Text('linkFriends', NULL, NULL, _t('添加“友链”链接'), _t('仅在启用MorechoFriends插件时生效，链接地址为<code>/link/</code>，在此填入链接名称，填0即不显示链接'));
    $form->addInput($linkFriends->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义音乐名称
    $musicName = new Typecho_Widget_Helper_Form_Element_Text('musicName', NULL, NULL, _t('音乐播放器显示的标题'), _t(''));
    $form->addInput($musicName->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义音乐源
    $musicUrl = new Typecho_Widget_Helper_Form_Element_Text('musicUrl', NULL, NULL, _t('音乐播放器的音乐地址'), _t('仅支持mp3格式，留空则不显示播放器，主题文件中包含了一个测试音频，填入<code>/usr/themes/Morecho/asserts/lib/plyr/test.mp3</code>即可'));
    $form->addInput($musicUrl->addRule('xssCheck', _t('请不要使用特殊字符')));
    // 自定义页脚
    $footerCopyright = new Typecho_Widget_Helper_Form_Element_Textarea('footerCopyright', NULL, NULL, _t('自定义页脚'), _t('默认为<code>&lt;div&gt;&amp;copy; [当前年份] · Powered by Typecho · Theme by &lt;a href=&quot;https://github.com/muzhou233/Morecho-Typecho&quot;&gt;Morecho&lt;/a&gt;&lt;/div&gt;</code></br>如果需要添加备案号，复制前面的内容，修改年份，并在后面添加<code>&lt;div&gt;备案号内容&lt;/div&gt;</code><br/>你也可以选择不保留原有的版权声明</br>留空则使用默认'));
    $form->addInput($footerCopyright);
    // 自定义背景图
    $backgroundlg = new Typecho_Widget_Helper_Form_Element_Text('backgroundlg', NULL, NULL, _t('背景图片地址'));
    $form->addInput($backgroundlg->addRule('xssCheck', _t('请不要使用特殊字符')));
    $backgroundsm = new Typecho_Widget_Helper_Form_Element_Text('backgroundsm', NULL, NULL, _t('移动端背景图片地址'), _t('在移动端使用长图替换宽图体验更好'));
    $form->addInput($backgroundsm->addRule('xssCheck', _t('请不要使用特殊字符')));

    $blurCard = new Typecho_Widget_Helper_Form_Element_Radio('blurCard', array('false' => _t('不启用'), 'true' => _t('启用')), 'false', _t('是否启用半透明卡片效果（实验性）'), _t(''));
    $form->addInput($blurCard);
    
    $useJsDelivr = new Typecho_Widget_Helper_Form_Element_Radio('useJsDelivr', array('false' => _t('不启用'), 'true' => _t('启用')), 'false', _t('是否使用cdn（jsDelivr）'), _t('使用cdn可以加快页面加载，不使用cdn可以保证所有地区的用户都正确加载页面'));
    $form->addInput($useJsDelivr);

    $title2 = new Typecho_Widget_Helper_Layout('div', array('class=' => 'typecho-page-title'));
    $title2->html('<h2>头衔</h2>
    <p>会在左侧栏和评论区显示</p>');
    $form->addItem($title2);
    
    $groupTitleA = new Typecho_Widget_Helper_Form_Element_Text('groupTitleA', NULL, _t('管理员'), _t('管理员'), _t(''));
    $form->addInput($groupTitleA->addRule('xssCheck', _t('请不要使用特殊字符')));
    $groupTitleE = new Typecho_Widget_Helper_Form_Element_Text('groupTitleE', NULL, _t('编辑'), _t('编辑'), _t(''));
    $form->addInput($groupTitleE->addRule('xssCheck', _t('请不要使用特殊字符')));
    $groupTitleC = new Typecho_Widget_Helper_Form_Element_Text('groupTitleC', NULL, _t('贡献者'), _t('贡献者'), _t(''));
    $form->addInput($groupTitleC->addRule('xssCheck', _t('请不要使用特殊字符')));
    $groupTitleS = new Typecho_Widget_Helper_Form_Element_Text('groupTitleS', NULL, _t('关注者'), _t('关注者'), _t(''));
    $form->addInput($groupTitleS->addRule('xssCheck', _t('请不要使用特殊字符')));
    $groupTitleV = new Typecho_Widget_Helper_Form_Element_Text('groupTitleV', NULL, _t('访问者'), _t('访问者'), _t('留空则不显示'));
    $form->addInput($groupTitleV->addRule('xssCheck', _t('请不要使用特殊字符')));
}

function themeFields($layout)
{
    if (preg_match("/write-page.php/", $_SERVER['REQUEST_URI'])) {
        $textIndent = new Typecho_Widget_Helper_Form_Element_Select('textIndent', array('false' => '不缩进', 'true' => '缩进'), 'false', '开启全文首行缩进');
        $layout->addItem($textIndent);
        $headImage = new Typecho_Widget_Helper_Form_Element_Text('headImage', NULL, NULL, _t('头图'), _t('输入图片链接'));
        $layout->addItem($headImage);
    }
    if (preg_match("/write-post.php/", $_SERVER['REQUEST_URI'])) {
        $textIndent = new Typecho_Widget_Helper_Form_Element_Select('textIndent', array('false' => '不缩进', 'true' => '缩进'), 'false', '开启全文首行缩进');
        $layout->addItem($textIndent);
        $foldInIndex = new Typecho_Widget_Helper_Form_Element_Select('foldInIndex', array('false' => '不折叠', 'true' => '折叠'), 'false', '在主页列表中折叠');
        $layout->addItem($foldInIndex);
        $headImage = new Typecho_Widget_Helper_Form_Element_Text('headImage', NULL, NULL, _t('头图'), _t('输入图片链接'));
        $layout->addItem($headImage);
        $subtitle = new Typecho_Widget_Helper_Form_Element_Text('subtitle', NULL, NULL, _t('副标题'), _t('首页模板功能'));
        $layout->addItem($subtitle);
    }
}

function get_libUrl($local, $cdn){
    $options = Helper::options();
    if($options->useJsDelivr) echo $cdn;
    else $options->themeUrl($local);
}

function get_user($uid){
    $db = Typecho_Db::get();
    return $db->fetchRow($db->select()
            ->from('table.users')
            ->where('uid = ?', $uid)
            ->limit(1));
}

function get_post_num($id = false){
    $db = Typecho_Db::get();
    if($id == false) $postnum=$db->fetchRow($db
        ->select(array('COUNT(authorId)'=>'allpostnum'))
        ->from ('table.contents')
        ->where('table.contents.type=?', 'post'));
    else $postnum=$db->fetchRow($db
        ->select(array('COUNT(authorId)'=>'allpostnum'))
        ->from ('table.contents')
        ->where ('table.contents.authorId=?',$id)
        ->where('table.contents.type=?', 'post'));
    return $postnum['allpostnum'];
}

function get_comment_num($id = false){
    $db = Typecho_Db::get();
    if($id == false) $commentnum=$db->fetchRow($db
        ->select(array('COUNT(authorId)'=>'commentnum'))
        ->from ('table.comments')
        ->where('table.comments.type=?', 'comment'));
    else $commentnum=$db->fetchRow($db
        ->select(array('COUNT(authorId)'=>'commentnum'))
        ->from ('table.comments')
        ->where ('table.comments.authorId=?',$id)
        ->where('table.comments.type=?', 'comment'));
    return $commentnum['commentnum'];
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

function get_user_group($name = NULL){
    $options = Helper::options();
    $db = Typecho_Db::get();
    if($name === NULL)
        $profile = $db->fetchRow($db->select('group', 'uid')->from('table.users')->where('uid = ?', intval(Typecho_Cookie::get('__typecho_uid'))));
    else
        $profile = $db->fetchRow($db->select('group', 'name', 'screenName')->from('table.users')->where('name=? OR screenName=?', $name, $name));
    if(sizeof($profile) == 0) return isset($options->groupTitleV) ? $options->groupTitleV: '';
    return $profile['group'];
}

function get_user_title($name = NULL){
    $options = Helper::options();
    switch(get_user_group($name)){
        case 'administrator':
            return isset($options->groupTitleA) ? $options->groupTitleA: ''; break;
        case 'editor':
            return isset($options->groupTitleE) ? $options->groupTitleE: ''; break;
        case 'contributor':
            return isset($options->groupTitleC) ? $options->groupTitleC: ''; break;
        case 'subscriber':
            return isset($options->groupTitleS) ? $options->groupTitleS: ''; break;
        case 'visitor':
            return isset($options->groupTitleV) ? $options->groupTitleV: ''; break;
    }
    return isset($options->groupTitleV) ? $options->groupTitleV: '';
}

function get_comment($coid){
    $db = Typecho_Db::get();
    return $db->fetchRow($db->select()
            ->from('table.comments')
            ->where('coid = ?', $coid)
            ->limit(1));
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