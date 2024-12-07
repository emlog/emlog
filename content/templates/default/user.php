<?php

/**
 * 前台用户中心
 */
defined('EMLOG_ROOT') || exit('access denied!');

/*
判断是否登录
if (ISLOGIN) {
    //do something
}

获取当前登录用户信息
$userData['photo']
$userData['nickname']
$userData['description']
$userData['email']

根据路由判断是否引入头部
if (in_array($routerPath, ['', 'vip', 'order', 'like', 'account', 'profile'])) {
    include View::getView('header');
}

实现对应功能
if ($routerPath === 'profile') {
    //展示个人资料页
} elseif ($routerPath === 'order_calback') {
    // do payment callback
} else {
    show_404_page();
}

引入底部模板文件
include View::getView('footer')
*/

emDirect('/');
