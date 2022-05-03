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

$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
$postDate = isset($_POST['postdate']) ? strtotime(trim($_POST['postdate'])) : '';
$sort = isset($_POST['sort']) ? (int)$_POST['sort'] : -1;
$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
$content = isset($_POST['logcontent']) ? addslashes(trim($_POST['logcontent'])) : '';
$excerpt = isset($_POST['logexcerpt']) ? addslashes(trim($_POST['logexcerpt'])) : '';
$author = isset($_POST['author']) && User::isAdmin() ? (int)trim($_POST['author']) : UID;
$blogid = isset($_POST['as_logid']) ? (int)trim($_POST['as_logid']) : -1;//如被自动保存为草稿则有blog id号
$alias = isset($_POST['alias']) ? addslashes(trim($_POST['alias'])) : '';
$allow_remark = isset($_POST['allow_remark']) ? addslashes(trim($_POST['allow_remark'])) : 'n'; //允许评论
$ishide = isset($_POST['ishide']) && !empty($_POST['ishide']) && !isset($_POST['pubdf']) ? addslashes($_POST['ishide']) : 'n';
$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
$cover = isset($_POST['cover']) ? addslashes(trim($_POST['cover'])) : '';

LoginAuth::checkToken();

//check alias
if (!empty($alias)) {
	$logalias_cache = $CACHE->readCache('logalias');
	$alias = $Log_Model->checkAlias($alias, $logalias_cache, $blogid);
}

//管理员发文不审核,注册用户受开关控制
$checked = Option::get('ischkarticle') == 'y' && !User::isAdmin() ? 'n' : 'y';

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
	'password'     => $password
];

if ($blogid > 0) {//自动保存草稿后,添加变为更新
	$Log_Model->updateLog($logData, $blogid);
	$Tag_Model->updateTag($tagstring, $blogid);
	$dftnum = '';
} else {
	if (!$blogid = $Log_Model->isRepeatPost($title, $postDate)) {
		$blogid = $Log_Model->addlog($logData);
		$Tag_Model->addTag($tagstring, $blogid);
	}
	$dftnum = $Log_Model->getLogNum('y', '', 'blog', 1);
}

$CACHE->updateCache();

doAction('save_log', $blogid);

switch ($action) {
	case 'autosave':
		echo "autosave_gid:{$blogid}_df:{$dftnum}_";
		break;
	case 'add':
	case 'edit':
		$tbmsg = '';
		if ($ishide == 'y') {
			emDirect("./article.php?pid=draft&active_savedraft=1");
		}
		if ($action == 'add' || isset($_POST['pubdf'])) {
			emDirect("./article.php?active_post=1");//文章发布成功
		} else {
			emDirect("./article.php?active_savelog=1");//文章保存成功
		}
		break;
}
