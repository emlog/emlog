<?php
/**
 * 模板的系统调用文件
 * 模板启用后，该文件会被系统自动加载。可用于实现类似插件的功能。
 */

defined('EMLOG_ROOT') || exit('access denied!');

/* eg:

function sameFunc() {
    echo "hello world";
}

addAction('adm_head', 'sameFunc');

*/

/*
// 后台模板设置菜单增加 icon 图标
function optionIconFont() {
    echo sprintf('<link rel="stylesheet" href="%s">', 'https://cdn.bootcdn.net/ajax/libs/remixicon/3.5.0/remixicon.min.css?ver=' . Option::EMLOG_VERSION_TIMESTAMP);
}

addAction('adm_head', 'optionIconFont');
*/
