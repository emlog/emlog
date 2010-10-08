<?php
/**
 * 前端控制
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class Options {

	//版本编号
    const EMLOG_VERSION = '4.0.0';
    //后台模板
    const ADMIN_TPL = 'default';
	//图片附件缩略图最大宽
	const IMG_ATT_MAX_W = 420;
	//图片附件缩略图最大高
	const IMG_ATT_MAX_H = 460;
	//头像缩略图最大宽
	const ICON_MAX_W = 140;
	//头像缩略图最大高
	const ICON_MAX_H = 220;
    //附件大小上限 （单位：字节，默认20M）
    const UPLOADFILE_MAXSIZE = 20971520;
    // 上传图片是否生成缩略图 1:是 0:否
    const IS_THUMBNAIL = 1;

    const UPLOADFILE_PATH = '../content/uploadfile/';
    //允许上传的附件类型
    const ATTACHMENT_TYPE = 'rar,zip,gif,jpg,jpeg,png,bmp';

    static function get($option){
        $CACHE = Cache::getInstance();
		$options_cache = $CACHE->readCache('options');
		if (isset($options_cache[$option])) {
			return $options_cache[$option];
		}
    }

    static function getRoutingTable(){
    	$routingtable = array(
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg'=>'|^[/]?$|'
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg'=>'|^/\?(record)=([\d]{6,8})$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg'=>'|^/\?(sort)=([\d]+)$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg'=>'|^/\?(tag)=(.+)$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg'=>'|^/\?(author)=([\d]+)$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayBlog',
                            'reg'=>'|^/index\.php\?(keyword)=([^/]+)$|',
                            ),
                    array(
                            'model'=>'emBlog',
                            'method' =>'displayContent',
                            'reg'=>'|^/\?(post)=([\d]+)$|'
                            ),
                    array(
                            'model'=>'emComment',
                            'method' =>'addComment',
                            'reg'=>'|^/index\.php\?(action)=(addcom)$|',
                            ),
                    array(
                            'model'=>'calendar',
                            'method' =>'generate',
                            'reg'=>'|^/\?action=cal|',
                            ),
                
                );
         return $routingtable;
    }
    
    static function getAttType() {
    	return explode(',', self::ATTACHMENT_TYPE);
    }

}