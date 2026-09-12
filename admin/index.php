<?php

/**
 * control panel
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
    $avatar = User::getAvatar(isset($currentUser['photo']) ? $currentUser['photo'] : '');
    $name = isset($currentUser['nickname']) ? $currentUser['nickname'] : '';
    $role = isset($currentUser['role']) ? $currentUser['role'] : User::ROLE_VISITOR;

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
    if (extension_loaded('mbstring')) {
        $php_ver .= ',mbstr';
    }
    if (Util::isDevEnv()) {
        $php_ver .= ',dev';
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
    if (!User::haveEditPermission()) {
        emMsg(_lang('permission_denied'));
    }
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

/**
 * 异步检查主题和插件的更新状态
 * 
 * @return void
 */
if ($action === 'check_app_update') {
    if (!User::isAdmin()) {
        Output::error(_lang('permission_denied'));
    }

    $templatesToUpdate = [];
    $pluginsToUpdate = [];

    // 获取已安装模板列表
    $Template_Model = new Template_Model();
    $templates = $Template_Model->getTemplates();
    $templateList = [];
    if (is_array($templates)) {
        foreach ($templates as $tpl) {
            if (!empty($tpl['tplfile'])) {
                $templateList[] = [
                    'name'    => $tpl['tplfile'],
                    'version' => isset($tpl['version']) ? $tpl['version'] : '',
                ];
            }
        }
    }

    // 获取已安装插件列表
    $Plugin_Model = new Plugin_Model();
    $plugins = $Plugin_Model->getPlugins();
    $pluginList = [];
    if (is_array($plugins)) {
        foreach ($plugins as $plu) {
            if (!empty($plu['Plugin'])) {
                $pluginList[] = [
                    'name'    => $plu['Plugin'],
                    'version' => isset($plu['Version']) ? $plu['Version'] : '',
                ];
            }
        }
    }

    $emkey = Option::get('emkey');

    // 检查主题更新
    if (!empty($templateList)) {
        $emcurl = new EmCurl(5);
        $emcurl->setPost([
            'emkey' => $emkey,
            'apps'  => json_encode($templateList),
        ]);
        $emcurl->request('https://store.emlog.net/template/upgrade');
        if ($emcurl->getHttpStatus() === MSGCODE_SUCCESS) {
            $res = json_decode($emcurl->getRespone(), true);
            if (is_array($res) && (!isset($res['code']) || $res['code'] === 0 || $res['code'] === MSGCODE_SUCCESS) && !empty($res['data']) && is_array($res['data'])) {
                $templatesToUpdate = $res['data'];
            }
        }
    }

    // 检查插件更新
    if (!empty($pluginList)) {
        $emcurl = new EmCurl(5);
        $emcurl->setPost([
            'emkey' => $emkey,
            'apps'  => json_encode($pluginList),
        ]);
        $emcurl->request('https://store.emlog.net/plugin/upgrade');
        if ($emcurl->getHttpStatus() === MSGCODE_SUCCESS) {
            $res = json_decode($emcurl->getRespone(), true);
            if (is_array($res) && (!isset($res['code']) || $res['code'] === 0 || $res['code'] === MSGCODE_SUCCESS) && !empty($res['data']) && is_array($res['data'])) {
                $pluginsToUpdate = $res['data'];
            }
        }
    }

    Output::ok([
        'templates'      => $templatesToUpdate,
        'plugins'        => $pluginsToUpdate,
        'template_count' => count($templatesToUpdate),
        'plugin_count'   => count($pluginsToUpdate),
        'total_count'    => count($templatesToUpdate) + count($pluginsToUpdate),
    ]);
}

