<?php

/**
 * plugin management
 * @package EMLOG
 * @link https://www.emlog.net
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
        emDirect("./plugin.php?active=1&filter=$filter");
    } else {
        emDirect("./plugin.php?active_error=1&filter=$filter");
    }
}

if ($action == 'inactive') {
    LoginAuth::checkToken();
    if (strpos($plugin, 'tpl_options') !== false) {
        emDirect("./plugin.php?error_sys=1&filter=$filter");
    }
    $Plugin_Model = new Plugin_Model();
    $Plugin_Model->inactivePlugin($plugin);
    $CACHE->updateCache('options');
    emDirect("./plugin.php?inactive=1&filter=$filter");
}

// Load plug-in configuration page
if (empty($action) && $plugin) {
    require_once "../content/plugins/$plugin/{$plugin}_setting.php";
    include View::getAdmView('header');
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
    $plugins = isset($_POST['plugins']) ? $_POST['plugins'] : [];

    $emcurl = new EmCurl();
    $post_data = [
        'emkey' => Option::get('emkey'),
        'apps'  => json_encode($plugins),
    ];
    $emcurl->setPost($post_data);
    $emcurl->request('https://store.emlog.net/plugin/upgrade');
    $retStatus = $emcurl->getHttpStatus();
    if ($retStatus !== MSGCODE_SUCCESS) {
        Output::error('请求更新失败，可能是网络问题');
    }
    $response = $emcurl->getRespone();
    $ret = json_decode($response, 1);
    if (empty($ret)) {
        Output::error('请求更新失败，可能是网络问题');
    }
    if ($ret['code'] === MSGCODE_EMKEY_INVALID) {
        Output::error('您的emlog pro尚未注册，<a href="auth.php">去注册</a>');
    }

    Output::ok($ret['data']);
}

if ($action === 'upgrade') {
    $alias = isset($_GET['alias']) ? trim($_GET['alias']) : '';

    if (!Register::isRegLocal()) {
        Output::error('您的emlog尚未正版注册', 200);
    }

    $temp_file = emFetchFile('https://www.emlog.net/plugin/down/' . $alias);
    if (!$temp_file) {
        Output::error('无法下载更新包，可能是服务器网络问题', 200);
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
            Output::error('上传失败，插件目录(content/plugins)不可写', 200);
            break;
        case 3:
            Output::error('请选择一个zip插件安装包', 200);
            break;
        default:
            Output::error('安装失败，插件安装包不符合标准', 200);
    }
}
