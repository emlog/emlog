<?php

/**
 * Service: Util
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Util
{

    static function getAvatar($uid, $mail = '')
    {
        $avatar = '';
        if ($uid) {
            $userModel = new User_Model();
            $user = $userModel->getOneUser($uid);
            $avatar = $user['photo'];
        } elseif ($mail) {
            $avatar = getGravatar($mail);
        }
        return $avatar ?: BLOG_URL . "admin/views/images/avatar.svg";
    }

    /**
     * 是否首页
     */
    static function ishome()
    {
        if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL) {
            return true;
        } else {
            return FALSE;
        }
    }
}
