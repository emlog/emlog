<?php
/**
 * 模板的系统调用文件
 * 模板启用后，该文件会被系统自动加载。可用于实现类似插件的功能。
 */

if (!defined('EMLOG_ROOT')) {
    exit('error!');
}

/* eg:

function sameFunc() {
    echo "xxxx";
}

addAction('adm_head', 'sameFunc');

*/
