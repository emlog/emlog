<?php
/**
 * Front Options
 * @package EMLOG (www.emlog.net)
 */

class Option {

	const EMLOG_VERSION = 'pro 1.2.1';               //Version number
	const EMLOG_VERSION_TIMESTAMP = 1645251730;      //Version timestamp
	const ICON_MAX_W = 160;                          //Maximum avatar thumbnail width
	const ICON_MAX_H = 160;                          //Maximum avatar thumbnail height
	const UPLOADFILE_PATH = '../content/uploadfile/';//Upload path

	static function get($option) {
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		if (isset($options_cache[$option])) {
			switch ($option) {
				case 'active_plugins':
				case 'navibar':
				case 'widget_title':
				case 'custom_widget':
				case 'widgets1':
				case 'custom_topimgs':
					if (!empty($options_cache[$option])) {
						return @unserialize($options_cache[$option]);
					} else {
						return array();
					}
					break;
				case 'blogurl':
/*vot*/				 if (@$options_cache['detect_url'] == 'y') {
						return realUrl();
					} else {
						return $options_cache['blogurl'];
					}
					break;
				default:
					return $options_cache[$option];
					break;
			}
		}
	}

	static function getAll() {
		$CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		$options_cache['site_title'] = $options_cache['site_title'] ?: $options_cache['blogname'];
		$options_cache['site_description'] = $options_cache['site_description'] ?: $options_cache['bloginfo'];
		if (empty($options_cache['emkey'])) {
/*vot*/			$options_cache['footer_info'] .= defined('DEV_MODE') ? (lang('powered_by_emlog') . ' ' . Option::EMLOG_VERSION) : lang('pro_unregistered');
		}
		return $options_cache;
	}

	static function getRoutingTable() {
		$routingtable = array(
			array(
				'model'  => 'calendar',
				'method' => 'generate',
				'reg_0'  => '|^.*/\?action=cal|',
			),
			array(
				'model'  => 'Log_Controller',
				'method' => 'displayContent',
				'reg_0'  => '|^.*/\?(post)=(\d+)(&(comment-page)=(\d+))?([\?&].*)?$|',
				'reg_1'  => '|^.*/(post)-(\d+)\.html(/(comment-page)-(\d+))?/?([\?&].*)?$|',
				'reg_2'  => '|^.*/(post)/(\d+)(/(comment-page)-(\d+))?/?$|',
				'reg_3'  => '|^/([^\./\?=]+)(\.html)?(/(comment-page)-(\d+))?/?([\?&].*)?$|',
			),
			array(
				'model'  => 'Record_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(record)=(\d{6,8})(&(page)=(\d+))?([\?&].*)?$|',
				'reg'    => '|^.*/(record)/(\d{6,8})/?((page)/(\d+))?/?([\?&].*)?$|',
			),
			array(
				'model'  => 'Sort_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(sort)=(\d+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg'    => '|^.*/(sort)/([^\./\?=]+)/?((page)/(\d+))?/?([\?&].*)?$|',
			),
			array(
				'model'  => 'Tag_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(tag)=([^&]+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg'    => '|^.*/(tag)/([^/?]+)/?((page)/(\d+))?/?([\?&].*)?$|',
			),
			array(
				'model'  => 'Author_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(author)=(\d+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg'    => '|^.*/(author)/(\d+)/?((page)/(\d+))?/?([\?&].*)?$|',
			),
			array(
				'model'  => 'Log_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(page)=(\d+)([\?&].*)?$|',
				'reg'    => '|^.*/(page)/(\d+)/?([\?&].*)?$|',
			),
			array(
				'model'  => 'Search_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(keyword)=([^/&]+)(&(page)=(\d+))?([\?&].*)?$|',
			),
			array(
				'model'  => 'Comment_Controller',
				'method' => 'addComment',
				'reg_0'  => '|^.*/\?(action)=(addcom)([\?&].*)?$|',
			),
			array(
				'model'  => 'Plugin_Controller',
				'method' => 'loadPluginShow',
				'reg_0'  => '|^.*/\?(plugin)=([\w\-]+).*([\?&].*)?$|',
			),
			array(
				'model'  => 'Log_Controller',
				'method' => 'displayContent',
				'reg_0'  => '|^.*?/([^/\.=\?]+)(\.html)?(/(comment-page)-(\d+))?/?([\?&].*)?$|',
			),
			array(
				'model'  => 'Log_Controller',
				'method' => 'display',
				'reg_0'  => '|^/?([\?&].*)?$|',
			),
		);
		return $routingtable;
	}

	/**
	 * Get the file types allowed to upload
	 */
	static function getAttType() {
		return explode(',', self::get('att_type'));
	}

	/**
	 * Get the maximum upload limit, in bytes
	 */
	static function getAttMaxSize() {
		return self::get('att_maxsize') * 1024;
	}

	/**
	 * Get widget module title
	 */
	static function getWidgetTitle() {
		return [
/*vot*/			'blogger'     => lang('blogger'),
/*vot*/			'calendar'    => lang('calendar'),
/*vot*/			'tag'         => lang('tags'),
/*vot*/			'sort'        => lang('categories'),
/*vot*/			'archive'     => lang('archive'),
/*vot*/			'newcomm'     => lang('new_comments'),
/*vot*/			'newlog'      => lang('new_posts'),
/*vot*/			'hotlog'      => lang('hot_posts'),
/*vot*/			'link'        => lang('links'),
/*vot*/			'search'      => lang('search'),
/*vot*/			'custom_text' => lang('widget_custom')
		];
	}

	/**
	 * Get a list of widgets installed by default
	 */
	static function getDefWidget() {
		return ['blogger', 'newcomm', 'link', 'search'];
	}

	/**
	 * Get default plug-in after installation
	 */
	static function getDefPlugin() {
		return ['tips/tips.php'];
	}

	/**
	 * Update configuration option
	 * @param $name
	 * @param $value
	 * @param $isSyntax Update whether the value is an expression
	 */
	static function updateOption($name, $value, $isSyntax = false) {
		$DB = Database::getInstance();
		$value = $isSyntax ? $value : "'$value'";
		$sql = 'INSERT INTO ' . DB_PREFIX . "options (option_name, option_value) values ('$name', $value) ON DUPLICATE KEY UPDATE option_value=$value, option_name='$name'";
		$DB->query($sql);
	}
}
