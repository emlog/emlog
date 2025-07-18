<?php

/**
 * Service: Sort
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Sort
{
    static function formatSortTitle($title, $sortName)
    {
        $site_title = Option::get('site_title');
        $blogname = Option::get('blogname');

        if (empty($site_title)) {
            $site_title = $blogname;
        }

        return strtr($title, [
            '{{site_title}}' => $site_title,
            '{{site_name}}'  => $blogname,
            '{{sort_name}}'  => $sortName
        ]);
    }

    /**
     * 获取分类列表
     * @param bool $filterForUser 是否为注册用户过滤（过滤掉不允许投稿的分类）
     * @return array 分类数组
     */
    static function getSorts($filterForUser = false)
    {
        $Sort_Model = new Sort_Model();
        $sorts = $Sort_Model->getSorts();

        // 如果需要为注册用户过滤，且当前用户不是管理员
        if ($filterForUser && !User::haveEditPermission()) {
            $filteredSorts = [];
            foreach ($sorts as $sid => $sort) {
                if (isset($sort['allow_user_post']) && $sort['allow_user_post'] === 'y') {
                    $filteredSorts[$sid] = $sort;
                }
            }
            return $filteredSorts;
        }

        return $sorts;
    }

    /**
     * 获取允许注册用户投稿的分类列表
     * @return array 分类数组
     */
    static function getUserPostableSorts()
    {
        return self::getSorts(true);
    }
}
