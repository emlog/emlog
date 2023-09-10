<?php
/**
 * control panel
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
    $avatar = empty($user_cache[UID]['avatar']) ? './views/images/avatar.svg' : '../' . $user_cache[UID]['avatar'];
    $name = $user_cache[UID]['name'];
    $role = $user_cache[UID]['role'];

    // server info
    $server_app = $_SERVER['SERVER_SOFTWARE'];
    $DB = Database::getInstance();
    $mysql_ver = $DB->getMysqlVersion();
    $max_execution_time = ini_get('max_execution_time') ?: '';
    $max_upload_size = ini_get('upload_max_filesize') ?: '';
    $php_ver = PHP_VERSION . ', ' . $max_execution_time . 's,' . $max_upload_size;
    $role_name = User::getRoleName($role, UID);
    if (function_exists('curl_init')) {
        $c = curl_version();
        $php_ver .= ',curl' . $c['version'];
    }
    if (class_exists('ZipArchive', false)) {
        $php_ver .= ',zip';
    }

    if (User::haveEditPermission()) {
        include View::getAdmView('header');
        require_once(View::getAdmView('index'));
        include View::getAdmView('footer');
        View::output();
    }

    // user center
    $Log_Model = new Log_Model();
    $Comment_Model = new Comment_Model();
    $Note_Model = new Twitter_Model();

    $article_amount = $Log_Model->getCount();
    $note_amount = $Note_Model->getCount();
    $comment_amount = $Comment_Model->getCommentNum();
    $logs = $Log_Model->getLogsForAdmin();
    $comments = $Comment_Model->getCommentsForAdmin();

    include View::getAdmView('header_user');
    require_once(View::getAdmView('index_user'));
    include View::getAdmView('footer_user');
    View::output();
}
