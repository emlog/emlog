<?php
/**
 * plugin user interface
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$plugin = isset($_GET['plugin']) ? $_GET['plugin'] : '';

if (empty($action) && $plugin) {
    require_once "../content/plugins/{$plugin}/{$plugin}_user.php";

    include View::getAdmView(User::isAdmin() ? 'header' : 'header_user');
    plugin_user_view();
    include View::getAdmView(User::isAdmin() ? 'footer' : 'footer_user');
}
