<?php
/**
 * 碎语
 * @copyright (c) Emlog All Rights Reserved
 * $Id: index.php 1608 2010-03-14 04:58:10Z colt.hawkins@gmail.com $
*/

require_once '../init.php';

define('TEMPLATE_URL', 	TPLS_URL.Option::get('nonce_templet').'/');//前台模板URL
define('TEMPLATE_PATH', TPLS_PATH.Option::get('nonce_templet').'/');//前台模板路径
define('CURPAGE_TW',    'twitter');

$blogtitle = Option::get('blogname');

$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

if (Option::get('istwitter') == 'n') {
    emMsg('抱歉，碎语未开启前台访问！', BLOG_URL);
}

if ($action == 'cal') {
    Calendar::generate();
}

if ($action == '') {
	$user_cache = $CACHE->readCache('user');
    $options_cache = $CACHE->readCache('options');
    extract($options_cache);
    
    $navibar = unserialize($navibar);

    $emTwitter = new emTwitter();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $tws = $emTwitter->getTwitters($page);
    $twnum = $emTwitter->getTwitterNum();
    $pageurl =  pagination($twnum, Option::get('index_twnum'), $page, BLOG_URL.'t/?page');
    $avatar = empty($user_cache[UID]['avatar']) ? '../admin/views/' . ADMIN_TPL . '/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
    $rcode = Option::get('reply_code') == 'y' ? "<img src=\"".DYNAMIC_BLOGURL."?action=ckcode&mode=t\" />" : '';

    $curpage = CURPAGE_TW;
    include View::getView('header');
    require_once View::getView('t');
    View::output();
}
// 获取回复.
if ($action == 'getr') {
    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;

    $emReply = new emReply();
    $replys = $emReply->getReplys($tid, 'n');

    $response = '';
    foreach($replys as $val){
         $response .= "
         <li>
         <span class=\"name\">{$val['name']}</span> {$val['content']}<span class=\"time\">{$val['date']}</span>
         <em><a href=\"javascript:re({$tid}, '@{$val['name']}：');\">回复</a></em>
         </li>";
    }
    echo $response;
}
// 回复碎语.
if ($action == 'reply') {
    $r = isset($_POST['r']) ? addslashes(trim($_POST['r'])) : '';
    $rname = isset($_POST['rname']) ? addslashes(trim($_POST['rname'])) : '';
    $rcode = isset($_POST['rcode']) ? strtoupper(addslashes(trim($_POST['rcode']))) : '';
    $tid = isset($_POST['tid']) ? intval(trim($_POST['tid'])) : '';
    
    $user_cache = $CACHE->readCache('user');

    if (!$r || strlen($r) > 420){
        exit('err1');
    } elseif (ROLE == 'visitor' && empty($rname)) {
        exit('err2');
    }elseif (ROLE == 'visitor' && Option::get('reply_code') == 'y' && session_start() && $rcode != $_SESSION['code']){
        exit('err3');
    }

    foreach($user_cache as $val){
        if(isset($val['name']) && $val['name'] == $rname){
            exit('err4');
        }
    }

    $date = time();
    $name =  ROLE == 'visitor' ? $rname : $user_cache[UID]['name'];;

    $rdata = array(
            'tid' => $tid,
            'content' => $r,
            'name' => $name,
            'date' => $date,
            'hide' => ROLE == 'visitor' ? Option::get('ischkreply') : 'n'
    );

    $emTwitter = new emTwitter();
    $emReply = new emReply();

    $rid = $emReply->addReply($rdata);
    if ($rid === false){
        exit('err5');
    }

    doAction('reply_twitter', $r, $name, $date, $tid);

    if (Option::get('ischkreply') == 'n' || ROLE != 'visitor'){
        $emTwitter->updateReplyNum($tid, '+1');
    }else{
        exit('succ1');
    }

    $CACHE->updateCache('sta');

    $date = smartDate($date);
    $r = htmlClean(stripslashes($r));
    $response = "
         <li style=\"background-color:#FFEEAA\">
         <span class=\"name\">{$name}</span> {$r}<span class=\"time\">{$date}</span>
         <em><a href=\"javascript:re({$tid}, '@{$name}：');\">回复</a></em>
         </li>";
    echo $response;
}
// 回复验证码.
if ($action == 'ckcode') {
    require_once EMLOG_ROOT.'/include/lib/checkcode.php';
}
