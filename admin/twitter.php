<?php

/**
 * notes
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

const TW_PAGE_COUNT = 20; // 微语每页显示数量

require_once 'globals.php';

$Twitter_Model = new Twitter_Model();

if (empty($action)) {
    $page = Input::getIntVar('page', 1);

    $uid = user::isAdmin() ? '' : UID;
    $tws = $Twitter_Model->getTwitters($uid, $page, TW_PAGE_COUNT, true);
    $twnum = $Twitter_Model->getCount($uid);

    $subPage = '';
    foreach ($_GET as $key => $val) {
        $subPage .= $key != 'page' ? "&$key=$val" : '';
    }
    $pageurl = pagination($twnum, TW_PAGE_COUNT, $page, "twitter.php?{$subPage}&page=");

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once(View::getAdmView('twitter'));
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

if ($action == 'post') {
    $t = Input::postStrVar('t');
    $private = Input::postStrVar('private', 'n');

    if (!$t) {
        FlashMsg::redirectAdmin('twitter', 'error_a');
    }

    $data = [
        'content' => $t,
        'private' => $private,
        'author'  => UID,
        'date'    => time(),
        'ip'      => getIp(),
    ];

    $id = $Twitter_Model->addTwitter($data);
    $CACHE->updateCache('sta');
    doAction('post_note', $data, $id);
    FlashMsg::redirectAdmin('twitter', 'active_t');
}

if ($action == 'settop') {
    LoginAuth::checkToken();
    $id = Input::getIntVar('id');
    $top = Input::getStrVar('top') === 'y' ? 'y' : 'n';

    $Twitter_Model->update(['top' => $top], $id);
    emDirect("twitter.php");
}

if ($action == 'update') {
    $t = Input::postStrVar('t');
    $id = Input::postIntVar('id');

    if (!$t) {
        FlashMsg::redirectAdmin('twitter', 'error_a');
    }

    $data = [
        'content' => $t,
    ];

    $Twitter_Model->update($data, $id);
    $CACHE->updateCache('sta');
    FlashMsg::redirectAdmin('twitter', 'active_set');
}

if ($action == 'del') {
    LoginAuth::checkToken();
    $id = Input::getIntVar('id');
    $Twitter_Model->delTwitter($id);
    $CACHE->updateCache('sta');
    emDirect("twitter.php");
}
