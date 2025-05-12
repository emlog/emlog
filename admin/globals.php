<?php

/**
 * global
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once '../init.php';

$sta_cache = $CACHE->readCache('sta');
$user_cache = $CACHE->readCache('user');
$action = Input::getStrVar('action');
$shortcuts = Shortcut::getActive();

loginAuth::checkLogin();
User::checkRolePermission();
