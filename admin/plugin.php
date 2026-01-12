<?php

/**
 * plugin management
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$plugin = Input::getStrVar("plugin");
$filter = Input::getStrVar('filter'); // on or off

if (empty($action) && empty($plugin)) {
    $Plugin_Model = new Plugin_Model();
    $plugins = $Plugin_Model->getPlugins($filter);

    // Check if the shortcut is valid
    // $shortcuts is global variable
    $shortcutAll = Shortcut::getAll($plugins);
    if ($shortcuts) {
        foreach ($shortcuts as $k => $v) {
            if (!in_array($v, $shortcutAll)) {
                unset($shortcuts[$k]);
                Option::updateOption('shortcut', json_encode($shortcuts, JSON_UNESCAPED_UNICODE));
                $CACHE->updateCache('options');
            }
        }
    }

    include View::getAdmView('header');
    require_once(View::getAdmView('plugin'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'active') {
    LoginAuth::checkToken();
    $Plugin_Model = new Plugin_Model();

    if ($Plugin_Model->activePlugin($plugin)) {
        $CACHE->updateCache('options');
        header('Content-Type: application/json; charset=UTF-8');
        Output::ok(_lang('plugin_active_success'));
    } else {
        Output::error(_lang('plugin_enable_failed'));
    }
}

if ($action == 'inactive') {
    LoginAuth::checkToken();

    if (strpos($plugin, 'tpl_options') !== false) {
        Output::error(_lang('system_plugin_disable_error'));
        return;
    }

    $Plugin_Model = new Plugin_Model();
    $Plugin_Model->inactivePlugin($plugin);
    $CACHE->updateCache('options');

    header('Content-Type: application/json; charset=UTF-8');
    Output::ok(_lang('plugin_inactive_success'));
}

if ($action == 'inactive_all') {
    LoginAuth::checkToken();
    $active_plugins = serialize(['tpl_options/tpl_options.php']);
    Option::updateOption('active_plugins', $active_plugins);
    $CACHE->updateCache('options');
    emDirect("./plugin.php?inactive_all_success=1");
}

// Load plug-in configuration page
if (empty($action) && $plugin) {
    require_once "../content/plugins/$plugin/{$plugin}_setting.php";
    include View::getAdmView('header');
    // 在插件配置页面顶部增加面包屑导航：插件 -> 插件名称
    $pluginModel = new Plugin_Model();
    $pluginData = $pluginModel->getPluginData($plugin . '/' . $plugin . '.php');
    $pluginName = isset($pluginData['Name']) && $pluginData['Name'] ? $pluginData['Name'] : $plugin;
    echo '<nav class="mb-3">';
    echo '<ol class="breadcrumb bg-white px-2 py-2 mb-2">';
    echo '<li class="breadcrumb-item"><a href="./plugin.php">插件</a></li>';
    echo '<li class="breadcrumb-item active" aria-current="page">' . htmlspecialchars($pluginName) . '</li>';
    echo '</ol>';
    echo '</nav>';
    plugin_setting_view();
    include View::getAdmView('footer');
}

// Save plug-in settings
if ($action == 'setting') {
    if (!empty($_POST)) {
        require_once "../content/plugins/$plugin/{$plugin}_setting.php";
        if (false === plugin_setting()) {
            emDirect("./plugin.php?plugin={$plugin}&error=1");
        } else {
            emDirect("./plugin.php?plugin={$plugin}&setting=1");
        }
    } else {
        emDirect("./plugin.php?plugin={$plugin}&error=1");
    }
}

// Save plug-in settings (new version)
if ($action == 'save_setting') {
    require_once "../content/plugins/$plugin/{$plugin}_setting.php";
    plugin_setting();
}

if ($action == 'del') {
    LoginAuth::checkToken();
    $Plugin_Model = new Plugin_Model();
    $Plugin_Model->inactivePlugin($plugin);
    $Plugin_Model->rmCallback($plugin);
    $path = preg_replace("/^([\w-]+)\/[\w-]+\.php$/i", "$1", $plugin);
    if ($path === 'tpl_options') {
        emDirect("./plugin.php?error_sys=1&filter=$filter");
    }
    if ($path && true === emDeleteFile('../content/plugins/' . $path)) {
        $CACHE->updateCache('options');
        emDirect("./plugin.php?activate_del=1&filter=$filter");
    } else {
        emDirect("./plugin.php?error_a=1&filter=$filter");
    }
}

if ($action == 'upload_zip') {
    if (defined('APP_UPLOAD_FORBID') && APP_UPLOAD_FORBID === true) {
        emMsg('系统禁止上传安装应用');
    }
    LoginAuth::checkToken();
    $zipfile = isset($_FILES['pluzip']) ? $_FILES['pluzip'] : '';

    if ($zipfile['error'] == 4) {
        emDirect("./plugin.php?error_d=1");
    }
    if ($zipfile['error'] == 1) {
        emDirect("./plugin.php?error_g=1");
    }
    if (!$zipfile || $zipfile['error'] >= 1 || empty($zipfile['tmp_name'])) {
        emMsg('插件上传失败， 错误码：' . $zipfile['error']);
    }
    if (getFileSuffix($zipfile['name']) != 'zip') {
        emDirect("./plugin.php?error_f=1");
    }

    $ret = emUnZip($zipfile['tmp_name'], '../content/plugins/', 'plugin');
    switch ($ret) {
        case 0:
            emDirect("./plugin.php?activate_install=1");
            break;
        case -1:
            emDirect("./plugin.php?error_e=1");
            break;
        case 1:
        case 2:
            emDirect("./plugin.php?error_b=1");
            break;
        case 3:
            emDirect("./plugin.php?error_c=1");
            break;
    }
}

if ($action === 'check_update') {
    $plugins = Input::postStrArray('plugins', []);

    $emcurl = new EmCurl();
    $post_data = [
        'emkey' => Option::get('emkey'),
        'apps'  => json_encode($plugins),
    ];
    $emcurl->setPost($post_data);
    $emcurl->request('https://store.emlog.net/plugin/upgrade');
    $retStatus = $emcurl->getHttpStatus();
    if ($retStatus !== MSGCODE_SUCCESS) {
        Output::error(_lang('plugin_update_network_error'));
    }
    $response = $emcurl->getRespone();
    $ret = json_decode($response, 1);
    if (empty($ret)) {
        Output::error(_lang('plugin_update_network_error'));
    }
    if ($ret['code'] === MSGCODE_EMKEY_INVALID) {
        Output::error(_lang('plugin_register_error_link'));
    }

    Output::ok($ret['data']);
}

if ($action === 'upgrade') {
    $alias = Input::getStrVar('alias');

    if (!Register::isRegLocal()) {
        Output::error(_lang('emlog_not_registered'), 200);
    }

    $temp_file = emFetchFile('https://www.emlog.net/plugin/down/' . $alias);
    if (!$temp_file) {
        Output::error(_lang('plugin_download_error'), 200);
    }
    $unzip_path = '../content/plugins/';
    $ret = emUnZip($temp_file, $unzip_path, 'plugin');
    @unlink($temp_file);
    switch ($ret) {
        case 0:
            $Plugin_Model = new Plugin_Model();
            $Plugin_Model->upCallback($alias);
            Output::ok();
            break;
        case 1:
        case 2:
            Output::error(_lang('plugin_update_failed_permission'), 200);
            break;
        case 3:
        default:
            Output::error(_lang('plugin_update_package_error'), 200);
    }
}
