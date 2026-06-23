<?php

/**
 * Service: Shortcut
 *
 * @package EMLOG
 * 
 */

class Shortcut
{

    /**
     * 获取当前处于激活状态的快捷入口
     * 
     * @return array 包含快捷入口名'name'和对应链接'url'的关联数组
     */
    public static function getActive()
    {
        $shortcut = Option::get('shortcut');
        if ($shortcut === null || $shortcut === '') {
            return [
                ['name' => _lang('write_article'), 'url' => 'article.php?action=write'],
                ['name' => _lang('article'), 'url' => 'article.php'],
                ['name' => _lang('draft'), 'url' => 'article.php?draft=1'],
            ];
        }
        return json_decode($shortcut, 1) ?: [];
    }

    /**
     * 获取所有可配置的快捷入口候选列表
     *
     * @param array $plugins 插件列表缓存，如果为空则内部自动查询
     * @return array 包含所有可选快捷入口的关联数组
     */
    public static function getAll($plugins = [])
    {
        if (empty($plugins)) {
            $Plugin_Model = new Plugin_Model();
            $plugins = $Plugin_Model->getPlugins();
        }
        $shortcutAll = [
            ['name' => _lang('write_article'), 'url' => 'article.php?action=write'],
            ['name' => _lang('article'), 'url' => 'article.php'],
            ['name' => _lang('draft'), 'url' => 'article.php?draft=1'],
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
