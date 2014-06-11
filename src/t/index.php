<?php
/**
 * Twitter
 * @copyright (c) Emlog All Rights Reserved
*/

require_once '../init.php';

define('TEMPLATE_PATH', TPLS_PATH.Option::get('nonce_templet').'/');//Front template path

$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

if (Option::get('istwitter') == 'n') {
    emMsg($lang['twitter_not_guest'], BLOG_URL);
}

if ($action == 'cal') {
    Calendar::generate();
}

if ($action == '') {
	$user_cache = $CACHE->readCache('user');
    $options_cache = Option::getAll();
    extract($options_cache);
    
    $Twitter_Model = new Twitter_Model();
    $Navi_Model = new Navi_Model();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $tws = $Twitter_Model->getTwitters($page);
    $twnum = $Twitter_Model->getTwitterNum();
    $pageurl =  pagination($twnum, Option::get('index_twnum'), $page, BLOG_URL.'t/?page=');
    $avatar = empty($user_cache[UID]['avatar']) ? '../admin/views/images/avatar.jpg' : '../' . $user_cache[UID]['avatar'];
    $rcode = Option::get('reply_code') == 'y' ? "<img src=\"".DYNAMIC_BLOGURL."?action=ckcode&mode=t\" />" : '';

    $site_title = $Navi_Model->getNaviNameByType(Navi_Model::navitype_t) . ' - ' . $site_title;

    include View::getView('header');
    require_once View::getView('t');
    View::output();
}

// Get Reply
if ($action == 'getr') {
    $tid = isset($_GET['tid']) ? intval($_GET['tid']) : null;

    $Reply_Model = new Reply_Model();
    $replys = $Reply_Model->getReplys($tid, 'n');

    $response = '';
    if ($replys) {
	    foreach($replys as $val){
	    	$sub_reply = Option::get('istreply') == 'y' ? "<a href=\"javascript:re({$tid}, '@".addslashes($val['name']).":');\">{$lang['reply']}</a>" : '';
	    	$response .= "
	         <li>
	         <span class=\"name\">{$val['name']}</span> {$val['content']}<span class=\"time\">{$val['date']}</span>
	         <em>$sub_reply</em>
	         </li>";
	    }
    } else{
    	$response .= "<li>{$lang['reply_no_yet']}</li>";
    }
    echo $response;
}

// Reply twitter
if ($action == 'reply') {
    $r = isset($_POST['r']) ? addslashes(trim($_POST['r'])) : '';
    $rname = isset($_POST['rname']) ? addslashes(trim($_POST['rname'])) : '';
    $rcode = isset($_POST['rcode']) ? strtoupper(addslashes(trim($_POST['rcode']))) : '';
    $tid = isset($_POST['tid']) ? intval(trim($_POST['tid'])) : '';

    $user_cache = $CACHE->readCache('user');

    if (Option::get('istreply') == 'n' ) {
    	exit('err0');
    } elseif (!$r || mb_strlen($r) > 420){
        exit('err1');
    } elseif (ROLE == ROLE_VISITOR && empty($rname)) {
        exit('err2');
    }elseif (ROLE == ROLE_VISITOR && Option::get('reply_code') == 'y' && session_start() && $rcode != $_SESSION['code']){
        exit('err3');
    }

    foreach($user_cache as $val){
        if(isset($val['name']) && $val['name'] == $rname){
            exit('err4');
        }
    }

    $date = time();
    $name =  subString(ROLE == ROLE_VISITOR ? $rname : addslashes($user_cache[UID]['name']), 0, 16);

    $rdata = array(
            'tid' => $tid,
            'content' => $r,
            'name' => $name,
            'date' => $date,
            'hide' => ROLE == ROLE_VISITOR ? Option::get('ischkreply') : 'n'
    );

    $Twitter_Model = new Twitter_Model();
    $Reply_Model = new Reply_Model();

    $rid = $Reply_Model->addReply($rdata);
    if ($rid === false){
        exit('err5');
    }

    doAction('reply_twitter', $r, $name, $date, $tid);

    if (Option::get('ischkreply') == 'n' || ROLE != ROLE_VISITOR){
        $Twitter_Model->updateReplyNum($tid, '+1');
    }else{
        exit('succ1');
    }

    $CACHE->updateCache('sta');
    $_SESSION['code'] = null;

    $date = smartDate($date);
    $r = htmlClean(stripslashes($r));
/*vot*/    $response = "
         <li>
         <span class=\"name\">".stripslashes(htmlspecialchars($name))."</span> {$r}<span class=\"time\">{$date}</span>
         <em><a href=\"javascript:re({$tid}, '@{$name}:');\">{$lang['reply']}</a></em>
         </li>";
    echo $response;
}

// Reply verification code
if ($action == 'ckcode') {
    require_once EMLOG_ROOT.'/include/lib/checkcode.php';
}
