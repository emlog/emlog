<?php
/*@support tpl_options*/

/**
 * 模板设置的配置文件，详见官网文档-模板开发部分
 */

!defined('EMLOG_ROOT') && exit('access denied!');

/* eg:
$options = [
    'TplOptionsNavi' => [
        'type'        => 'radio',
        'name'        => '定义设置项标签页名称',
        'values'      => [
            'tpl-head' => '头部设置',
        ],
        'description' => '<p>模板：晨 <br>欢迎使用这款简约的模板，目前仅支持设置头部logo</p>'
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
*/