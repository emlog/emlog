<?php
/**
 * article save and update
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Log_Model = new Log_Model();
$Tag_Model = new Tag_Model();

$title = Input::postStrVar('title');
$postDate = isset($_POST['postdate']) ? strtotime(trim($_POST['postdate'])) : '';
$sort = Input::postIntVar('sort', -1);
$tagstring = isset($_POST['tag']) ? strip_tags(addslashes(trim($_POST['tag']))) : '';
$content = Input::postStrVar('logcontent');
$excerpt = Input::postStrVar('logexcerpt');
$alias = Input::postStrVar('alias');
$allow_remark = Input::postStrVar('allow_remark', 'n');
$password = Input::postStrVar('password');
$cover = Input::postStrVar('cover');
$link = Input::postStrVar('link');
$author = isset($_POST['author']) && User::haveEditPermission() ? (int)trim($_POST['author']) : UID;
$ishide = isset($_POST['ishide']) && !empty($_POST['ishide']) && !isset($_POST['pubdf']) ? addslashes($_POST['ishide']) : 'n';
$blogid = Input::postIntVar('as_logid', -1); //自动保存为草稿的文章id

if (!empty($alias)) {
    $logalias_cache = $CACHE->readCache('logalias');
    $alias = $Log_Model->checkAlias($alias, $logalias_cache, $blogid);
}

//管理员发文不审核,注册用户受开关控制
$checked = Option::get('ischkarticle') == 'y' && !User::haveEditPermission() ? 'n' : 'y';

$logData = [
    'title'        => $title,
    'alias'        => $alias,
    'content'      => $content,
    'excerpt'      => $excerpt,
    'cover'        => $cover,
    'author'       => $author,
    'sortid'       => $sort,
    'date'         => $postDate,
    'allow_remark' => $allow_remark,
    'hide'         => $ishide,
    'checked'      => $checked,
    'password'     => $password,
    'link'         => $link,
];

if (User::isWiter()) {
    $count = $Log_Model->getPostCountByUid(UID, time() - 3600 * 24);
    $post_per_day = Option::get('posts_per_day');
    if ($count >= $post_per_day) {
        emDirect("./article.php?error_post_per_day=1");
    }
}

if ($blogid > 0) {
    $Log_Model->updateLog($logData, $blogid);
    $Tag_Model->updateTag($tagstring, $blogid);
} else {
    $blogid = $Log_Model->addlog($logData);
    $Tag_Model->addTag($tagstring, $blogid);
}

$CACHE->updateArticleCache();

doAction('save_log', $blogid);

switch ($action) {
    case 'autosave':
        echo 'autosave_gid:' . $blogid . '_';
        break;
    case 'add':
    case 'edit':
        if ($ishide === 'y') {
            emDirect("./article.php?draft=1&active_savedraft=1"); //草稿保存成功
        }
        if ($action === 'add' || isset($_POST['pubdf'])) {
            if ($checked === 'n') {
                notice::sendNewPostMail($title);
            }
            emDirect("./article.php?active_post=1");//文章发布成功
        } else {
            emDirect("./article.php?active_savelog=1");//文章保存成功
        }
        break;
}
