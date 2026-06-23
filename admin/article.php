<?php

/**
 * The article management
 *
 * @package EMLOG
 * 
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
    $perpage_num = Input::getIntVar('perpage_num');

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
        case 'like':
            $orderBy .= 'like_count DESC';
            break;
        case 'dislike':
            $orderBy .= 'dislike_count DESC';
            break;
        case 'collect':
            $orderBy .= 'collect_count DESC';
            break;
        case 'top':
            $orderBy .= 'top DESC, sortop DESC, date DESC';
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
    $sorts = Sort::getUserPostableSorts();
    $tags = $Tag_Model->getTags();

    $subPage = '';
    foreach ($_GET as $key => $val) {
        $subPage .= $key != 'page' ? '&' . urlencode($key) . '=' . urlencode($val) : '';
    }
    $pageurl = pagination($logNum, $perPage, $page, "article.php?{$subPage}&page=");

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once View::getAdmView('article');
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

/**
 * 处理作者实时搜索的 AJAX 请求
 * 
 * 根据输入的关键字进行模糊匹配查询（支持用户ID、用户名或昵称），返回匹配的用户列表，用于文章更改作者时的下拉选择
 * 
 * @return void
 */
if ($action == 'search_author') {
    if (!User::haveEditPermission()) {
        header('Content-Type: application/json');
        echo json_encode(['code' => 403, 'msg' => 'Permission denied']);
        exit;
    }
    
    $term = trim(Input::getStrVar('term'));
    $termLower = strtolower($term);
    
    $db = Database::getInstance();
    $res = $db->query("SELECT uid, nickname, username FROM " . DB_PREFIX . "user ORDER BY uid DESC");
    $matchedUsers = [];
    
    while ($row = $db->fetch_array($res)) {
        $uid = (int)$row['uid'];
        $nickname = $row['nickname'] ?: $row['username'];
        $username = $row['username'];
        
        $isMatch = false;
        if (empty($termLower)) {
            $isMatch = true;
        } else {
            if (is_numeric($termLower) && $uid === (int)$termLower) {
                $isMatch = true;
            } else {
                $nicknameLower = strtolower($nickname);
                $usernameLower = strtolower($username);
                
                $initials = '';
                $len = mb_strlen($nickname, 'UTF-8');
                for ($i = 0; $i < $len; $i++) {
                    $char = mb_substr($nickname, $i, 1, 'UTF-8');
                    $charGbk = iconv('UTF-8', 'GBK//IGNORE', $char);
                    if (!empty($charGbk)) {
                        $firstByte = ord($charGbk[0]);
                        if ($firstByte >= 176 && $firstByte <= 247) {
                            $num = $firstByte * 256 + ord($charGbk[1]) - 65536;
                            if ($num >= -20319 && $num <= -20284) $initials .= 'a';
                            elseif ($num >= -20283 && $num <= -19776) $initials .= 'b';
                            elseif ($num >= -19775 && $num <= -19219) $initials .= 'c';
                            elseif ($num >= -19218 && $num <= -18711) $initials .= 'd';
                            elseif ($num >= -18710 && $num <= -18527) $initials .= 'e';
                            elseif ($num >= -18526 && $num <= -18240) $initials .= 'f';
                            elseif ($num >= -18239 && $num <= -17923) $initials .= 'g';
                            elseif ($num >= -17922 && $num <= -17418) $initials .= 'h';
                            elseif ($num >= -17417 && $num <= -16475) $initials .= 'j';
                            elseif ($num >= -16474 && $num <= -16213) $initials .= 'k';
                            elseif ($num >= -16212 && $num <= -15641) $initials .= 'l';
                            elseif ($num >= -15640 && $num <= -15166) $initials .= 'm';
                            elseif ($num >= -15165 && $num <= -14923) $initials .= 'n';
                            elseif ($num >= -14922 && $num <= -14915) $initials .= 'o';
                            elseif ($num >= -14914 && $num <= -14631) $initials .= 'p';
                            elseif ($num >= -14630 && $num <= -14150) $initials .= 'q';
                            elseif ($num >= -14149 && $num <= -14091) $initials .= 'r';
                            elseif ($num >= -14090 && $num <= -13319) $initials .= 's';
                            elseif ($num >= -13318 && $num <= -12839) $initials .= 't';
                            elseif ($num >= -12838 && $num <= -12557) $initials .= 'w';
                            elseif ($num >= -12556 && $num <= -11848) $initials .= 'x';
                            elseif ($num >= -11847 && $num <= -11056) $initials .= 'y';
                            elseif ($num >= -11055 && $num <= -10247) $initials .= 'z';
                        } else {
                            $c = $charGbk[0];
                            if (preg_match('/^[a-zA-Z0-9]$/', $c)) {
                                $initials .= strtolower($c);
                            }
                        }
                    }
                }
                
                if (stripos($nicknameLower, $termLower) !== false || 
                    stripos($usernameLower, $termLower) !== false || 
                    stripos($initials, $termLower) !== false) {
                    $isMatch = true;
                }
            }
        }
        
        if ($isMatch) {
            $matchedUsers[] = [
                'uid' => $uid,
                'nickname' => htmlspecialchars($nickname),
                'username' => htmlspecialchars($username),
            ];
            if (count($matchedUsers) >= 20) {
                break;
            }
        }
    }
    
    header('Content-Type: application/json');
    echo json_encode(['code' => 200, 'data' => $matchedUsers]);
    exit;
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
        FlashMsg::addFlashMessage('article_flash_messages', 'active_hide');
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
    FlashMsg::redirectWithFlash('./article.php', array('draft' => 1), 'article_flash_messages', 'active_post');
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
        FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'error_b');
    }
    if (empty($logs) && empty($gid)) {
        FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'error_a');
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
            FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'active_up');
            break;
        case 'sortop':
            foreach ($logs as $val) {
                $Log_Model->updateLog(array('sortop' => 'y'), $val);
            }
            FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'active_up');
            break;
        case 'notop':
            foreach ($logs as $val) {
                $Log_Model->updateLog(array('top' => 'n', 'sortop' => 'n'), $val);
            }
            FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'active_down');
            break;
        case 'hide':
            foreach ($logs as $val) {
                $Log_Model->hideSwitch($val, 'y');
            }
            $CACHE->updateCache();
            FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'active_hide');
            break;
        case 'pub':
            foreach ($logs as $val) {
                $Log_Model->hideSwitch($val, 'n');
                if (User::haveEditPermission()) {
                    $Log_Model->checkSwitch($val, 'y');
                }
            }
            $CACHE->updateCache();
            FlashMsg::redirectWithFlash('./article.php', array('draft' => 1), 'article_flash_messages', 'active_post');
            break;
        case 'move':
            foreach ($logs as $val) {
                $Log_Model->checkEditable($val);
                $Log_Model->updateLog(array('sortid' => $sort), $val);
            }
            $CACHE->updateCache(array('sort', 'logsort'));
            FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'active_move');
            break;
        case 'change_author':
            if (!User::haveEditPermission()) {
                emMsg('权限不足！', './');
            }
            foreach ($logs as $val) {
                $Log_Model->updateLog(array('author' => $author), $val);
            }
            $CACHE->updateCache('sta');
            FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'active_change_author');
            break;
        case 'check':
            if (!User::haveEditPermission()) {
                emMsg('权限不足！', './');
            }
            if ($logs) {
                foreach ($logs as $id) {
                    $Log_Model->checkSwitch($id, 'y');
                    doAction('approved_log', $id);
                }
            } else {
                $Log_Model->checkSwitch($gid, 'y');
                doAction('approved_log', $gid);
            }
            $CACHE->updateCache();
            FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'active_ck');
            break;
        case 'uncheck':
            if (!User::haveEditPermission()) {
                emMsg('权限不足！', './');
            }
            if ($logs) {
                $feedback = '';
                foreach ($logs as $id) {
                    $Log_Model->unCheck($id, $feedback);
                    doAction('rejected_log', $id, '');
                }
            } else {
                $gid = Input::postIntVar('gid');
                $feedback = Input::postStrVar('feedback');
                $Log_Model->unCheck($gid, $feedback);
                doAction('rejected_log', $gid, $feedback);
            }
            $CACHE->updateCache();
            FlashMsg::redirectWithFlash('./article.php', array('draft' => $draft), 'article_flash_messages', 'active_unck');
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
    $containerTitle = User::haveEditPermission() ? _lang('write_article') : _lang('publish') . Option::get('posts_name');
    $orig_date = '';
    $sorts = Sort::getUserPostableSorts();

    $tagStr = '';
    $tags = $Tag_Model->getTags();
    $is_top = '';
    $is_sortop = '';
    $is_allow_remark = 'checked="checked"';
    $postDate = date('Y-m-d H:i:s');
    $customTemplates = $Template_Model->getCustomTemplates('log');
    $customFields = $Template_Model->getCustomFields();
    $fields = [];

    if (!Register::isRegLocal() && $sta_cache['lognum'] > 50) {
        FlashMsg::redirectAdmin('auth', 'error_article');
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
    $sorts = Sort::getUserPostableSorts();

    //tag
    $tags = [];
    foreach ($Tag_Model->getTag($logid) as $val) {
        $tags[] = $val['tagname'];
    }
    $tagStr = implode(',', $tags);
    //old tag
    $tags = $Tag_Model->getTags();

    // fields
    $fields = Field::getFields($logid);

    $customTemplates = $Template_Model->getCustomTemplates('log');
    $customFields = $Template_Model->getCustomFields();

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
