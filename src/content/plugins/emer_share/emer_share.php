<?php
/*
  Plugin Name:emer云平台分享插件
  Version:3.0.1
  Plugin URL:http://www.emlog.net/plugins/plugin-emer_share
  Description:分享你的博文、碎语到emlog官方云分享平台，让你的博客获得更多的关注。
  Author:emlog
  Author URL:http://www.emlog.net
 */

if (!defined('EMLOG_ROOT')) {exit('error!');}
define("EMER_API_URL",'http://emer.sinaapp.com/');
define('EMEER_SHARE_VERSION','3.0.1');

$emer_share_relate_blogId = 0;

require_once EMLOG_ROOT . '/content/plugins/emer_share/emer_share_config.php';
include EMLOG_ROOT . '/content/plugins/emer_share/emer_share_function.php';

if (file_exists(EMLOG_ROOT . '/content/plugins/emer_share/emer_share_profile.php')) {
    require_once(EMLOG_ROOT . '/content/plugins/emer_share/emer_share_profile.php');
}

function emer_share() {
    echo '<div class="sidebarsubmenu" id="emer_share"><a href="./plugin.php?plugin=emer_share">emer分享设置</a></div>';
}

addAction('adm_sidebar_ext', 'emer_share');

function postBlog2Emer($blogid) {
    global $title, $ishide, $action, $logData, $CACHE,$tagstring;

    if ('y' == $ishide) {//忽略写日志时自动保存
        return false;
    }
    if ('edit' == $action && !isset($_POST['pubdf'])) {//忽略编辑日志
        return false;
    }
    if ('autosave' == $action && 'n' == $ishide) {//忽略编辑日志时移步保存
        return false;
    }
    if (!empty($logData['password'])) {//忽略加密日志
        return false;
    }

    $emer_user_cache = $CACHE->readCache('user');

    $emer_post_data = array(
        "title" => stripcslashes(trim($title)),
        "excerpt" => emer_share_excerpt($logData),
        "viewurl" => Url::log($blogid),
        "tags" => $tagstring,
		"blogid"=>$blogid
    );
    emer_share_post('blog', $emer_post_data);
}

function postdrafBlog2Emer($blogid) {
    global $Log_Model, $CACHE;
	$Tag_Model = new Tag_Model();
    $logData = $Log_Model->getOneLogForAdmin($blogid);
	$tags = $Tag_Model->getTag($blogid);
    $emer_user_cache = $CACHE->readCache('user');
    $emer_post_data = array(
        "title" => $logData['title'],
        "excerpt" => emer_share_excerpt($logData),
        "viewurl" => Url::log($blogid),
        "tags" => !empty($tags) ? join(",",$tags) : "",
		"blogid"=>$blogid
    );
    emer_share_post('blog', $emer_post_data);
}

if (EMEER_SHARE_SYNC == '3' || EMEER_SHARE_SYNC == '1'&& defined('EMEER_SHARE_PW') && defined('EMEER_SHARE_ID')) {
    addAction('save_log', 'postBlog2Emer');
    addAction('pub_log', 'postdrafBlog2Emer');
}

function postTwitter2Emer($t) {
    global $CACHE;
    $emer_user_cache = $CACHE->readCache('user');

    $emer_post_data = array(
        "content" => preg_replace("/&[a-z]+\;/i", '', strip_tags(stripcslashes($t)))
    );

    emer_share_post('twitter', $emer_post_data);
}

if (EMEER_SHARE_SYNC == '2' || EMEER_SHARE_SYNC == '1' && defined('EMEER_SHARE_PW') && defined('EMEER_SHARE_ID')) {
    addAction('post_twitter', 'postTwitter2Emer');
}

//云平台相关日志
function emer_share_relate($logData = array()){
	global $emer_share_relate_blogId;
	$emer_share_relate_blogId = $logData['logid'];
	echo '<div id="emer_share_related_log" style="font-size:12px;margin: 12px auto;padding: 10px 0px;"></div>';
}
function emer_share_relate_js(){
	global $emer_share_relate_blogId;
	if($emer_share_relate_blogId == 0) return;
	echo '<script src="'.EMER_API_URL.'public/js/relate.js" type="text/javascript"></script>';
	
	echo '<script src="'.EMER_API_URL.'api/relate?callback=emer_relate_callback&tags='.urlencode(get_blog_tag($emer_share_relate_blogId)).'&num='.EMEER_SHARE_RALATENUM.'&rand='.rand().'" type="text/javascript" defer></script>';
	$emer_share_relate_blogId = 0;
}
if(EMEER_SHARE_RALATE){
addAction('log_related','emer_share_relate');
addAction('index_footer','emer_share_relate_js');
}
