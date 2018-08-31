<?php
/**
 * 后台全局项加载
 * @copyright (c) Emlog All Rights Reserved
 */

require_once '../init.php';

define('TEMPLATE_PATH', EMLOG_ROOT.'/admin/views/');//后台当前模板路径
define('OFFICIAL_SERVICE_HOST', 'http://www.emlog.net/');//官方服务域名

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = isset($_GET['action']) ? addslashes($_GET['action']) : '';

//登录验证
if ($action == 'login') {
    $username = isset($_POST['user']) ? addslashes(trim($_POST['user'])) : '';
    $password = isset($_POST['pw']) ? addslashes(trim($_POST['pw'])) : '';
    $ispersis = isset($_POST['ispersis']) ? intval($_POST['ispersis']) : false;
    $img_code = Option::get('login_code') == 'y' && isset($_POST['imgcode']) ? addslashes(trim(strtoupper($_POST['imgcode']))) : '';

    $loginAuthRet = LoginAuth::checkUser($username, $password, $img_code);
    
    if ($loginAuthRet === true) {
        LoginAuth::setAuthCookie($username, $ispersis);
        emDirect("./");
    } else{
        if(isset($_SESSION['code'])){
            unset($_SESSION['code']);
        }
        LoginAuth::loginPage($loginAuthRet);
    }
}
//退出
if ($action == 'logout') {
    setcookie(AUTH_COOKIE_NAME, ' ', time() - 31536000, '/');
    emDirect("../");
}

if (ISLOGIN === false) {
    LoginAuth::loginPage();
}

$request_uri = strtolower(substr(basename($_SERVER['SCRIPT_NAME']), 0, -4));
if (ROLE == ROLE_WRITER && !in_array($request_uri, array('write_log','admin_log','attachment','blogger','comment','index','save_log'))) {
    emMsg('权限不足！','./');
}
