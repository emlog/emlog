<?php
/**
 * Configuration item
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Option {

	const EMLOG_VERSION = 'pro 1.3.0';               //版本编号
	const EMLOG_VERSION_TIMESTAMP = 1651624944;      //版本时间戳
	const ICON_MAX_W = 160;                          //头像缩略图最大宽
	const ICON_MAX_H = 160;                          //头像缩略图最大高
	const UPLOADFILE_PATH = '../content/uploadfile/';//上传路径

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
						return [];
					}
					break;
				case 'blogurl':
					if ($options_cache['detect_url'] == 'y') {
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
			$options_cache['footer_info'] .= ' &#x672A;&#x6CE8;&#x518C;&#x7684;PRO&#x7248;&#x672C;';
			$options_cache['site_title'] = '&#x672A;&#x6CE8;&#x518C;&#x7684;PRO&#x7248;&#x672C;' . $options_cache['site_title'];
		}
		return $options_cache;
	}

	static function getRoutingTable() {
		return [
			[
				'model'  => 'calendar',
				'method' => 'generate',
				'reg_0'  => '|^.*/\?action=cal|',
			],
			[
				'model'  => 'Log_Controller',
				'method' => 'displayContent',
				'reg_0'  => '|^.*/\?(post)=(\d+)(&(comment-page)=(\d+))?([\?&].*)?$|',
				'reg_1'  => '|^.*/(post)-(\d+)\.html(/(comment-page)-(\d+))?/?([\?&].*)?$|',
				'reg_2'  => '|^.*/(post)/(\d+)(/(comment-page)-(\d+))?/?$|',
				'reg_3'  => '|^/([^\./\?=]+)(\.html)?(/(comment-page)-(\d+))?/?([\?&].*)?$|',
			],
			[
				'model'  => 'Record_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(record)=(\d{6,8})(&(page)=(\d+))?([\?&].*)?$|',
				'reg'    => '|^.*/(record)/(\d{6,8})/?((page)/(\d+))?/?([\?&].*)?$|',
			],
			[
				'model'  => 'Sort_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(sort)=(\d+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg'    => '|^.*/(sort)/([^\./\?=]+)/?((page)/(\d+))?/?([\?&].*)?$|',
			],
			[
				'model'  => 'Tag_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(tag)=([^&]+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg'    => '|^.*/(tag)/([^/?]+)/?((page)/(\d+))?/?([\?&].*)?$|',
			],
			[
				'model'  => 'Author_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(author)=(\d+)(&(page)=(\d+))?([\?&].*)?$|',
				'reg'    => '|^.*/(author)/(\d+)/?((page)/(\d+))?/?([\?&].*)?$|',
			],
			[
				'model'  => 'Log_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(page)=(\d+)([\?&].*)?$|',
				'reg'    => '|^.*/(page)/(\d+)/?([\?&].*)?$|',
			],
			[
				'model'  => 'Search_Controller',
				'method' => 'display',
				'reg_0'  => '|^.*/\?(keyword)=([^/&]+)(&(page)=(\d+))?([\?&].*)?$|',
			],
			[
				'model'  => 'Comment_Controller',
				'method' => 'addComment',
				'reg_0'  => '|^.*/\?(action)=(addcom)([\?&].*)?$|',
			],
			[
				'model'  => 'Plugin_Controller',
				'method' => 'loadPluginShow',
				'reg_0'  => '|^.*/\?(plugin)=([\w\-]+).*([\?&].*)?$|',
			],
			[
				'model'  => 'Log_Controller',
				'method' => 'displayContent',
				'reg_0'  => '|^.*?/([^/\.=\?]+)(\.html)?(/(comment-page)-(\d+))?/?([\?&].*)?$|',
			],
			[
				'model'  => 'Api_Controller',
				'method' => 'starter',
				'reg_0'  => '|^.*/\?(rest-api)=(\w+)([\?&].*)?$|',
			],
			[
				'model'  => 'Log_Controller',
				'method' => 'display',
				'reg_0'  => '|^/?([\?&].*)?$|',
			],
		];
	}

	/**
	 * 获取允许上传的文件类型
	 */
	static function getAttType() {
		return explode(',', self::get('att_type'));
	}

	/**
	 * 获取上传最大限制,单位字节
	 */
	static function getAttMaxSize() {
		return self::get('att_maxsize') * 1024;
	}

	/**
	 * 获取widget组件标题
	 */
	static function getWidgetTitle() {
		return [
			'blogger'     => '个人资料',
			'calendar'    => '日历',
			'tag'         => '标签',
			'sort'        => '分类',
			'archive'     => '存档',
			'newcomm'     => '最新评论',
			'newlog'      => '最新文章',
			'hotlog'      => '热门文章',
			'link'        => '链接',
			'search'      => '搜索',
			'custom_text' => '自定义组件'
		];
	}

	/**
	 * 获取初始安装时的widget列表
	 */
	static function getDefWidget() {
		return ['blogger', 'newcomm', 'link', 'search'];
	}

	/**
	 * 获取初始安装时的插件
	 */
	static function getDefPlugin() {
		return ['tips/tips.php'];
	}

	/**
	 * 更新配置选项
	 * @param $name
	 * @param $value
	 * @param $isSyntax 更新值是否为一个表达式
	 */
	static function updateOption($name, $value, $isSyntax = false) {
		$DB = Database::getInstance();
		$value = $isSyntax ? $value : "'$value'";
		$sql = 'INSERT INTO ' . DB_PREFIX . "options (option_name, option_value) values ('$name', $value) ON DUPLICATE KEY UPDATE option_value=$value, option_name='$name'";
		$DB->query($sql);
	}
}
