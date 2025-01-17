<?php

/**
 * store
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Store_Model = new Store_Model();

$template_categories = [
    0  => '按模板分类查找',
    8  => '博客自媒体',
    7  => '资源下载',
    9  => '社区论坛',
    17 => '网址导航',
    19 => '企业展示',
    21 => '文档知识库',
    10 => '通用主题',
];

$plugin_categories = [
    0  => '按插件分类查找',
    20 => '编辑器',
    2  => 'SEO优化',
    1  => '资源下载',
    18 => '微信生态',
    3  => '多媒体',
    4  => '装饰特效',
    11 => '用户互动',
    12 => '内容运营',
    13 => '移动端（小程序）',
    14 => '编程开发',
    15 => '内容创作',
    16 => '数据采集',
    5  => '文件存储',
    6  => '功能扩展'
];

if (empty($action)) {
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getStrVar('author_id');
    $sid = Input::getStrVar('sid');

    $r = $Store_Model->getApps($tag, $keyword, $page, $author_id, $sid);
    $apps = $r['apps'];
    $count = $r['count'];
    $page_count = $r['page_count'];

    $sub_title = '全部应用';
    if ($tag === 'free') {
        $sub_title = '免费应用';
    } elseif ($tag === 'paid') {
        $sub_title = '付费应用';
    } elseif ($tag === 'promo') {
        $sub_title = '限时优惠';
    }

    $subPage = '';
    foreach ($_GET as $key => $val) {
        $subPage .= $key != 'page' ? "&$key=$val" : '';
    }

    $pageurl = pagination($count, $page_count, $page, "store.php?{$subPage}&page=");

    include View::getAdmView('header');
    require_once(View::getAdmView('store'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'tpl') {
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getStrVar('author_id');
    $sid = Input::getStrVar('sid');

    $r = $Store_Model->getTemplates($tag, $keyword, $page, $author_id, $sid);
    $templates = $r['templates'];
    $count = $r['count'];
    $page_count = $r['page_count'];

    $sub_title = '模板主题';
    if ($tag === 'free') {
        $sub_title = '免费模板';
    } elseif ($tag === 'paid') {
        $sub_title = '付费模板';
    } elseif ($tag === 'promo') {
        $sub_title = '限时优惠';
    } elseif ($tag === 'free_top') {
        $sub_title = '免费排行榜';
    } elseif ($tag === 'paid_top') {
        $sub_title = '付费排行榜';
    }

    $subPage = '';
    foreach ($_GET as $key => $val) {
        $subPage .= $key != 'page' ? "&$key=$val" : '';
    }

    $pageurl = pagination($count, $page_count, $page, "store.php?{$subPage}&page=");

    include View::getAdmView('header');
    require_once(View::getAdmView('store_tpl'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'plu') {
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getIntVar('author_id');
    $sid = Input::getIntVar('sid');

    $r = $Store_Model->getPlugins($tag, $keyword, $page, $author_id, $sid);
    $plugins = $r['plugins'];
    $count = $r['count'];
    $page_count = $r['page_count'];

    $sub_title = '扩展插件';
    if ($tag === 'free') {
        $sub_title = '免费插件';
    } elseif ($tag === 'paid') {
        $sub_title = '付费插件';
    } elseif ($tag === 'promo') {
        $sub_title = '限时优惠';
    } elseif ($tag === 'free_top') {
        $sub_title = '免费排行榜';
    } elseif ($tag === 'paid_top') {
        $sub_title = '付费排行榜';
    }

    $subPage = '';
    foreach ($_GET as $key => $val) {
        $subPage .= $key != 'page' ? "&$key=$val" : '';
    }
    $pageurl = pagination($count, $page_count, $page, "store.php?{$subPage}&page=");

    include View::getAdmView('header');
    require_once(View::getAdmView('store_plu'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'mine') {
    $addons = $Store_Model->getMyAddon();
    $sub_title = '我的已购';

    include View::getAdmView('header');
    require_once(View::getAdmView('store_mine'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'svip') {
    $addons = $Store_Model->getSvipAddon();
    $sub_title = '铁杆免费';

    include View::getAdmView('header');
    require_once(View::getAdmView('store_svip'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'top') {
    $addons = $Store_Model->getTopAddon();
    output::ok($addons);
}

if ($action === 'error') {
    $keyword = '';
    $sub_title = '';
    $sid = '';

    include View::getAdmView('header');
    require_once(View::getAdmView('store'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'install') {
    $source = isset($_GET['source']) ? trim($_GET['source']) : ''; // plugin/down/11
    $cdn_source = isset($_GET['cdn_source']) ? trim($_GET['cdn_source']) : '';
    $source_type = isset($_GET['type']) ? trim($_GET['type']) : '';

    if (empty($source)) {
        exit('安装失败');
    }

    if ($cdn_source) {
        $temp_file = emFetchFile($cdn_source);
    } else {
        $temp_file = emFetchFile('https://www.emlog.net/' . $source);
    }

    if (!$temp_file) {
        if (false === Register::verifyDownload($source)) {
            exit('emlog未注册，<a href="auth.php">去注册</a>');
        }
        exit('安装失败，下载超时');
    }

    if ($source_type == 'tpl') {
        $unzip_path = '../content/templates/';
        $store_path = './store.php?';
        $suc_url = 'template.php';
    } else {
        $unzip_path = '../content/plugins/';
        $store_path = './store.php?action=plu&';
        $suc_url = 'plugin.php';
    }

    $ret = emUnZip($temp_file, $unzip_path, $source_type);
    @unlink($temp_file);
    switch ($ret) {
        case 0:
            exit('安装成功 <a href="' . $suc_url . '">去启用</a>');
        case 1:
            exit('安装失败，请检查content下目录是否可写');
        case 2:
            exit('安装失败，安装包下载异常');
        case 3:
            exit('安装失败，请安装php的Zip扩展');
        default:
            exit('安装失败，不是有效的安装包');
    }
}
