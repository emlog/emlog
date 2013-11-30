<?php
/*
Plugin Name: 新浪微博插件
Version: 2.0
Plugin URL:http://www.emlog.net/plugins/plugin-emlog_sinat
Description: 基于sina微博API，可以将在emlog内发布的碎语、日志同步到指定的sina微博账号。
Author:emlog
Author Email: em@emlog.net
Author URL: http://www.emlog.net/
*/

!defined('EMLOG_ROOT') && exit('access deined!');

require_once 'emlog_sinat_profile.php';
require_once 'emlog_sinat_config.php';
include_once( 'weibooauth.php' );

if (file_exists(EMLOG_ROOT.'/content/plugins/emlog_sinat/emlog_sinat_token_conf.php') &&
	isset($_GET['do']) && $_GET['do'] == 'chg') {
	if (!unlink(EMLOG_ROOT.'/content/plugins/emlog_sinat/emlog_sinat_token_conf.php')) {
		emMsg('操作失败，请确保插件目录(/content/plugins/emlog_sinat/)可写');
	}
}

if (file_exists(EMLOG_ROOT.'/content/plugins/emlog_sinat/emlog_sinat_token_conf.php')) {
	include_once( 'emlog_sinat_token_conf.php' );
}

function postBlog2Sinat($blogid) {

	if (!defined('SINAT_ACCESS_TOKEN')) {
		return false;
	}
	
    global $title, $ishide, $action;
    
    if('y' == $ishide) {//忽略写日志时自动保存
        return false;
    }
    if('edit' == $action) {//忽略编辑日志
        return false;
    }
    if('autosave' == $action && 'n' == $ishide) {//忽略编辑日志时移步保存
        return false;
    }

    $t = stripcslashes(trim($title)) . ' ' . Url::log($blogid);

	$c = new WeiboClient( WB_AKEY , WB_SKEY , SINAT_ACCESS_TOKEN , SINAT_ACCESS_SECRET  );
	$c->update(urlencode($t));
}

if (SINAT_SYNC == '3' || SINAT_SYNC == '1') {
    addAction('save_log', 'postBlog2Sinat');
}

function postTwitter2Sinat($t) {
	if (!defined('SINAT_ACCESS_TOKEN')) {
		return false;
	}
    $postData = urlencode(stripcslashes($t));
    if (SINAT_TFROM == '4') {
        $postData = urlencode(stripcslashes(subString($t, 0, 300)) . ' - 来自博客：' . BLOG_URL);
    }

	$c = new WeiboClient( WB_AKEY , WB_SKEY , SINAT_ACCESS_TOKEN , SINAT_ACCESS_SECRET  );
	$c->update($postData);
}

if (SINAT_SYNC == '2' || SINAT_SYNC == '1') {
    addAction('post_twitter', 'postTwitter2Sinat');
}


function emlog_sinat_menu() {
    echo '<div class="sidebarsubmenu" id="emlog_sinat"><a href="./plugin.php?plugin=emlog_sinat">新浪微博设置</a></div>';
}

addAction('adm_sidebar_ext', 'emlog_sinat_menu');
