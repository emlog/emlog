<?php
/**
 * 碎语
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.0
 * $Id: twitter.php 1596 2010-03-02 12:09:48Z Colt.hawkins $
 */

require_once 'globals.php';
require_once EMLOG_ROOT.'/model/class.twitter.php';

$emTwitter = new emTwitter();

if ($action == '') {
    require_once EMLOG_ROOT.'/model/class.reply.php';
    $emReply = new emReply();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $tws = $emTwitter->getTwitters($page);
    $twnum = $emTwitter->getTwitterNum();
    $pageurl =  pagination($twnum, ADMIN_PERPAGE_NUM, $page, 'twitter.php?page');
    $avatar = empty($user_cache[UID]['avatar']) ? './views/' . ADMIN_TPL . '/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];

    if ($istwitter=='y'){
		$ex1="selected=\"selected\"";
		$ex2="";
	}else{
		$ex1="";
		$ex2="selected=\"selected\"";
	}
    if ($reply_code=='y'){
		$ex3="selected=\"selected\"";
		$ex4="";
	}else{
		$ex3="";
		$ex4="selected=\"selected\"";
	}
    if ($ischkreply=='y'){
		$ex5="selected=\"selected\"";
		$ex6="";
	}else{
		$ex5="";
		$ex6="selected=\"selected\"";
	}

    include getViews('header');
    require_once getViews('twitter');
    include getViews('footer');
    cleanPage();
}
// 发布碎语.
if ($action == 'post') 
{
    $t = isset($_POST['t']) ? addslashes(trim($_POST['t'])) : '';

    if (!$t){
        header("Location: twitter.php?error_a=true");
        exit;
    }

    //识别http网址
    $t = htmlspecialchars(preg_replace("/http:\/\/[\w-.?\/=&%]*/i", "[+@] href=\"\$0\" target=\"_blank\"[@+]\$0[-@+]", $t), ENT_NOQUOTES);
    $t = str_replace(array('[+@]','[@+]','[-@+]'), array('<a','>','</a>'), $t);

    $tdata = array('content' => $t,
            'author' => UID,
            'date' => time(),
    );

    $emTwitter->addTwitter($tdata);
    $CACHE->updateCache('sta');
    header("Location: twitter.php?active_t=true");
}
// 删除碎语.
if ($action == 'del') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : '';

	$emTwitter->delTwitter($id);
	$CACHE->updateCache('sta');
	header("Location: twitter.php?active_del=true");
}
// 获取回复.
if ($action == 'getreply') {
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;

    $emReply = new emReply();
    $replys = $emReply->getReplys($tid);

    $response = '';
    foreach($replys as $val){
         if ($val['hide'] == 'n'){
            $style = "background-color:#FFF";
            $act = "<span><a href=\"javascript: hidereply({$val['id']},{$tid});\">屏蔽</a></span> ";
         } else {
            $style = "background-color:#FEE0E4";
            $act = "<span><a href=\"javascript: pubreply({$val['id']},{$tid});\">审核</a></span> ";
         }
         $response .= "
         <li id=\"reply_{$val['id']}\" style=\"{$style}\">
         <span class=\"name\">{$val['name']}</span> {$val['content']}<span class=\"time\">{$val['date']}</span>{$act}
         <a href=\"javascript: delreply({$val['id']},{$tid});\">删除</a> 
         <em><a href=\"javascript:reply({$tid}, '@{$val['name']}:');\">回复</a></em>
         </li>";
    }
    echo $response;
}
// 回复碎语.
if ($action == 'reply') {
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $r = isset($_POST['r']) ? addslashes(trim($_POST['r'])) : '';
    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;

    if (!$r || strlen($r) > 420){
        exit('err1');
    }

    $date = time();
    $name =  $user_cache[UID]['name'];

    $rdata = array(
            'tid' => $tid,
            'content' => $r,
            'name' => $name,
            'date' => $date,
    );

    $emReply = new emReply();
    $rid = $emReply->addReply($rdata);
    if ($rid === false){
        exit('err2');
    }
    $emTwitter->updateReplyNum($tid, '+1');
    $CACHE->updateCache('sta');

    $date = smartyDate($date);
    $r = htmlClean(stripslashes($r));
    $response = "
         <li id=\"reply_{$rid}\" style=\"background-color:#FFEEAA\">
         <span class=\"name\">{$name}</span> {$r}<span class=\"time\">{$date}</span>
         <span><a href=\"javascript: hidereply({$rid},{$tid});\">屏蔽</a></span> 
         <a href=\"javascript: delreply({$rid},{$tid});\">删除</a> 
         <em><a href=\"javascript:reply({$tid}, '@{$name}:');\">回复</a></em>
         </li>";
    echo $response;
}
// 删除回复.
if ($action == 'delreply') {
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;
    $emReply = new emReply();
    if( $emReply->delReply($rid) == 'n'){
        $emTwitter->updateReplyNum($tid, '-1');
    }
    echo $tid;
}
// 隐藏回复.
if ($action == 'hidereply') {
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;
    $emReply = new emReply();
    $emReply->hideReply($rid);
    $emTwitter->updateReplyNum($tid, '-1');
}
// 审核回复.
if ($action == 'pubreply') {
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;
    $emReply = new emReply();
    $emReply->pubReply($rid);
    $emTwitter->updateReplyNum($tid, '+1');
}
// 碎语设置.
if ($action == 'set') {
    $data = array(
        'istwitter' => isset($_POST['istwitter']) ? addslashes($_POST['istwitter']) : 'y',
        'ischkreply' => isset($_POST['ischkreply']) ? addslashes($_POST['ischkreply']) : 'n',
        'reply_code' => isset($_POST['reply_code']) ? addslashes($_POST['reply_code']) : 'n',
        'index_twnum' => isset($_POST['index_twnum']) ? intval($_POST['index_twnum']) : 10,
    );

	foreach ($data as $key => $val){
		updateOption($key, $val);
	}

	$CACHE->updateCache('options');
    header("Location: twitter.php?active_set=true");
}
