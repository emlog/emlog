<?php

/**
 * Service: Sort
 *
 * @package EMLOG
 * 
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
        if (User::haveEditPermission()) {
            return $Sort_Model->getSorts();
        }
        return $Sort_Model->getSorts(true);
    }

    /**
     * 当为父分类且存在子分类时，返回包含父分类及其子分类的ID数组
     *
     * @param array $sortCache 分类缓存数组
     * @param int $sortId 分类ID
     * @return array 分类ID数组，例如：[1,2,3] 或 [1]
     */
    static function getFilterSegmentBySortId($sortCache, $sortId)
    {
        $sortId = (int)$sortId;
        if (empty($sortId) || !isset($sortCache[$sortId])) {
            return [];
        }

        $sort = $sortCache[$sortId];
        $pid = isset($sort['pid']) ? (int)$sort['pid'] : 0;
        $children = isset($sort['children']) ? $sort['children'] : [];

        if ($pid === 0 && !empty($children)) {
            return array_merge([$sortId], $children);
        }
        return [$sortId];
    }
}
