<?php

/**
 * article save and update
 * @package EMLOG
 * @link https://www.emlog.net
 */

require_once 'globals.php';

if (empty($_POST)) {
    exit;
}

$Log_Model = new Log_Model();
$Tag_Model = new Tag_Model();

$title = Input::postStrVar('title');
$postDate = Input::postStrVar('postdate');
$postDate = $postDate ? strtotime($postDate) : time();
$sort = Input::postIntVar('sort', -1);
$tagstring = strip_tags(Input::postStrVar('tag'));
$content = Input::postStrVar('logcontent');
$excerpt = Input::postStrVar('logexcerpt');
$alias = Input::postStrVar('alias');
$top = Input::postStrVar('top', 'n');
$sortop = Input::postStrVar('sortop', 'n');
$allow_remark = Input::postStrVar('allow_remark', 'n');
$password = Input::postStrVar('password');
$template = Input::postStrVar('template');
$cover = Input::postStrVar('cover');
$link = Input::postStrVar('link');
$author  = Input::postIntVar('author');
$author = $author && User::haveEditPermission() ? $author : UID; // 非管理员用户只能修改自己的文章
$ishide = Input::postStrVar('ishide', 'y');
$blogid = Input::postIntVar('as_logid', -1); //自动保存为草稿的文章id
$pubPost = Input::postStrVar('pubPost'); // 是否直接发布文章，而非保存草稿
$auto_excerpt = Input::postStrVar('auto_excerpt', 'n');
$auto_cover = Input::postStrVar('auto_cover', 'n');
$field_keys = Input::postStrArray('field_keys');
$field_values = Input::postStrArray('field_values');

// 自动截取摘要
if (empty($excerpt) && $auto_excerpt === 'y') {
    $origContent = trim($_POST['logcontent']);
    $parseDown = new Parsedown();
    $excerpt = $parseDown->text($origContent);
    $excerpt = extractHtmlData($excerpt, 180);
    $excerpt = str_replace(["\r", "\n", "'", '"'], ' ', $excerpt);
    $excerpt = addslashes($excerpt);
}

// 自动提取封面
if ($content && empty($cover) && $auto_cover === 'y') {
    $cover = getFirstImage($content);
}

if ($pubPost) {
    $ishide = 'n';
}

// 检查文章别名
if (!preg_match('/^[a-zA-Z0-9_-]+$/', $alias)) {
    $alias = '';
}
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
    'top '         => $top,
    'sortop '      => $sortop,
    'allow_remark' => $allow_remark,
    'hide'         => $ishide,
    'checked'      => $checked,
    'password'     => $password,
    'link'         => $link,
    'template'     => $template,
];

// 每日发文限制
if (Article::hasReachedDailyPostLimit()) {
    emDirect("./article.php?error_post_per_day=1");
}

doMultiAction('pre_save_log', $logData, $logData);

if ($blogid > 0) {
    $Log_Model->updateLog($logData, $blogid);
    $Tag_Model->updateTag($tagstring, $blogid);
} else {
    $blogid = $Log_Model->addlog($logData);
    $Tag_Model->addTag($tagstring, $blogid);
}

$CACHE->updateArticleCache();

Field::updateField($blogid, $field_keys, $field_values);

doAction('save_log', $blogid, $pubPost, $logData);

// 异步保存
if ($action === 'autosave') {
    exit('autosave_gid:' . $blogid . '_');
}

// 保存草稿
if ($ishide === 'y') {
    emDirect("./article.php?draft=1&active_savedraft=1");
}

// 文章（草稿）公开发布
if ($pubPost) {
    if (!User::haveEditPermission()) {
        notice::sendNewPostMail($title, $blogid);
    }
    emDirect("./article.php?active_post=1");
}

// 编辑文章（保存并返回）
$page = $Log_Model->getPageOffset($postDate);
emDirect("./article.php?active_savelog=1&page=" . $page);
