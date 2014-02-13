<?php
/**
 * 前端控制
 * @copyright (c) Emlog All Rights Reserved
 */

class Option {
	//版本编号
	const EMLOG_VERSION = '5.3.0';
	const ICON_MAX_W = 140;
	//头像缩略图最大高
	const ICON_MAX_H = 220;
	//微语图片缩略图最大宽
	const T_IMG_MAX_W = 180;
	//微语图片缩略图最大高
	const T_IMG_MAX_H = 136;
	//附件上传路径
	const UPLOADFILE_PATH = '../content/uploadfile/';

	static function get($option){
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		if (isset($options_cache[$option])) {
			switch ($option) {
				case 'active_plugins':
				case 'navibar':
				case 'widget_title':
				case 'custom_widget':
				case 'widgets1':
				case 'widgets2':
				case 'widgets3':
				case 'widgets4':
				case 'custom_topimgs':
					if (!empty($options_cache[$option])) {
						return @unserialize($options_cache[$option]);
					} else{
						return array();
					}
					break;
				default:
					return $options_cache[$option];
					break;
			}
		}
	}

	static function getAll(){
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');

		$options_cache['site_title'] = $options_cache['site_title'] ? $options_cache['site_title'] : $options_cache['blogname'];
		$options_cache['site_description'] = $options_cache['site_description'] ? $options_cache['site_description'] : $options_cache['bloginfo'];

		return $options_cache;
	}

	static function getRoutingTable(){
		$routingtable = array(
			array(
				'model' => 'calendar',
				'method' => 'generate',
				'reg_0' => '|^.*/\?action=cal|',
				),
			array(
				'model' => 'Log_Controller',
				'method' => 'displayContent',
				'reg_0' => '|^.*/\?(post)=(\d+)(&(comment-page)=(\d+))?([\?&].*)?$|',
				'reg_1' => '|^.*/(post)-(\d+)\.html(/(comment-page)-(\d+))?/?([\?&].*)?$|',
				'reg_2' => '|^.*/(post)/(\d+)(/(comment-page)-(\d+))?/?$|',
				'reg_3' => '|^/([^\./\?=]+)(\.html)?(/(comment-page)-(\d+))?/?([\?&].*)?$|',
				),
			array(
				'model' => 'Record_Controller',
				'method' => 'display',
				'reg_0' => '|^.*/\?(record)=(\d{6,8})(&(page)=(\d+))?([\?&].*)?$|',
				'reg' => '|^.*/(record)/(\d{6,8})/?((page)/(\d+))?/?([\?&].*)?$|',
				),
			array(
				'model' => 'Sort_Controller',
				'method' => 'display',
				'reg_0' => '|^.*/\?(sort)=(\d+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg' => '|^.*/(sort)/([^\./\?=]+)/?((page)/(\d+))?/?([\?&].*)?$|',
				),
			array(
				'model' => 'Tag_Controller',
				'method' => 'display',
				'reg_0' => '|^.*/\?(tag)=([^&]+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg' => '|^.*/(tag)/([^/?]+)/?((page)/(\d+))?/?([\?&].*)?$|',
				),
			array(
				'model' => 'Author_Controller',
				'method' => 'display',
				'reg_0' => '|^.*/\?(author)=(\d+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg' => '|^.*/(author)/(\d+)/?((page)/(\d+))?/?([\?&].*)?$|',
				),
			array(
				'model' => 'Log_Controller',
				'method' => 'display',
				'reg_0' => '|^.*/\?(page)=(\d+)([\?&].*)?$|',
				'reg' => '|^.*/(page)/(\d+)/?([\?&].*)?$|',
				),
			array(
				'model' => 'Search_Controller',
				'method' =>'display',
				'reg_0' => '|^.*/\?(keyword)=([^/&]+)(&(page)=(\d+))?([\?&].*)?$|',
				),
			array(
				'model' => 'Comment_Controller',
				'method' => 'addComment',
				'reg_0' => '|^.*/\?(action)=(addcom)([\?&].*)?$|',
				),
			array(
				'model' => 'Plugin_Controller',
				'method' => 'loadPluginShow',
				'reg_0' => '|^.*/\?(plugin)=([\w\-]+).*([\?&].*)?$|',
				),
			array(
				'model' => 'Log_Controller',
				'method' => 'displayContent',
				'reg_0' => '|^.*?/([^/\.=\?]+)(\.html)?(/(comment-page)-(\d+))?/?([\?&].*)?$|',
				),
			array(
				'model' => 'Log_Controller',
				'method' => 'display',
				'reg_0' => '|^/?([\?&].*)?$|',
				),
			);
		return $routingtable;
	}

	/**
	 * 获取允许上传的附件类型
	 */
	static function getAttType() {
		return explode(',', self::get('att_type'));
	}

    /**
	 * 获取附件最大限制,单位字节
	 */
	static function getAttMaxSize() {
		return self::get('att_maxsize') * 1024;
	}
    
	/**
	 * 获取widget组件标题
	 */
	static function getWidgetTitle() {
		$widget_title = array(
			'blogger' => '个人资料',
			'calendar' => '日历',
			'twitter' => '最新微语',
			'tag' => '标签',
			'sort' => '分类',
			'archive' => '存档',
			'newcomm' => '最新评论',
			'newlog' => '最新文章',
			'random_log' => '随机文章',
			'hotlog' => '热门文章',
			'link' => '链接',
			'search' => '搜索',
			'custom_text' => '自定义组件'
		);
		return $widget_title;
	}

	/**
	 * 获取初始安装时的widget列表
	 */
	static function getDefWidget() {
		$default_widget = array('calendar','archive','newcomm','link','search');
		return $default_widget;
	}

	/**
	 * 更新配置选项
	 * @param $name
	 * @param $value
	 * @param $isSyntax 更新值是否为一个表达式
	 */
	static function updateOption($name, $value, $isSyntax = false){
		$DB = MySql::getInstance();
		$value = $isSyntax ? $value : "'$value'";
		$DB->query('UPDATE '.DB_PREFIX."options SET option_value=$value where option_name='$name'");
	}
}
