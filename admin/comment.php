<?php

/**
 * comments
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Comment_Model = new Comment_Model();

if (!$action) {
    $blogId = Input::getIntVar('gid');
    $uid = Input::getIntVar('uid');
    $hide = Input::getStrVar('hide');
    $page = Input::getIntVar('page', 1);
    $perpage_num = Input::getStrVar('perpage_num');

    $addUrl_0 = $uid ? "uid=$uid&" : '';
    $addUrl_1 = $blogId ? "gid=$blogId&" : '';
    $addUrl_2 = $hide ? "hide=$hide&" : '';
    $addUrl = $addUrl_0 . $addUrl_1 . $addUrl_2;

    if ($perpage_num > 0) {
        $perPage = $perpage_num;
        Option::updateOption('admin_comment_perpage_num', $perpage_num);
        $CACHE->updateCache('options');
    } else {
        $admin_comment_perpage_num = Option::get('admin_comment_perpage_num');
        $perPage = $admin_comment_perpage_num ? $admin_comment_perpage_num : 20;
    }

    $comment = $Comment_Model->getCommentsForAdmin($blogId, $uid, $hide, $page, $perPage);
    $cmnum = $Comment_Model->getCommentNum($blogId, $uid, $hide);
    $hideCommNum = $Comment_Model->getCommentNum($blogId, $uid, 'y');
    $pageurl = pagination($cmnum, $perPage, $page, "comment.php?{$addUrl}page=");

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once(View::getAdmView('comment'));
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

if ($action === 'del') {
    $id = Input::getIntVar('id');

    LoginAuth::checkToken();

    $Comment_Model->delComment($id);
    $CACHE->updateCache(array('sta', 'comment'));
    emDirect("./comment.php");
}

if ($action === 'delbyip') {
    LoginAuth::checkToken();
    if (!User::haveEditPermission()) {
        emMsg('权限不足！', './');
    }
    $ip = Input::getStrVar('ip');
    $Comment_Model->delCommentByIp($ip);
    $CACHE->updateCache(array('sta', 'comment'));
    emDirect("./comment.php");
}

if ($action === 'pub') {
    LoginAuth::checkToken();
    if (!User::haveEditPermission()) {
        emMsg('权限不足！', './');
    }

    $id = Input::getIntVar('id');

    $Comment_Model->showComment($id);
    $CACHE->updateCache(array('sta', 'comment'));
    emDirect("./comment.php?active_show=1");
}

if ($action === 'batch_operation') {
    $operate = Input::postStrVar('operate');
    $comments = isset($_POST['com']) ? array_map('intval', $_POST['com']) : [];

    if (empty($comments)) {
        emDirect("./comment.php?error_a=1");
    }

    switch ($operate) {
        case 'del':
            $Comment_Model->batchComment('delcom', $comments);
            $CACHE->updateCache(array('sta', 'comment'));
            emDirect("./comment.php");
            break;
        case 'hide':
            $Comment_Model->batchComment('hidecom', $comments);
            $CACHE->updateCache(array('sta', 'comment'));
            emDirect("./comment.php?active_hide=1");
            break;
        case 'pub':
            $Comment_Model->batchComment('showcom', $comments);
            $CACHE->updateCache(array('sta', 'comment'));
            emDirect("./comment.php?active_show=1");
            break;
        case 'top':
            $Comment_Model->batchComment('top', $comments);
            emDirect("./comment.php?active_top=1");
            break;
        case 'untop':
            $Comment_Model->batchComment('untop', $comments);
            emDirect("./comment.php?active_untop=1");
            break;
        default:
            emDirect("./comment.php?error_b=1");
    }
}

if ($action === 'doreply') {
    $reply = Input::postStrVar('reply');
    $commentId = Input::postIntVar('cid');
    $hide = Input::postStrVar('hide', 'n');

    if (empty($reply)) {
        emDirect("./comment.php?error_c=1");
    }

    //回复一条待审核的评论，视为要将其公开（包括回复内容）
    if ($hide == 'y') {
        $Comment_Model->showComment($commentId);
        $hide = 'n';
    }

    $comment = $Comment_Model->getOneComment($commentId);
    $blogId = isset($comment['gid']) ? (int)$comment['gid'] : null;
    $content = '@' . addslashes($comment['poster']) . '：' . $reply;

    $Comment_Model->replyComment($blogId, $commentId, $content, $hide);
    notice::sendNewCommentMail($reply, $blogId, $commentId);

    $CACHE->updateCache('comment');
    $CACHE->updateCache('sta');
    doAction('comment_reply', $commentId, $reply);
    emDirect("./comment.php?active_rep=1");
}
