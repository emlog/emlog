<?php

/**
 * tags
 * @package EMLOG
 * 
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

if ($action == 'add_tag') {
    $tagName = Input::postStrVar('tagname');
    $title = Input::postStrVar('title');
    $kw = Input::postStrVar('kw');
    $description = Input::postStrVar('description');

    LoginAuth::checkToken();
    if (empty($tagName)) {
        FlashMsg::redirectAdmin('tag', 'error_a');
    }

    // 检查标签是否已存在
    $existingTagId = $Tag_Model->getIdFromName($tagName);
    if ($existingTagId) {
        FlashMsg::redirectAdmin('tag', 'error_exist');
    }

    // 创建新标签
    $tagId = $Tag_Model->createTag($tagName);

    // 更新标签的详细信息
    if ($tagId) {
        $Tag_Model->updateTagName($tagId, $tagName, $kw, $title, $description);
    }

    $CACHE->updateCache('tags');
    FlashMsg::redirectAdmin('tag', 'active_add');
}

if ($action == 'update_tag') {
    $tagName = Input::postStrVar('tagname');
    $title = Input::postStrVar('title');
    $kw = Input::postStrVar('kw');
    $description = Input::postStrVar('description');
    $tagId = Input::postIntVar('tid');

    if (empty($tagName)) {
        FlashMsg::redirectAdmin('tag', 'error_a');
    }

    $Tag_Model->updateTagName($tagId, $tagName, $kw, $title, $description);
    $CACHE->updateCache('tags');
    FlashMsg::redirectAdmin('tag', 'active_edit');
}

if ($action == 'del_tag') {
    $tid = Input::getIntVar('tid');

    LoginAuth::checkToken();
    if (!$tid) {
        FlashMsg::redirectAdmin('tag', 'error_a');
    }
    $Tag_Model->deleteTag($tid);
    $CACHE->updateCache('tags');
    emDirect("./tag.php");
}

if ($action === 'operate_tag') {
    $operate = Input::postStrVar('operate');
    $tids = Input::postIntArray('tids', []);

    LoginAuth::checkToken();
    if ($operate === 'del') {
        foreach ($tids as $value) {
            $Tag_Model->deleteTag($value);
        }
        $CACHE->updateCache('tags');
        emDirect("./tag.php");
    }
}
