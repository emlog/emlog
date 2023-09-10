<?php
/**
 * The article management
 *
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
$Sort_Model = new Sort_Model();
$User_Model = new User_Model();

if (empty($action)) {
    $draft = isset($_GET['draft']) ? (int)$_GET['draft'] : 0;
    $tagId = isset($_GET['tagid']) ? (int)$_GET['tagid'] : '';
    $sid = isset($_GET['sid']) ? (int)$_GET['sid'] : '';
    $uid = isset($_GET['uid']) ? (int)$_GET['uid'] : '';
    $keyword = isset($_GET['keyword']) ? addslashes(trim($_GET['keyword'])) : '';
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $checked = isset($_GET['checked']) ? addslashes($_GET['checked']) : '';

    $sortView = (isset($_GET['sortView']) && $_GET['sortView'] == 'ASC') ? 'DESC' : 'ASC';
    $sortComm = (isset($_GET['sortComm']) && $_GET['sortComm'] == 'ASC') ? 'DESC' : 'ASC';
    $sortDate = (isset($_GET['sortDate']) && $_GET['sortDate'] == 'DESC') ? 'ASC' : 'DESC';

    $sqlSegment = '';
    if ($tagId) {
        $blogIdStr = $Tag_Model->getTagById($tagId) ?: 0;
        $sqlSegment = "and gid IN ($blogIdStr)";
    } elseif ($sid) {
        $sqlSegment = "and sortid=$sid";
    } elseif ($uid) {
        $sqlSegment = "and author=$uid";
    } elseif ($checked) {
        $sqlSegment = "and checked='$checked'";
    } elseif ($keyword) {
        $sqlSegment = "and title like '%$keyword%'";
    }
    $sqlSegment .= ' ORDER BY ';
    if (isset($_GET['sortView'])) {
        $sqlSegment .= "views $sortView";
    } elseif (isset($_GET['sortComm'])) {
        $sqlSegment .= "comnum $sortComm";
    } elseif (isset($_GET['sortDate'])) {
        $sqlSegment .= "date $sortDate";
    } else {
        $sqlSegment .= 'top DESC, sortop DESC, date DESC';
    }

    $hide_state = $draft ? 'y' : 'n';
    if ($draft) {
        $hide_stae = 'y';
        $sorturl = '&draft=1';
    } else {
        $hide_stae = 'n';
        $sorturl = '';
    }

    $logNum = $Log_Model->getLogNum($hide_state, $sqlSegment, 'blog', 1);
    $logs = $Log_Model->getLogsForAdmin($sqlSegment, $hide_state, $page);
    $sorts = $CACHE->readCache('sort');

    $subPage = '';
    foreach ($_GET as $key => $val) {
        $subPage .= $key != 'page' ? "&$key=$val" : '';
    }
    $pageurl = pagination($logNum, Option::get('admin_perpage_num'), $page, "article.php?{$subPage}&page=");

    include View::getAdmView(User::isAdmin() ? 'header' : 'header_user');
    require_once View::getAdmView('article');
    include View::getAdmView(User::isAdmin() ? 'footer' : 'footer_user');
    View::output();
}

if ($action == 'del') {
    $draft = isset($_GET['draft']) ? (int)$_GET['draft'] : 0;
    $gid = isset($_GET['gid']) ? (int)$_GET['gid'] : '';

    LoginAuth::checkToken();

    $Log_Model->deleteLog($gid);
    doAction('del_log', $gid);
    $CACHE->updateCache();
    emDirect("./article.php?&active_del=1&draft=$draft");
}

if ($action == 'operate_log') {
    $operate = isset($_REQUEST['operate']) ? $_REQUEST['operate'] : '';
    $draft = isset($_POST['draft']) ? (int)$_POST['draft'] : 0;
    $logs = isset($_POST['blog']) ? array_map('intval', $_POST['blog']) : array();
    $sort = isset($_POST['sort']) ? (int)$_POST['sort'] : '';
    $author = isset($_POST['author']) ? (int)$_POST['author'] : '';
    $gid = isset($_REQUEST['gid']) ? (int)$_REQUEST['gid'] : '';

    LoginAuth::checkToken();

    if (!$operate) {
        emDirect("./article.php?draft=$draft&error_b=1");
    }
    if (empty($logs) && empty($gid)) {
        emDirect("./article.php?draft=$draft&error_a=1");
    }

    switch ($operate) {
        case 'del':
            foreach ($logs as $val) {
                doAction('before_del_log', $val);
                $Log_Model->deleteLog($val);
                doAction('del_log', $val);
            }
            $CACHE->updateCache();
            emDirect("./article.php?draft=1&active_del=1&draft=$draft");
            break;
        case 'top':
            foreach ($logs as $val) {
                $Log_Model->updateLog(array('top' => 'y'), $val);
            }
            emDirect("./article.php?active_up=1&draft=$draft");
            break;
        case 'sortop':
            foreach ($logs as $val) {
                $Log_Model->updateLog(array('sortop' => 'y'), $val);
            }
            emDirect("./article.php?active_up=1&draft=$draft");
            break;
        case 'notop':
            foreach ($logs as $val) {
                $Log_Model->updateLog(array('top' => 'n', 'sortop' => 'n'), $val);
            }
            emDirect("./article.php?active_down=1&draft=$draft");
            break;
        case 'hide':
            foreach ($logs as $val) {
                $Log_Model->hideSwitch($val, 'y');
            }
            $CACHE->updateCache();
            emDirect("./article.php?active_hide=1&draft=$draft");
            break;
        case 'pub':
            foreach ($logs as $val) {
                $Log_Model->hideSwitch($val, 'n');
                if (User::haveEditPermission()) {
                    $Log_Model->checkSwitch($val, 'y');
                }
            }
            $CACHE->updateCache();
            emDirect("./article.php?draft=1&active_post=1&draft=$draft");
            break;
        case 'move':
            foreach ($logs as $val) {
                $Log_Model->checkEditable($val);
                $Log_Model->updateLog(array('sortid' => $sort), $val);
            }
            $CACHE->updateCache(array('sort', 'logsort'));
            emDirect("./article.php?active_move=1&draft=$draft");
            break;
        case 'change_author':
            if (!User::haveEditPermission()) {
                emMsg('权限不足！', './');
            }
            foreach ($logs as $val) {
                $Log_Model->updateLog(array('author' => $author), $val);
            }
            $CACHE->updateCache('sta');
            emDirect("./article.php?active_change_author=1&draft=$draft");
            break;
        case 'check':
            if (!User::haveEditPermission()) {
                emMsg('权限不足！', './');
            }
            $Log_Model->checkSwitch($gid, 'y');
            $CACHE->updateCache();
            emDirect("./article.php?active_ck=1&draft=$draft");
            break;
        case 'uncheck':
            if (!User::haveEditPermission()) {
                emMsg('权限不足！', './');
            }
            $gid = Input::postIntVar('gid');
            $feedback = Input::postStrVar('feedback');
            $Log_Model->unCheck($gid, $feedback);
            $CACHE->updateCache();
            emDirect("./article.php?active_unck=1&draft=$draft");
            break;
    }
}

if ($action === 'write') {
    $blogData = [
        'logid'    => -1,
        'title'    => '',
        'content'  => '',
        'excerpt'  => '',
        'alias'    => '',
        'sortid'   => -1,
        'type'     => 'blog',
        'password' => '',
        'hide'     => '',
        'author'   => UID,
        'cover'    => '',
        'link'     => '',
    ];

    extract($blogData);

    $isdraft = false;
    $containertitle = '写文章';
    $orig_date = '';
    $sorts = $CACHE->readCache('sort');
    $tagStr = '';
    $tags = $Tag_Model->getTags();
    $is_top = '';
    $is_sortop = '';
    $is_allow_remark = 'checked="checked"';
    $postDate = date('Y-m-d H:i');

    $MediaSort_Model = new MediaSort_Model();
    $mediaSorts = $MediaSort_Model->getSorts();

    if (!Register::isRegLocal() && $sta_cache['lognum'] > 50) {
        emDirect("auth.php?error_article=1");
    }

    include View::getAdmView(User::isAdmin() ? 'header' : 'header_user');
    require_once(View::getAdmView('article_write'));
    include View::getAdmView(User::isAdmin() ? 'footer' : 'footer_user');
    View::output();
}

if ($action === 'edit') {
    $logid = isset($_GET['gid']) ? (int)$_GET['gid'] : '';

    $Log_Model->checkEditable($logid);
    $blogData = $Log_Model->getOneLogForAdmin($logid);
    extract($blogData);

    $isdraft = $hide == 'y' ? true : false;
    $containerTitle = $isdraft ? '编辑草稿' : '编辑文章';
    $postDate = date('Y-m-d H:i', $date);
    $sorts = $CACHE->readCache('sort');

    //tag
    $tags = [];
    foreach ($Tag_Model->getTag($logid) as $val) {
        $tags[] = $val['tagname'];
    }
    $tagStr = implode(',', $tags);
    //old tag
    $tags = $Tag_Model->getTags();

    $MediaSort_Model = new MediaSort_Model();
    $mediaSorts = $MediaSort_Model->getSorts();

    $is_top = $top == 'y' ? 'checked="checked"' : '';
    $is_sortop = $sortop == 'y' ? 'checked="checked"' : '';
    $is_allow_remark = $allow_remark == 'y' ? 'checked="checked"' : '';

    include View::getAdmView('header');
    require_once View::getAdmView('article_write');
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'upload_cover') {
    $ret = uploadCropImg();
    Output::ok($ret['file_info']['file_path']);
}
