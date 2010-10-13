<?php
/**
 * 前端控制
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Option {
	//版本编号
    const EMLOG_VERSION = '4.0.0';
    //后台模板
    const ADMIN_TPL = 'default';
	//图片附件缩略图最大宽
	const IMG_MAX_W = 420;
	//图片附件缩略图最大高
	const IMG_MAX_H = 460;
	//头像缩略图最大宽
	const ICON_MAX_W = 140;
	//头像缩略图最大高
	const ICON_MAX_H = 220;
    //上传图片是否生成缩略图 1:是 0:否
    const IS_THUMBNAIL = 1;
    //附件大小上限 （单位：字节，默认20M）
    const UPLOADFILE_MAXSIZE = 20971520;
    //附件上传路径
    const UPLOADFILE_PATH = '../content/uploadfile/';
    //允许上传的附件类型
    const ATTACHMENT_TYPE = 'rar,zip,gif,jpg,jpeg,png,bmp';

    static function get($option){
        $CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		if (isset($options_cache[$option])) {
			switch($option){
				case 'active_plugins':
				case 'navibar':
				case 'widget_title':
			    case 'custom_widget':
			    case 'widgets1':
			    case 'widgets2':
			    case 'widgets3':
			    case 'widgets4':
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

    static function getRoutingTable(){
    	$routingtable = array(
                    array(
                            'model'=>'calendar',
                            'method' =>'generate',
                            'reg'=>'|^.*/\?action=cal|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg'=>'|^.*[/]?$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayContent',
                            'reg_0'=>'|^.*/\?(post)=([\d]+)$|',
                            'reg_1' => '|^.*/(post)-([\d]+)\.html$|',
                            'reg_2' => '|^.*/(post)/([\d]+)[/]?$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg_0'=>'|^.*/\?(record)=([\d]{6,8})$|',
                            'reg_1' => '|^.*/(record)-([\d]{6,8})\.html$|',
                            'reg_2' => '|^.*/(record)/([\d]{6,8})[/]?$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg_0'=>'|^.*/\?(sort)=([\d]+)$|',
                            'reg_1' => '|^.*/(sort)-([\d]+)\.html$|',
                            'reg_2' => '|^.*/(sort)/([\d]+)[/]?$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg_0'=>'|^.*/\?(tag)=(.+)$|',
                            'reg_1' => '|^.*/(tag)-(.+)\.html$|',
                            'reg_2' => '|^.*/(tag)/([^/]+)[/]?$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg_0'=>'|^.*/\?(page)=([\d]+)$|',
                            'reg_1' => '|^.*/(page)-([\d]+)\.html$|',
                            'reg_2' => '|^.*/(page)/([\d]+)[/]?$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg_0'=>'|^.*/\?(author)=([\d]+)$|',
                            'reg_1' => '|^.*/(author)-([\d]+)\.html$|',
                            'reg_2' => '|^.*/(author)/([\d]+)[/]?$|',
                            ),
                    array(
                            'model'=>'emPlugin',
                            'method' =>'loadPluginShow',
                            'reg'=>'|^.*/\?(plugin)=([\w\-]+)$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg'=>'|^.*/index\.php\?(keyword)=([^/]+)$|',
                            ),
                    array(
                            'model'=>'emComment',
                            'method' =>'addComment',
                            'reg'=>'|^.*/index\.php\?(action)=(addcom)$|',
                            ),
                    array(
                            'model'=>'calendar',
                            'method' =>'generate',
                            'reg'=>'|^.*/\?action=cal|',
                            ),
                );
         return $routingtable;
    }

    /**
     * 获取允许上传的附件类型
     */
    static function getAttType() {
    	return explode(',', self::ATTACHMENT_TYPE);
    }

    /**
     * 获取widget组件标题
     */
    static function getWidgetTitle() {
	    $widget_title = array(
	        'blogger' => 'blogger',
	        'calendar' => '日历',
	        'twitter' => '最新碎语',
	        'tag' => '标签',
	        'sort' => '分类',
	        'archive' => '存档',
	        'newcomm' => '最新评论',
	        'newlog' => '最新日志',
	        'random_log' => '随机日志',
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
