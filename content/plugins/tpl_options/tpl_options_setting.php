<?php
!defined('EMLOG_ROOT') && exit('access deined!');

//插件设置页面
function plugin_setting_view() {
	TplOptions::getInstance()->setting();
}

//插件设置函数，不用
function plugin_setting() {
}
