<?php
/**
 * Frontend control options
 * @copyright (c) Emlog All Rights Reserved
 */

class Option {
	//Version number
	const EMLOG_VERSION = '5.3.0';
	//默认MySQL链接方式，mysql或mysqli
	const DEFAULT_MYSQLCONN = 'mysql';
    //头像缩略图最大宽
	const ICON_MAX_W = 140;
	//Maximum height of avatar thumbnail
	const ICON_MAX_H = 220;
	//Maximum width of twitter image thumbnail
	const T_IMG_MAX_W = 180;
	//Maximum height of twitter image thumbnail
	const T_IMG_MAX_H = 136;
    //Attachment upload path
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
     * Get the types of attachments allowed to upload
	 */
	static function getAttType() {
		return explode(',', self::get('att_type'));
	}

    /**
	 * Get the maximum attachment size, in bytes
	 */
	static function getAttMaxSize() {
		return self::get('att_maxsize') * 1024;
	}
    
	/**
	 * Get the widget titles
	 */
	static function getWidgetTitle() {
		$widget_title = array(
			'blogger' => $lang['widget_blogger'],
			'calendar' => $lang['calendar'],
			'twitter' => $lang['twitter'],
			'tag' => $lang['tags'],
			'sort' => $lang['categories'],
			'archive' => $lang['archive'],
			'newcomm' => $lang['latest_comments'],
			'newlog' => $lang['latest_posts'],
			'random_log' => $lang['random_posts'],
			'hotlog' => $lang['hot_articles'],
			'link' => $lang['links'],
			'search' => $lang['search'],
			'custom_text' => $lang['widget_custom']
		);
		return $widget_title;
	}

	/**
     * Get a list of widgets during initial installation
	 */
	static function getDefWidget() {
		$default_widget = array('calendar','archive','newcomm','link','search');
		return $default_widget;
	}

	/**
     * Update configuration options
	 * @param $name
	 * @param $value
     * @param $isSyntax Whether the update value is an expression
	 */
	static function updateOption($name, $value, $isSyntax = false){
		$DB = Database::getInstance();
		$value = $isSyntax ? $value : "'$value'";
		$DB->query('UPDATE '.DB_PREFIX."options SET option_value=$value where option_name='$name'");
	}
}
