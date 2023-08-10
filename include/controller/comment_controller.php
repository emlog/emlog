<?php
/**
 * comment controller
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Comment_Controller {
    function addComment($params) {
        $name = Input::postStrVar('comname');
        $content = Input::postStrVar('comment');
        $mail = Input::postStrVar('commail');
        $url = Input::postStrVar('comurl');
        $imgcode = strtoupper(Input::postStrVar('imgcode'));
        $blogId = Input::postIntVar('gid', -1);
        $pid = Input::postIntVar('pid');
        $resp = Input::postStrVar('resp'); // eg: json (only support json now)
        $uid = 0;

        if (ISLOGIN === true) {
            $User_Model = new User_Model();
            $user_info = $User_Model->getOneUser(UID);
            $name = addslashes($user_info['name_orig']);
            $mail = addslashes($user_info['email']);
            $url = addslashes(BLOG_URL);
            $uid = UID;
        }

        if ($url && strncasecmp($url, 'http', 4)) {
            $url = 'https://' . $url;
        }

        doAction('comment_post');

        $Comment_Model = new Comment_Model();
        $Log_Model = new Log_Model();

        $log = $Log_Model->getDetail($blogId);
        $Comment_Model->setCommentCookie($name, $mail, $url);
        $err = '';

        if (!ISLOGIN && Option::get('login_comment') === 'y') {
            $err = '请先完成登录，再发布评论';
        } elseif ($blogId <= 0 || empty($log)) {
            $err = '文章不存在';
        } elseif (Option::get('iscomment') == 'n' || $log['allow_remark'] == 'n') {
            $err = '该文章未开启评论';
        } elseif (User::isVistor() && $Comment_Model->isCommentTooFast() === true) {
            $err = '评论发布太频繁';
        } elseif (empty($name)) {
            $err = '请填写昵称';
        } elseif (strlen($name) > 100) {
            $err = '昵称太长了';
        } elseif ($mail !== '' && !checkMail($mail)) {
            $err = '不是有效的邮箱';
        } elseif (empty($content)) {
            $err = '请填写评论内容';
        } elseif (strlen($content) > 60000) {
            $err = '内容内容太长了';
        } elseif (User::isVistor() && Option::get('comment_needchinese') == 'y' && !preg_match('/[\x{4e00}-\x{9fa5}]/iu', $content)) {
            $err = '评论内容需包含中文';
        } elseif (ISLOGIN === false && Option::get('comment_code') == 'y' && session_start() && (empty($imgcode) || $imgcode !== $_SESSION['code'])) {
            $err = '验证码错误';
        }

        if ($err) {
            $resp === 'json' ? Output::error($err) : emMsg($err);
        }
        $r = $Comment_Model->addComment($uid, $name, $content, $mail, $url, $blogId, $pid);
        $cid = isset($r['cid']) ? $r['cid'] : 0;
        $hide = isset($r['hide']) ? $r['hide'] : '';

        $_SESSION['code'] = null;
        notice::sendNewCommentMail($content, $blogId, $pid);

        if ($hide === 'y') {
            $msg = '评论成功，请等待管理员审核';
            $resp === 'json' ? Output::ok($msg) : emMsg($msg);
        }
        if ($resp === 'json') {
            Output::ok(['cid' => $cid]);
        } else {
            emDirect(Url::log($blogId) . '#' . $cid);
        }
    }
}
