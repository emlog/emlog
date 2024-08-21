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

    // 快捷入口
    $Plugin_Model = new Plugin_Model();
    $plugins = $Plugin_Model->getPlugins('on');
    $shortcutAll = [
        ['name' => '模板', 'url' => 'template.php'],
        ['name' => '插件', 'url' => 'plugin.php'],
        ['name' => '分类', 'url' => 'sort.php'],
        ['name' => '标签', 'url' => 'tag.php'],
        ['name' => '页面', 'url' => 'page.php'],
        ['name' => '导航', 'url' => 'navbar.php'],
        ['name' => '边栏', 'url' => 'widgets.php'],
        ['name' => '链接', 'url' => 'link.php'],
    ];
    foreach ($plugins as $val) {
        if (empty($val) || !$val['Setting'] || in_array($val['Name'], ['小贴士', '模板设置'])) {
            continue;
        }
        $shortcutAll[] = [
            'name' => $val['Name'],
            'url'  => './plugin.php?plugin=' . $val['Plugin'],
        ];
    }
    $shortcut = Option::get('shortcut');
    $shortcut = json_decode($shortcut, 1);
    if ($shortcut) {
        foreach ($shortcut as $k => $v) {
            if (!in_array($v, $shortcutAll)) {
                unset($shortcut[$k]);
                Option::updateOption('shortcut', json_encode($shortcut, JSON_UNESCAPED_UNICODE));
                $CACHE->updateCache('options');
            }
        }
    } else {
        $shortcut = [];
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
    $comments = $Comment_Model->getCommentsForAdmin(0, 0, null, 1);

    include View::getAdmView('uc_header');
    require_once(View::getAdmView('uc_index'));
    include View::getAdmView('uc_footer');
    View::output();
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
