<?php

/**
 * 前台用户中心
 */
defined('EMLOG_ROOT') || exit('access denied!');

/*

前台用户中心模板使用说明如下：

判断是否登录
if (ISLOGIN) {
    //do something
}

获取当前登录用户信息
$userData['photo']
$userData['nickname']
$userData['description']
$userData['email']

获取当前路由路径
变量 $routerPath 存储了当前请求的路由路径，如：/user/profile，$routerPath 值为 profile

引入头部模板文件（可根据路由判断是否引入）
if (in_array($routerPath, ['', 'order', 'account', 'profile', 'weiyu'])) {
    include View::getView('header');
}

实现路由对应功能
if ($routerPath === 'profile') {
    //展示个人资料页
} elseif ($routerPath === 'weiyu') {
    // 展示微语页
} elseif ($routerPath === 'order_calback') {
    // 处理支付回调逻辑
} else {
    show_404_page();
}

引入底部模板文件
include View::getView('footer')

*/

emDirect('/');
