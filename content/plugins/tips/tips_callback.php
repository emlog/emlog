<?php
defined('EMLOG_ROOT') || exit('access denied!');

// 开启插件时执行该函数
function callback_init()
{
    // do something
}

// 删除插件时执行该函数
function callback_rm()
{
    // 卸载插件时删除插件创建的表，文件
}

// 更新插件时执行该函数
function callback_up()
{
    // 升级时更新数据库表结构等操作
}
