<?php

/**
 * 模板预设的文章自定义字段
 */

defined('EMLOG_ROOT') || exit('access denied!');

$options_field = [
    'price' => [
        'type'        => 'text',
        'name'        => '价格',
        'description' => '设置文章价格，如：100.00',
        'default'     => ''
    ],
    'need_login' => [
        'type'        => 'radio',
        'name'        => '是否需要登录',
        'values'      => [
            '0' => '否',
            '1' => '是'
        ],
        'description' => '设置文章是否需要登录才能查看',
        'default'     => '0'
    ],
];
