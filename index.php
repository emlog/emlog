<?php
/**
 * @package EMLOG
 * @link https://www.emlog.net
 */

require_once 'init.php';

$emDispatcher = Dispatcher::getInstance();
$emDispatcher->dispatch();
View::output();
