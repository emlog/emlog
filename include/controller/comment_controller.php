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
        $Comment_Model->setCommentCookie($name, $mail, $url);
        $err = '';
        if ($Comment_Model->isLogCanComment($blogId) === false) {
            $err = '该文章未开启评论';
        } elseif ($Comment_Model->isCommentExist($blogId, $name, $content) === true) {
            $err = '已存在相同内容评论';
        } elseif (User::isVistor() && $Comment_Model->isCommentTooFast() === true) {
            $err = '评论发布太频繁了，休息下吧';
        } elseif (empty($name)) {
            $err = '请填写姓名';
        } elseif (strlen($name) > 20) {
            $err = '姓名不符合规范';
        } elseif ($mail !== '' && !checkMail($mail)) {
            $err = '邮件地址不符合规范';
        } elseif (!empty($url) && preg_match("/^(http|https)\:\/\/[^<>'\"]*$/", $url) == false) {
            $err = '主页地址不符合规范';
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
        notice::sendNewCommentMail($content, $blogId);

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
