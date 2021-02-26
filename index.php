<?php
/**
 * Front page loading
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'init.php';

define('TEMPLATE_PATH', TPLS_PATH . Option::get('nonce_templet') . '/');//Front template path

$emDispatcher = Dispatcher::getInstance();
$emDispatcher->dispatch();
View::output();
