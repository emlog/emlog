<?php

/**
 * Service: Tag
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Tag
{
    static function formatTagTitle($title, $tagName)
    {
        $site_title = Option::get('site_title');
        $blogname = Option::get('blogname');

        if (empty($site_title)) {
            $site_title = $blogname;
        }

        return strtr($title, [
            '{{site_title}}' => $site_title,
            '{{site_name}}'  => $blogname,
            '{{tag_name}}'  => $tagName
        ]);
    }
}
