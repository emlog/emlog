<?php

/**
 * Service: Article
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Article
{
    /**
     *  Check if the user has exceeded the daily posting limit
     *
     * @return void
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
}
