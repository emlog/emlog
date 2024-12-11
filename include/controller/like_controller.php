<?php

/**
 * like controller
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Like_Controller
{
    function index($params)
    {
        $action = Input::getStrVar('action');

        if ($action == 'addlike') {
            $this->addLike();
        } elseif ($action == 'unlike') {
            $this->unLike();
        }
    }

    function addLike()
    {
        $name = Input::postStrVar('name');
        $avatar = Input::postStrVar('avatar');
        $blogId = Input::postIntVar('gid', -1);
        $ua = getUA();
        $ip = getIp();
        $uid = 0;

        if (ISLOGIN === true) {
            $User_Model = new User_Model();
            $user_info = $User_Model->getOneUser(UID);
            $name = addslashes($user_info['name_orig']);
            $uid = UID;
        }

        doAction('like_post');

        $Like_Model = new Like_Model();
        $Log_Model = new Log_Model();

        $log = $Log_Model->getDetail($blogId);
        $err = '';

        if ($blogId <= 0 || empty($log)) {
            $err = '文章不存在';
        } elseif ($Like_Model->isLiked($blogId, $uid, $ip) === true) {
            $err = '已经赞过了';
        } elseif (!User::haveEditPermission() && $Like_Model->isTooFast() === true) {
            $err = '操作太频繁';
        } elseif (strlen($name) > 100) {
            $err = '昵称太长了';
        } elseif (empty($ip) || empty($ua) || preg_match('/bot|crawler|spider|robot|crawling/i', $ua)) {
            $err = '非正常请求';
        }

        if ($err) {
            Output::error($err);
        }
        $r = $Like_Model->addLike($uid, $name, $avatar, $blogId, $ip, $ua);
        $id = isset($r['id']) ? $r['id'] : 0;

        Output::ok(['id' => $id]);
    }

    function unLike()
    {
        $uid = 0;

        if (ISLOGIN === true) {
            $User_Model = new User_Model();
            $user_info = $User_Model->getOneUser(UID);
            $uid = UID;
        }

        $blogId = Input::postIntVar('gid');
        $Like_Model = new Like_Model();
        $r = $Like_Model->unLike($uid, $blogId);

        if ($r === false) {
            Output::error('取消失败');
        }

        Output::ok();
    }
}
