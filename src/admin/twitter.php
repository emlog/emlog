<?php
/**
 * 碎语twitter
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id: twitter.php 1596 2010-03-02 12:09:48Z Colt.hawkins $
 */

require_once 'globals.php';
require_once EMLOG_ROOT.'/model/class.twitter.php';

$emTwitter = new emTwitter();

if($action == '')
{
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $tws = $emTwitter->getTwitters($page);
    $twnum = $emTwitter->getTwitterNum();
    $pageurl =  pagination($twnum, ADMIN_PERPAGE_NUM, $page, 'twitter.php?page');

    $avatar = '../' . $user_cache[UID]['avatar'];

    //设置
    if($istwitter=='y')
	{
		$ex1="selected=\"selected\"";
		$ex2="";
	}else{
		$ex1="";
		$ex2="selected=\"selected\"";
	}
    if($reply_code=='y')
	{
		$ex3="selected=\"selected\"";
		$ex4="";
	}else{
		$ex3="";
		$ex4="selected=\"selected\"";
	}

    include getViews('header');
    require_once getViews('twitter');
    include getViews('footer');
    cleanPage();
}
if($action == 'post')
{
    $t = isset($_POST['t']) ? addslashes($_POST['t']) : '';
    if(!$t)
    {
        header("Location: twitter.php?error_a=true");
        exit;
    }
    
    $tdata = array(
            'content' => $t,
            'author' => UID,
            'date' => time(),
    );
    
    $emTwitter->addTwitter($tdata);
    $CACHE->updateCache('sta');
    header("Location: twitter.php?active_t=true");
}
if($action == 'del')
{
    $id = isset($_GET['id']) ? intval($_GET['id']) : '';

	$emTwitter->delTwitter($id);
	$CACHE->updateCache('sta');
	header("Location: twitter.php?active_del=true");
}
if($action == 'getreply')
{
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $emReply = new emReply();
    $replys = $emReply->getReplys($tid, $page);
    //$replyNums = $emTwitter->getReplyNum();
    
    $response = '';
    foreach($replys as $val)
    {
         if($val['hide'] == 'n'){
            $style = "background-color:#FFF";
            $act = "<span><a href=\"javascript: hidereply({$val['id']});\">屏蔽</a></span> ";
         } else {
            $style = "background-color:#FEE0E4";
            $act = "<span><a href=\"javascript: pubreply({$val['id']});\">审核</a></span> ";
         }
         $response .= "
         <dd id=\"reply_{$val['id']}\" style=\"{$style}\">
         <span class=\"name\">{$val['name']}</span> {$val['content']}<span class=\"time\">{$val['date']}</span>{$act}
         <a href=\"javascript: delreply({$val['id']});\">删除</a> 
         <em><a href=\"javascript:reply({$tid}, '[回复:{$val['content']}]:');\">回复</a></em>
         </dd>";
    }
    echo $response;
}
if($action == 'reply')
{
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $r = isset($_POST['r']) ? addslashes($_POST['r']) : '';
    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;

    if(!$r)
    {
        echo '碎语内容不能为空';
        exit;
    }

    $name = '管理员';
    $date = time();
    
    $rdata = array(
            'tid' => $tid,
            'content' => $r,
            'name' => $name,
            'date' => $date,
    );

    $emReply = new emReply();

    $rid = $emReply->addReply($rdata);
    $emTwitter->updateReplyNum($tid, '+1');

    $CACHE->updateCache('sta');
    
    $date = smartyDate($date);
    $response = "<dd id=\"reply_{$rid}\">
         <p><span class=\"name\">{$name}</span> {$r}<span class=\"time\">{$date}</span>
         <a href=\"javascript: delreply({$rid});\">删除</a> 
         <em><a href=\"javascript:reply({$tid}, '[回复:{$r}]:');\">回复</a></em></p>
         </dd>";
    echo $response;
}
if($action == 'delreply')
{
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
    $emReply = new emReply();
    $tid = $emReply->delReply($rid);
    $emTwitter->updateReplyNum($tid, '-1');
    echo $tid;
}
if($action == 'hidereply')
{
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
    $emReply = new emReply();
    $emReply->hideReply($rid);
}
if($action == 'pubreply')
{
    require_once EMLOG_ROOT.'/model/class.reply.php';

    $rid = isset($_GET['rid']) ? intval($_GET['rid']) : null;
    $emReply = new emReply();
    $emReply->pubReply($rid);
}
if($action == 'set')
{
    $data = array(
        'istwitter' => isset($_POST['istwitter']) ? addslashes($_POST['istwitter']) : 'y',
        'reply_code' => isset($_POST['reply_code']) ? addslashes($_POST['reply_code']) : 'n',
        'index_twnum' => isset($_POST['index_twnum']) ? intval($_POST['index_twnum']) : 10,
    );
	foreach ($data as $key => $val)
	{
		updateOption($key, $val);
	}

	$CACHE->updateCache('options');

    header("Location: twitter.php?active_set=true");

}
