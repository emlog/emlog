<?php
/**
 * article save and update
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Log_Model = new Log_Model();
$Tag_Model = new Tag_Model();

$title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
$postDate = isset($_POST['postdate']) ? trim($_POST['postdate']) : '';
$date = isset($_POST['date']) ? addslashes($_POST['date']) : '';//Article time before modification
$sort = isset($_POST['sort']) ? (int)$_POST['sort'] : -1;
$tagstring = isset($_POST['tag']) ? addslashes(trim($_POST['tag'])) : '';
$content = isset($_POST['logcontent']) ? addslashes(trim($_POST['logcontent'])) : '';
$excerpt = isset($_POST['logexcerpt']) ? addslashes(trim($_POST['logexcerpt'])) : '';
$author = isset($_POST['author']) && ROLE == ROLE_ADMIN ? (int)trim($_POST['author']) : UID;
$blogid = isset($_POST['as_logid']) ? (int)trim($_POST['as_logid']) : -1;//If it is automatically saved as a draft, there is a blog id number
$alias = isset($_POST['alias']) ? addslashes(trim($_POST['alias'])) : '';
$top = isset($_POST['top']) ? addslashes(trim($_POST['top'])) : 'n';
$sortop = isset($_POST['sortop']) ? addslashes(trim($_POST['sortop'])) : 'n';
$allow_remark = isset($_POST['allow_remark']) ? addslashes(trim($_POST['allow_remark'])) : 'n';
$ishide = isset($_POST['ishide']) && !empty($_POST['ishide']) && !isset($_POST['pubdf']) ? addslashes($_POST['ishide']) : 'n';
$password = isset($_POST['password']) ? addslashes(trim($_POST['password'])) : '';
$cover = isset($_POST['cover']) ? addslashes(trim($_POST['cover'])) : '';

$postTime = strtotime($postDate);

LoginAuth::checkToken();

//check alias
if (!empty($alias)) {
	$logalias_cache = $CACHE->readCache('logalias');
	$alias = $Log_Model->checkAlias($alias, $logalias_cache, $blogid);
}

$logData = array(
	'title'        => $title,
	'alias'        => $alias,
	'content'      => $content,
	'excerpt'      => $excerpt,
	'cover'        => $cover,
	'author'       => $author,
	'sortid'       => $sort,
	'date'         => $postTime,
	'top '         => $top,
	'sortop '      => $sortop,
	'allow_remark' => $allow_remark,
	'hide'         => $ishide,
	'checked'      => $user_cache[UID]['ischeck'] == 'y' ? 'n' : 'y',
	'password'     => $password
);

if ($blogid > 0) {//After the draft is automatically saved, the addition becomes the update
	$Log_Model->updateLog($logData, $blogid);
	$Tag_Model->updateTag($tagstring, $blogid);
	$dftnum = '';
} else {
	if (!$blogid = $Log_Model->isRepeatPost($title, $postTime)) {
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
/*vot*/			emDirect("./article.php?active_post=1");//The article was published successfully
		} else {
/*vot*/			emDirect("./article.php?active_savelog=1");//The article was saved successfully
		}
		break;
}
