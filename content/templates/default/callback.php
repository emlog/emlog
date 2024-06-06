<?php
defined('EMLOG_ROOT') || exit('access denied!');

// 启用主题时执行该函数
function callback_init() {
    emMsg('启用主题成功', './');
}

// 删除主题时执行该函数
function callback_rm() {
    emMsg('删除主题成功', './');
    // do something
}

// 更新主题时执行该函数
function callback_up() {
    emMsg('更新主题成功', './');
    // do something
}
