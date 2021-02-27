<?php
/**
 * 前端页面加载
 * @package EMLOG
 */

require_once 'init.php';

define('TEMPLATE_PATH', TPLS_PATH . Option::get('nonce_templet') . '/');//前台模板路径

$emDispatcher = Dispatcher::getInstance();
$emDispatcher->dispatch();
View::output();
