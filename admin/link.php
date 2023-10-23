<?php
/**
 * links
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Link_Model = new Link_Model();

if (empty($action)) {
    $links = $Link_Model->getLinks();
    include View::getAdmView('header');
    require_once(View::getAdmView('links'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'link_taxis') {
    $link = isset($_POST['link']) ? $_POST['link'] : '';

    if (empty($link)) {
        emDirect("./link.php?error_b=1");
    }

    foreach ($link as $key => $value) {
        $value = (int)$value;
        $key = (int)$key;
        $Link_Model->updateLink(array('taxis' => $key), $value);
    }
    $CACHE->updateCache('link');
    emDirect("./link.php?active_taxis=1");
}

if ($action == 'save') {
    $siteName = Input::postStrVar('sitename');
    $siteUrl = Input::postStrVar('siteurl');
    $description = Input::postStrVar('description');
    $linkId = Input::postIntVar('linkid');

    if ($siteName == '' || $siteUrl == '') {
        emDirect("./link.php?error_a=1");
    }

    if (!preg_match("/^http|ftp.+$/i", $siteUrl)) {
        $siteUrl = 'https://' . $siteUrl;
    }

    $data = [
        'sitename'    => $siteName,
        'siteurl'     => $siteUrl,
        'description' => $description
    ];

    if ($linkId) {
        $Link_Model->updateLink($data, $linkId);
    } else {
        $Link_Model->addLink($siteName, $siteUrl, $description);
    }

    $CACHE->updateCache('link');
    emDirect("./link.php?active_save=1");
}

if ($action == 'del') {
    LoginAuth::checkToken();
    $linkId = Input::getIntVar('linkid');

    $Link_Model->deleteLink($linkId);
    $CACHE->updateCache('link');
    emDirect("./link.php?active_del=1");
}

if ($action == 'hide') {
    $linkId = Input::getIntVar('linkid');

    $Link_Model->updateLink(['hide' => 'y'], $linkId);

    $CACHE->updateCache('link');
    emDirect('./link.php');
}

if ($action == 'show') {
    $linkId = Input::getIntVar('linkid');

    $Link_Model->updateLink(['hide' => 'n'], $linkId);

    $CACHE->updateCache('link');
    emDirect('./link.php');
}
