<?php
/**
 * Service: Sort
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Sort {
    static function formatSortTitle($title, $sortName) {
        $site_title = Option::get('site_title');
        $blogname = Option::get('blogname');

        return strtr($title, [
            '{{site_title}}' => $site_title,
            '{{site_name}}'  => $blogname,
            '{{sort_name}}'  => $sortName
        ]);
    }
}
