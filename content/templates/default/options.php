<?php
/*@support tpl_options*/

/**
 * 模板设置的配置文件
 * 详见官网文档-模板开发：https://www.emlog.net/docs/dev/template
 */

defined('EMLOG_ROOT') || exit('access denied!');

$options = [
    'TplOptionsNavi' => [
        'type'        => 'radio',
        'name'        => _langTpl('tpl_options_navi_name'),
        'values'      => [
            'tpl-head' => _langTpl('tpl_head'),
            'tpl-home' => _langTpl('tpl_home'),
        ],
        'description' => _langTpl('tpl_options_desc')
    ],
    'logotype'       => [
        'labels'  => 'tpl-head',
        'type'    => 'radio',
        'name'    => _langTpl('logo_type_name'),
        'new'     => 'NEW',
        'values'  => [
            '1' => _langTpl('text'),
            '0' => _langTpl('image'),
        ],
        'default' => '1',
    ],
    'logoimg'        => [
        'labels'      => 'tpl-head',
        'type'        => 'image',
        'name'        => _langTpl('logo_img_name'),
        'values'      => [
            TEMPLATE_URL . 'images/logo.png',
        ],
        'description' => _langTpl('logo_img_desc')
    ],
    'favicon'        => [
        'labels'      => 'tpl-head',
        'type'        => 'image',
        'name'        => _langTpl('favicon_name'),
        'description' => _langTpl('favicon_desc')
    ],
    'slideShow'      => [
        'labels'      => 'tpl-home',
        'type'        => 'text',
        'name'        => _langTpl('slideshow_name'),
        'multi'       => true,
        'description' => _langTpl('slideshow_desc'),
    ],
];
