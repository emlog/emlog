<?php

/**
 * Service: Article
 *
 * @package EMLOG
 * 
 */

class Article
{
    /**
     * 检查用户是否超过发文限制
     *
     * @return bool 如果超过发文限制返回true，否则返回false
     */
    public static function hasReachedDailyPostLimit()
    {
        $Log_Model = new Log_Model();
        if (!User::isWriter()) {
            return false;
        }

        $count = $Log_Model->getPostCountByUid(UID, time() - 3600 * 24);
        $post_per_day = Option::get('posts_per_day');
        if ($count >= $post_per_day) {
            return true;
        }
        return false;
    }

    /**
     * 检查是否禁止用户发文
     *
     * @return bool 如果禁止发文返回true，否则返回false
     */
    public static function hasForbidPost()
    {
        $post_per_day = Option::get('posts_per_day');
        if (0 === (int)$post_per_day) {
            return true;
        }
        return false;
    }
}
