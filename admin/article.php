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
$Media_Model = new Media_Model();
$MediaSort_Model = new MediaSort_Model();
$Template_Model = new Template_Model();

if (empty($action)) {
    $draft = Input::getIntVar('draft');
    $tagId = Input::getIntVar('tagid');
    $sid = Input::getIntVar('sid');
    $uid = Input::getIntVar('uid');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $checked = Input::getStrVar('checked');
    $order = Input::getStrVar('order');
    $perpage_num = Input::getStrVar('perpage_num');

    $condition = '';
    if ($tagId) {
        $blogIdStr = $Tag_Model->getTagById($tagId) ?: 0;
        $condition = "and gid IN ($blogIdStr)";
    } elseif ($sid) {
        $condition = "and sortid=$sid";
    } elseif ($uid) {
        $condition = "and author=$uid";
    } elseif ($checked) {
        $condition = "and checked='$checked'";
    } elseif ($keyword) {
        $condition = "and title like '%$keyword%'";
    }

    if ($perpage_num > 0) {
        $perPage = $perpage_num;
        Option::updateOption('admin_article_perpage_num', $perpage_num);
        $CACHE->updateCache('options');
    } else {
        $admin_article_perpage_num = Option::get('admin_article_perpage_num');
        $perPage = $admin_article_perpage_num ? $admin_article_perpage_num : 20;
    }

    $orderBy = ' ORDER BY ';
    switch ($order) {
        case 'view':
            $orderBy .= 'views DESC';
            break;
        case 'comm':
            $orderBy .= 'comnum DESC';
            break;
        case 'top':
            $orderBy .= 'top DESC, sortop DESC';
            break;
        default:
            $orderBy .= 'date DESC';
            break;
    }

    $hide_state = $draft ? 'y' : 'n';
    if ($draft) {
        $hide_stae = 'y';
        $sorturl = '&draft=1';
    } else {
        $hide_stae = 'n';
        $sorturl = '';
    }

    $logNum = $Log_Model->getLogNum($hide_state, $condition, 'blog', 1);
    $logs = $Log_Model->getLogsForAdmin($condition . $orderBy, $hide_state, $page, 'blog', $perPage);
    $sorts = $CACHE->readCache('sort');
    $tags = $Tag_Model->getTags();

    $subPage = '';
    foreach ($_GET as $key => $val) {
        $subPage .= $key != 'page' ? "&$key=$val" : '';
    }
    $pageurl = pagination($logNum, $perPage, $page, "article.php?{$subPage}&page=");

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once View::getAdmView('article');
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

if ($action == 'del') {
    $draft = Input::getIntVar('draft');
    $gid = Input::getIntVar('gid');
    $isRm = Input::getIntVar('rm'); // 是否彻底删除

    LoginAuth::checkToken();

    $redirectUrl = './article.php';
    if ($draft || $isRm) {
        $Log_Model->deleteLog($gid);
        doAction('del_log', $gid);
        if ($draft) {
            $redirectUrl .= '?draft=1';
        }
    } else {
        $Log_Model->hideSwitch($gid, 'y');
        $redirectUrl .= "?active_hide=1";
    }
    $CACHE->updateCache();
    emDirect($redirectUrl);
}

if ($action == 'tag') {
    $gid = Input::postIntVar('gid');
    $tagsStr = strip_tags(Input::postStrVar('tag'));

    if (!User::haveEditPermission()) {
        emMsg('权限不足！', './');
    }

    $Tag_Model->updateTag($tagsStr, $gid);
    emDirect("./article.php");
}

if ($action === 'pub') {
    $gid = Input::getIntVar('gid');

    $Log_Model->hideSwitch($gid, 'n');
    if (User::haveEditPermission()) {
        $Log_Model->checkSwitch($gid, 'y');
    }

    $CACHE->updateCache();
    emDirect("./article.php?draft=1&active_post=1&draft=1");
}

if ($action == 'operate_log') {
    $operate = Input::requestStrVar('operate');
    $draft = Input::postIntVar('draft');
    $logs = Input::postIntArray('blog');
    $sort = Input::postIntVar('sort');
    $author = Input::postIntVar('author');
    $gid = Input::requestNumVar('gid');

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
            emDirect("./article.php?draft=$draft");
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
            if ($logs) {
                foreach ($logs as $id) {
                    $Log_Model->checkSwitch($id, 'y');
                }
            } else {
                $Log_Model->checkSwitch($gid, 'y');
            }
            $CACHE->updateCache();
            emDirect("./article.php?active_ck=1&draft=$draft");
            break;
        case 'uncheck':
            if (!User::haveEditPermission()) {
                emMsg('权限不足！', './');
            }
            if ($logs) {
                $feedback = '';
                foreach ($logs as $id) {
                    $Log_Model->unCheck($id, $feedback);
                }
            } else {
                $gid = Input::postIntVar('gid');
                $feedback = Input::postStrVar('feedback');
                $Log_Model->unCheck($gid, $feedback);
            }
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
        'template' => '',
    ];

    extract($blogData);

    $isdraft = false;
    $containerTitle = User::haveEditPermission() ? '写文章' : '发布' . Option::get('posts_name');
    $orig_date = '';
    $sorts = $CACHE->readCache('sort');
    $tagStr = '';
    $tags = $Tag_Model->getTags();
    $is_top = '';
    $is_sortop = '';
    $is_allow_remark = 'checked="checked"';
    $postDate = date('Y-m-d H:i:s');
    $mediaSorts = $MediaSort_Model->getSorts();
    $customTemplates = $Template_Model->getCustomTemplates('log');
    $fields = [];

    if (!Register::isRegLocal() && $sta_cache['lognum'] > 50) {
        emDirect("auth.php?error_article=1");
    }

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once(View::getAdmView('article_write'));
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

if ($action === 'edit') {
    $logid = Input::getIntVar('gid');

    $Log_Model->checkEditable($logid);
    $blogData = $Log_Model->getOneLogForAdmin($logid);
    extract($blogData);

    $isdraft = $hide == 'y' ? true : false;
    $postsName = User::isAdmin() ? '文章' : Option::get('posts_name');
    $containerTitle = $isdraft ? '编辑草稿' : '编辑' . $postsName;
    $postDate = date('Y-m-d H:i:s', $date);
    $sorts = $CACHE->readCache('sort');

    //tag
    $tags = [];
    foreach ($Tag_Model->getTag($logid) as $val) {
        $tags[] = $val['tagname'];
    }
    $tagStr = implode(',', $tags);
    //old tag
    $tags = $Tag_Model->getTags();

    $mediaSorts = $MediaSort_Model->getSorts();

    // fields
    $fields = Field::getFields($logid);

    $customTemplates = $Template_Model->getCustomTemplates('log');

    $is_top = $top == 'y' ? 'checked="checked"' : '';
    $is_sortop = $sortop == 'y' ? 'checked="checked"' : '';
    $is_allow_remark = $allow_remark == 'y' ? 'checked="checked"' : '';

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once(View::getAdmView('article_write'));
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

if ($action == 'upload_cover') {
    $ret = uploadCropImg();
    $Media_Model->addMedia($ret['file_info']);
    Output::ok($ret['file_info']['file_path']);
}
