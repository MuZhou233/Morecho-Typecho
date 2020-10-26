<?php
/**
 * Morecho 主题好友插件，请启用前查看使用说明
 * 
 * 
 * @package Morecho Theme Plugin - Friends
 * @author MuZhou233
 * @version 0.1.0
 * @link https://typecho.mosar.in
 */
class MorechoFriends_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 插件版本号
     * @var string
     */
    const _VERSION = '0.1.0';
	
	/**
	 * 激活插件方法,如果激活失败,直接抛出异常
	 * 
	 * @access public
	 * @return void
	 * @throws Typecho_Plugin_Exception
	 */
	public static function activate()
	{
        if (substr(trim(dirname(__FILE__), '/'), -14) != 'MorechoFriends') {
            throw new Typecho_Plugin_Exception(_t('插件目录名必须为 MorechoFriends'));
		}
		if (!array_key_exists('MorechoCore', Typecho_Plugin::export()['activated'])){
			throw new Typecho_Plugin_Exception(_t('需要先开启前置插件：MorechoCore'));
		}
        
		Helper::addRoute('Morecho_link_page', '/link/', 'Widget_Archive', 'render');
        Typecho_Plugin::factory('Widget_Archive')->handle = array('MorechoFriends_Plugin', 'archive');
		
		$db = Typecho_Db::get();
		$type = explode('_', $db->getAdapterName());
		$type = array_pop($type);
		$prefix = $db->getPrefix();
		try {
			$select = $db->select('table.users.introduction')->from('table.users');
			$db->query($select);
			return '检测到个人介绍字段，插件启用成功';
		} catch (Typecho_Db_Exception $e) {
			$code = $e->getCode();
			if(('Mysql' == $type && (0 == $code ||1054 == $code || $code == '42S22')) ||
					('SQLite' == $type && ('HY000' == $code || 1 == $code))) {
				try {
					if ('Mysql' == $type) {
						$db->query("ALTER TABLE `".$prefix."users` ADD `introduction` LONGTEXT COMMENT '个人介绍';");
					} else if ('SQLite' == $type) {
						$db->query("ALTER TABLE `".$prefix."users` ADD `introduction` LONGTEXT DEFAULT ''");
					} else {
						throw new Typecho_Plugin_Exception('不支持的数据库类型：'.$type);
					}
					return '建立个人介绍字段，插件启用成功';
				} catch (Typecho_Db_Exception $e) {
					$code = $e->getCode();
					if(('Mysql' == $type && 1060 == $code) ) {
						return '个人介绍已经存在，插件启用成功';
					}
					throw new Typecho_Plugin_Exception('个人介绍插件启用失败。错误号：'.$code);
				}
			}
			throw new Typecho_Plugin_Exception('数据表检测失败，个人介绍插件启用失败。错误号：'.$code);
		}
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
		$db = Typecho_Db::get();
		Typecho_Widget::widget('Widget_Abstract_Options')->delete($db->select()->where('name = ?', '_plugin:MorechoFriends'));
	}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
        // 默认介绍
        $default_intro = new Typecho_Widget_Helper_Form_Element_Text(
            'default_intro',
            NULL, '这个人很懒，什么都没有留下', _t('默认介绍'), _t('用户没有填写个人介绍时显示的内容')
		);
		$form->addInput($default_intro);
		
		$title2 = new Typecho_Widget_Helper_Layout('div', array('class=' => 'typecho-page-title'));
		$title2->html('<h2>友链页面设置</h2>
		<p>自定义各用户组的显示名称，留空则不显示该用户组的友链</p>');
		$form->addItem($title2);
		
		$groupTitleA = new Typecho_Widget_Helper_Form_Element_Text('groupTitleA', NULL, _t(''), _t('管理员（包括你自己）'), _t(''));
		$form->addInput($groupTitleA->addRule('xssCheck', _t('请不要使用特殊字符')));
		$groupTitleE = new Typecho_Widget_Helper_Form_Element_Text('groupTitleE', NULL, _t(''), _t('编辑'), _t(''));
		$form->addInput($groupTitleE->addRule('xssCheck', _t('请不要使用特殊字符')));
		$groupTitleC = new Typecho_Widget_Helper_Form_Element_Text('groupTitleC', NULL, _t('好友链接'), _t('贡献者'), _t(''));
		$form->addInput($groupTitleC->addRule('xssCheck', _t('请不要使用特殊字符')));
		$groupTitleS = new Typecho_Widget_Helper_Form_Element_Text('groupTitleS', NULL, _t('推荐链接'), _t('关注者'), _t(''));
		$form->addInput($groupTitleS->addRule('xssCheck', _t('请不要使用特殊字符')));
		
		$title3 = new Typecho_Widget_Helper_Layout('div', array('class=' => 'typecho-page-title'));
		$title3->html('<h2>危险设置</h2>
		<p>谨慎操作</p>');
		$form->addItem($title3);

        // 删除所有数据
        $delete = new Typecho_Widget_Helper_Form_Element_Radio(
            'delete',
            array('0' => _t('未选择'), '1' => _t('删除')), '0', _t('删除全部数据'), _t('删除本插件生成的所有数据，当你决定不再使用本插件时执行一次')
        );
        $form->addInput($delete);
	}
      
	public static function configHandle($config,$isSetup){
		if($config['delete'] === '1'){
			$db = Typecho_Db::get();
			$prefix = $db->getPrefix();
			$db->query("ALTER TABLE `".$prefix."users` DROP `introduction`");
			$config['delete'] = '0';
		}
		Helper::configPlugin('MorechoFriends', $config);
    }

    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){
		$db = Typecho_Db::get();

		$user = Typecho_Widget::widget('Widget_User');
		$user->execute();

		$res = $db->fetchRow($db->select('table.users.introduction')->from('table.users')->where('uid = ?', $user->uid));

		$introduction = new Typecho_Widget_Helper_Form_Element_Textarea('introduction', NULL, $res['introduction'], _t('个人介绍'), _t('使用markdown语法，与文章支持的语法相同'));

		$form->addInput($introduction);
	}

	public static function personalConfigHandle($config,$isSetup){
		$db = Typecho_Db::get();

		if($isSetup)
		{
			Typecho_Widget::widget('Widget_Abstract_Options')->insert(array(
				'name'  =>  '_plugin:MorechoFriends',
				'value' =>  serialize(array()),
				'user'  =>  0
			));
		}else{
			$user = Typecho_Widget::widget('Widget_User');
			$user->execute();

			$db->query($db->sql()->where('uid = ?', $user->uid)->update('table.users')->rows(array('introduction'=>Typecho_Common::removeXSS($config['introduction']))));
		}
	}

    /**
     * link页面支持
     * 
     * @access public
     * @return void
     */
    public static function archive($parameterType, $data, Typecho_Db_Query $select)
    {
        if($parameterType != 'Morecho_link_page') return false;

        $data->setThemeFile('link.php');

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

        return true;
    }
}