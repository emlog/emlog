<?php
/**
 * tags
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Tag_Model = new Tag_Model();

if (empty($action)) {
    $page_count = 100;
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');

    $tags = $Tag_Model->getTags($keyword, $page_count, $page);
    $tags_count = $Tag_Model->getTagsCount();
    $pageurl = pagination($tags_count, $page_count, $page, "./tag.php?page=");

    include View::getAdmView('header');
    require_once View::getAdmView('tag');
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'update_tag') {
    $tagName = Input::postStrVar('tagname');
    $tagId = Input::postIntVar('tid');

    if (empty($tagName)) {
        emDirect("tag.php?error_a=1");
    }

    $Tag_Model->updateTagName($tagId, $tagName);
    $CACHE->updateCache('tags');
    emDirect("./tag.php?active_edit=1");
}

if ($action == 'del_tag') {
    $tid = Input::getIntVar('tid');

    LoginAuth::checkToken();
    if (!$tid) {
        emDirect("./tag.php?error_a=1");
    }
    $Tag_Model->deleteTag($tid);
    $CACHE->updateCache('tags');
    emDirect("./tag.php?active_del=1");
}

if ($action === 'operate_tag') {
    $operate = Input::postStrVar('operate');
    $tids = isset($_POST['tids']) ? array_map('intval', $_POST['tids']) : [];

    LoginAuth::checkToken();
    if ($operate === 'del') {
        foreach ($tids as $value) {
            $Tag_Model->deleteTag($value);
        }
        $CACHE->updateCache('tags');
        emDirect("./tag.php?active_del=1");
    }
}
