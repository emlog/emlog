<?php
/**
 * Link Manager
 * @package EMLOG
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Navi_Model = new Navi_Model();

if ($action == '') {
    $emPage = new Log_Model();

    $navis = $Navi_Model->getNavis();
    $sorts = $CACHE->readCache('sort');
    $pages = $emPage->getAllPageList();

    include View::getView('header');
    require_once(View::getView('navbar'));
    include View::getView('footer');
    View::output();
}

if ($action == 'taxis') {
    $navi = isset($_POST['navi']) ? $_POST['navi'] : '';
    if (!empty($navi)) {
        foreach ($navi as $key => $value) {
            $value = intval($value);
            $key = intval($key);
            $Navi_Model->updateNavi(array('taxis' => $value), $key);
        }
        $CACHE->updateCache('navi');
        emDirect("./navbar.php?active_taxis=1");
    } else {
        emDirect("./navbar.php?error_b=1");
    }
}

if ($action == 'add') {
    $taxis = isset($_POST['taxis']) ? intval(trim($_POST['taxis'])) : 0;
    $naviname = isset($_POST['naviname']) ? addslashes(trim($_POST['naviname'])) : '';
    $url = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
    $pid = isset($_POST['pid']) ? intval($_POST['pid']) : 0;
    $newtab = isset($_POST['newtab']) ? addslashes(trim($_POST['newtab'])) : 'n';

    if ($naviname == '' || $url == '') {
        emDirect("./navbar.php?error_a=1");
    }

    if (!preg_match("/^(http|https|ftp):\/\/.*$/i", $url)) {
        emDirect("./navbar.php?error_f=1");
    }

    $Navi_Model->addNavi($naviname, $url, $taxis, $pid, $newtab);
    $CACHE->updateCache('navi');
    emDirect("./navbar.php?active_add=1");
}

if ($action == 'add_sort') {
    $sort_ids = isset($_POST['sort_ids']) ? $_POST['sort_ids'] : array();

    $sorts = $CACHE->readCache('sort');

    if (empty($sort_ids)) {
        emDirect("./navbar.php?error_d=1");
    }

    foreach ($sort_ids as $val) {
        $sort_id = intval($val);
        $Navi_Model->addNavi(addslashes($sorts[$sort_id]['sortname']), '', 0, 0, 'n', Navi_Model::navitype_sort, $sort_id);
    }

    $CACHE->updateCache('navi');
    emDirect("./navbar.php?active_add=1");
}

if ($action == 'add_page') {
    $pages = isset($_POST['pages']) ? $_POST['pages'] : array();

    if (empty($pages)) {
        emDirect("./navbar.php?error_e=1");
    }

    foreach ($pages as $id => $title) {
        $Navi_Model->addNavi($title, '', 0, 0, 'n', Navi_Model::navitype_page, $id);
    }

    $CACHE->updateCache('navi');
    emDirect('./navbar.php?active_add=1');
}

if ($action == 'mod') {
    $naviId = isset($_GET['navid']) ? intval($_GET['navid']) : '';

    $navis = $CACHE->readCache('navi');

    $naviData = $Navi_Model->getOneNavi($naviId);
    extract($naviData);

    if ($type != Navi_Model::navitype_custom) {
/*vot*/ $url = lang('address_generated');
    }

    $conf_newtab = $newtab == 'y' ? 'checked="checked"' : '';
    $conf_isdefault = $type != Navi_Model::navitype_custom ? 'disabled="disabled"' : '';

    include View::getView('header');
    require_once(View::getView('naviedit'));
    include View::getView('footer');
    View::output();
}

if ($action == 'update') {
    $naviname = isset($_POST['naviname']) ? addslashes(trim($_POST['naviname'])) : '';
    $url = isset($_POST['url']) ? addslashes(trim($_POST['url'])) : '';
    $newtab = isset($_POST['newtab']) ? addslashes(trim($_POST['newtab'])) : 'n';
    $naviId = isset($_POST['navid']) ? intval($_POST['navid']) : '';
    $isdefault = isset($_POST['isdefault']) ? addslashes(trim($_POST['isdefault'])) : 'n';
    $pid = isset($_POST['pid']) ? intval(trim($_POST['pid'])) : 0;

    $navi_data = array(
        'naviname' => $naviname,
        'newtab' => $newtab,
        'pid' => $pid,
    );

    if (empty($naviname)) {
        unset($navi_data['naviname']);
    }

    if ($isdefault == 'n') {
        $navi_data['url'] = $url;
    }

    $Navi_Model->updateNavi($navi_data, $naviId);

    $CACHE->updateCache('navi');
    emDirect("./navbar.php?active_edit=1");
}

if ($action == 'del') {
    LoginAuth::checkToken();
    $navid = isset($_GET['id']) ? intval($_GET['id']) : '';
    $Navi_Model->deleteNavi($navid);
    $CACHE->updateCache('navi');
    emDirect("./navbar.php?active_del=1");
}

if ($action == 'hide') {
    $naviId = isset($_GET['id']) ? intval($_GET['id']) : '';

    $Navi_Model->updateNavi(array('hide' => 'y'), $naviId);

    $CACHE->updateCache('navi');
    emDirect('./navbar.php');
}

if ($action == 'show') {
    $naviId = isset($_GET['id']) ? intval($_GET['id']) : '';

    $Navi_Model->updateNavi(array('hide' => 'n'), $naviId);

    $CACHE->updateCache('navi');
    emDirect('./navbar.php');
}
