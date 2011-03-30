<?php
/**
 * 前端页面加载
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'init.php';

define('TEMPLATE_PATH', TPLS_PATH.Option::get('nonce_templet').'/');//前台模板路径
define('CURPAGE_HOME',  'home');
define('CURPAGE_LOG',   'echo_log');
define('CURPAGE_TW',    'twitter');

$emDispatcher = Dispatcher::getInstance();
$emDispatcher->dispatch();
View::output();
