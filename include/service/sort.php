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
     * 获取允许注册用户投稿的分类列表
     * @return array 分类数组
     */
    static function getUserPostableSorts()
    {
        $Sort_Model = new Sort_Model();
        return $Sort_Model->getSorts(true);
    }
}
