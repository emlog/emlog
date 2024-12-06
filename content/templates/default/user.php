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

获取当前路由
user/profile
if ($routerPath === 'profile') {
    //展示个人资料页
}

user/order_calback
if ($routerPath === 'order_calback') {
    //实现支付回调逻辑
}

引入其他模板文件
include View::getView('footer')
*/

emDirect('/');
