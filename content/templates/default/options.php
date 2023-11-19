<?php
/*@support tpl_options*/

/**
 * 模板设置的配置文件
 * 详见官网文档-模板开发：https://www.emlog.net/docs/#/template
 */

defined('EMLOG_ROOT') || exit('access denied!');

$options = [
    'TplOptionsNavi' => [
        'type'        => 'radio',
        'name'        => '定义设置项标签页名称',
        'values'      => [
            'tpl-head' => '头部设置',
        ],
        /*
        'icons' => [
            'tpl-head' => 'ri-layout-top-line',
        ],
        */
        'description' => '<p>你好，这是默认模板的设置界面，请点击上方菜单进入设置项。</p>'
    ],
    'logotype'       => [
        'labels'  => 'tpl-head',
        'type'    => 'radio',
        'name'    => 'LOGO显示模式',
        'values'  => [
            '1' => '文字',
            '0' => '图片',
        ],
        'default' => '1',
    ],
    'logoimg'        => [
        'labels'      => 'tpl-head',
        'type'        => 'image',
        'name'        => 'LOGO上传',
        'values'      => [
            TEMPLATE_URL . 'images/logo.png',
        ],
        'description' => '上传LOGO图片。'
    ],
];