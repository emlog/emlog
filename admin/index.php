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
    $mysql_ver = $DB->getVersion();
    // 检测数据库驱动类型
    $db_driver = '';
    if ($DB instanceof MySqlii) {
        $db_driver = 'MySQLi ';
    } elseif ($DB instanceof DatabasePDO) {
        $db_driver = 'PDO';
    }
    if ($db_driver) {
        $mysql_ver .= ' (' . $db_driver . ')';
    }
    $max_execution_time = ini_get('max_execution_time') ?: '';
    $max_upload_size = ini_get('upload_max_filesize') ?: '';
    $php_ver = PHP_VERSION . ', ' . $max_execution_time . 's,' . $max_upload_size;
    $os = php_uname('s') . ' ' . php_uname('m');
    $role_name = User::getRoleName($role, UID);
    if (extension_loaded('curl')) {
        $c = curl_version();
        $php_ver .= ',curl';
    }
    if (class_exists('ZipArchive', false)) {
        $php_ver .= ',zip';
    }
    if (extension_loaded('gd')) {
        $php_ver .= ',gd';
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
    $logs = $Log_Model->getLogsForAdmin(' ORDER BY date DESC', 'n', 1, 'blog', 5);
    $comments = $Comment_Model->getCommentsForAdmin(0, 0, null, 1, 5);

    include View::getAdmView('uc_header');
    require_once(View::getAdmView('uc_index'));
    include View::getAdmView('uc_footer');
    View::output();
}

if ($action === 'get_all_shortcuts') {
    $allShortcus = Shortcut::getAll();
    Output::ok($allShortcus);
}

if ($action === 'add_shortcut') {
    $shortcut = Input::postStrArray('shortcut');
    $shortcutSet = [];
    foreach ($shortcut as $item) {
        $item = explode('||', $item);
        $shortcutSet[] = [
            'name' => $item[0],
            'url'  => $item[1]
        ];
    }
    Option::updateOption('shortcut', json_encode($shortcutSet, JSON_UNESCAPED_UNICODE));
    $CACHE->updateCache('options');
    emDirect("./index.php?add_shortcut_suc=1");
}
