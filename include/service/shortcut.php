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
            ['name' => _lang('template'), 'url' => 'template.php'],
            ['name' => _lang('plugin'), 'url' => 'plugin.php'],
            ['name' => _lang('category'), 'url' => 'sort.php'],
            ['name' => _lang('tag'), 'url' => 'tag.php'],
            ['name' => _lang('page'), 'url' => 'page.php'],
            ['name' => _lang('navbar'), 'url' => 'navbar.php'],
            ['name' => _lang('widget'), 'url' => 'widgets.php'],
            ['name' => _lang('link'), 'url' => 'link.php'],
        ];
        foreach ($plugins as $val) {
            if (empty($val) || $val['active'] === 'off' || !$val['Setting'] || in_array($val['Plugin'], ['tips', 'tpl_options'])) {
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
