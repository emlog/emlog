<?php

/**
 * Service: Shortcut
 *
 * @package EMLOG
 * 
 */

class Shortcut
{

    public static function getActive()
    {
        $shortcut = Option::get('shortcut');
        if (empty($shortcut)) {
            return [];
        }
        return json_decode($shortcut, 1);
    }

    public static function getAll($plugins = [])
    {
        if (empty($plugins)) {
            $Plugin_Model = new Plugin_Model();
            $plugins = $Plugin_Model->getPlugins();
        }
        $shortcutAll = [
            ['name' => '模板', 'url' => 'template.php'],
            ['name' => '插件', 'url' => 'plugin.php'],
            ['name' => '分类', 'url' => 'sort.php'],
            ['name' => '标签', 'url' => 'tag.php'],
            ['name' => '页面', 'url' => 'page.php'],
            ['name' => '导航', 'url' => 'navbar.php'],
            ['name' => '边栏', 'url' => 'widgets.php'],
            ['name' => '链接', 'url' => 'link.php'],
        ];
        foreach ($plugins as $val) {
            if (empty($val) || $val['active'] === 'off' || !$val['Setting'] || in_array($val['Name'], ['小贴士', '模板设置'])) {
                continue;
            }
            $shortcutAll[] = [
                'name' => $val['Name'],
                'url'  => './plugin.php?plugin=' . $val['Plugin'],
            ];
        }

        return $shortcutAll;
    }
}
