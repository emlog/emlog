<?php
/*
Plugin Name: 模版设置插件
*/
defined('EMLOG_ROOT') || exit('access denied!');

//插件设置页面
function plugin_setting_view() {
    TplOptions::getInstance()->setting();
}
