<?php
/**
 * twitter
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id: twitter.php 1608 2010-03-14 04:58:10Z colt.hawkins@gmail.com $
*/

require_once '../common.php';

define('TEMPLATE_URL', 	TPLS_URL.$nonce_templet.'/');//前台模板URL
define('TEMPLATE_PATH', TPLS_PATH.$nonce_templet.'/');//前台模板路径

$calendar_url = BLOG_URL.'calendar.php?' ;
$blogtitle = $blogname;

if ($action == '') {
    require_once EMLOG_ROOT.'/model/class.twitter.php';

    $emTwitter = new emTwitter();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $tws = $emTwitter->getTwitters($page);
    $twnum = $emTwitter->getTwitterNum();
    $pageurl =  pagination($twnum, $index_twnum, $page, './twitter.php?page');
    $avatar = empty($user_cache[UID]['avatar']) ? '../admin/views/' . ADMIN_TPL . '/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];

    include getViews('header');
    require_once getViews('t');
    cleanPage();
}
