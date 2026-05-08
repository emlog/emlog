<?php

/**
 * templates
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Template_Model = new Template_Model();

if ($action === '') {
    $nonce_template = Option::get('nonce_templet');
    $nonce_template_data = @file(TPLS_PATH . $nonce_template . '/header.php');

    $templates = $Template_Model->getTemplates();

    $auto_open_setting = Input::getIntVar('setting', 0); // 直接进入当前模板设置界面

    include View::getAdmView('header');
    require_once View::getAdmView('template');
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'use') {
    LoginAuth::checkToken();
    $tplName = Input::getStrVar('tpl');

    Option::updateOption('nonce_templet', $tplName);
    $CACHE->updateCache('options');
    $Template_Model->initCallback($tplName);

    FlashMsg::redirectAdmin('template', 'activated');
}

if ($action === 'del') {
    LoginAuth::checkToken();
    $tplName = Input::getStrVar('tpl');

    $nonce_templet = Option::get('nonce_templet');
    if ($tplName === $nonce_templet) {
        emMsg('不能删除正在使用的模板');
    }

    $Template_Model->rmCallback($tplName);

    $path = preg_replace("/^([\w-]+)$/i", "$1", $tplName);
    if ($path && true === emDeleteFile(TPLS_PATH . $path)) {
        FlashMsg::redirectAdmin('template', '', array(), '', 'tpllib');
    } else {
        FlashMsg::redirectAdmin('template', 'error_f', array(), '', 'tpllib');
    }
}

if ($action === 'install') {
    include View::getAdmView('header');
    require_once View::getAdmView('template_install');
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'upload_zip') {
    if (defined('APP_UPLOAD_FORBID') && APP_UPLOAD_FORBID === true) {
        emMsg('系统禁止上传安装应用');
    }
    LoginAuth::checkToken();
    $zipfile = isset($_FILES['tplzip']) ? $_FILES['tplzip'] : '';

    if ($zipfile['error'] == 4) {
        FlashMsg::redirectAdmin('template', 'error_d');
    }
    if ($zipfile['error'] == 1) {
        FlashMsg::redirectAdmin('template', 'error_g');
    }
    if (!$zipfile || $zipfile['error'] > 0 || empty($zipfile['tmp_name'])) {
        emMsg('模板上传失败， 错误码：' . $zipfile['error']);
    }
    if (getFileSuffix($zipfile['name']) != 'zip') {
        FlashMsg::redirectAdmin('template', 'error_a');
    }

    $ret = emUnZip($zipfile['tmp_name'], '../content/templates/', 'tpl');
    switch ($ret) {
        case 0:
            FlashMsg::redirectAdmin('template', 'activate_install');
            break;
        case -2:
            FlashMsg::redirectAdmin('template', 'error_e');
            break;
        case 1:
        case 2:
            FlashMsg::redirectAdmin('template', 'error_b');
            break;
        case 3:
            FlashMsg::redirectAdmin('template', 'error_c');
            break;
    }
}

if ($action === 'upgrade_done') {
    FlashMsg::redirectAdmin('template', 'activate_upgrade');
}

if ($action === 'check_update') {
    $templates = Input::postStrArray('templates', []);

    $emcurl = new EmCurl();
    $post_data = [
        'emkey' => Option::get('emkey'),
        'apps'  => json_encode($templates),
    ];
    $emcurl->setPost($post_data);
    $emcurl->request('https://store.emlog.net/template/upgrade');
    $retStatus = $emcurl->getHttpStatus();
    if ($retStatus !== MSGCODE_SUCCESS) {
        Output::error(_lang('template_update_network_error'));
    }
    $response = $emcurl->getRespone();
    $ret = json_decode($response, 1);
    if (empty($ret)) {
        Output::error(_lang('template_update_network_error'));
    }
    if ($ret['code'] === MSGCODE_EMKEY_INVALID) {
        Output::error(_lang('emlog_not_registered'));
    }

    Output::ok($ret['data']);
}

if ($action === 'upgrade') {
    $alias = Input::getStrVar('alias');

    if (!Register::isRegLocal()) {
        Output::error(_lang('emlog_not_registered'), 200);
    }

    $temp_file = emFetchFile('https://www.emlog.net/template/down/' . $alias);
    if (!$temp_file) {
        Output::error(_lang('template_download_error'), 200);
    }
    $unzip_path = '../content/templates/';
    $ret = emUnZip($temp_file, $unzip_path, 'tpl');
    @unlink($temp_file);
    switch ($ret) {
        case 0:
            $Template_Model->upCallback($alias);
            Output::ok();
            break;
        case 1:
        case 2:
            Output::error(_lang('template_update_failed_permission'), 200);
            break;
        case 3:
        default:
            Output::error(_lang('template_update_package_error'), 200);
    }
}
