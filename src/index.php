<?php
/**
 * 前端页面加载
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'init.php';

/*
$calendar_url = isset($_GET['record']) ? DYNAMIC_BLOGURL.'?action=cal&record='.intval($_GET['record']) : DYNAMIC_BLOGURL.'?action=cal' ;
if ($action == 'cal') {
    Calendar::generate();
}
*/

define('TEMPLATE_URL', 	TPLS_URL.Options::get('nonce_templet').'/');//前台模板URL
define('TEMPLATE_PATH', TPLS_PATH.Options::get('nonce_templet').'/');//前台模板路径
define('CURPAGE_HOME',  'home');
define('CURPAGE_LOG',   'echo_log');

$emController = Controller::getInstance();

$emController->route();

View::output();
