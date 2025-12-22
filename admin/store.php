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
    0  => _lang('store_cat_tpl_search'),
    8  => _lang('store_cat_blog'),
    7  => _lang('store_cat_download'),
    9  => _lang('store_cat_community'),
    17 => _lang('store_cat_navi'),
    19 => _lang('store_cat_corp'),
    21 => _lang('store_cat_docs'),
    10 => _lang('store_cat_general'),
];

$plugin_categories = [
    0  => _lang('store_cat_plu_search'),
    20 => _lang('store_cat_editor'),
    2  => _lang('store_cat_seo'),
    1  => _lang('store_cat_download'),
    18 => _lang('store_cat_wechat'),
    3  => _lang('store_cat_media'),
    4  => _lang('store_cat_decoration'),
    11 => _lang('store_cat_interaction'),
    12 => _lang('store_cat_content'),
    13 => _lang('store_cat_mobile'),
    14 => _lang('store_cat_develop'),
    15 => _lang('store_cat_create'),
    16 => _lang('store_cat_collect'),
    5  => _lang('store_cat_storage'),
    6  => _lang('store_cat_extend')
];

if (empty($action)) {
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getStrVar('author_id');
    $sid = Input::getIntVar('sid');

    $r = $Store_Model->getApps($tag, $keyword, $page, $author_id, $sid);
    $apps = $r['apps'];
    $tab_type = 'all';
    $has_more = $r['has_more'];

    $sub_title = _lang('store_title_all');
    if ($tag === 'free') {
        $sub_title = _lang('store_title_free');
    } elseif ($tag === 'paid') {
        $sub_title = _lang('store_title_paid');
    } elseif ($tag === 'promo') {
        $sub_title = _lang('store_title_promo');
    } elseif ($tag === 'download_top') {
        $sub_title = _lang('store_title_download_top');
    } elseif ($tag === 'favorite_top') {
        $sub_title = _lang('store_title_favorite_top');
    }

    include View::getAdmView('header');
    require_once(View::getAdmView('store'));
    require_once(View::getAdmView('store_app_list'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'tpl') {
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getStrVar('author_id');
    $sid = Input::getIntVar('sid');

    $r = $Store_Model->getTemplates($tag, $keyword, $page, $author_id, $sid);
    $apps = $r['templates'];
    $tab_type = 'tpl';
    $has_more = $r['has_more'];

    $sub_title = _lang('store_title_tpl');
    if ($tag === 'free') {
        $sub_title = _lang('store_title_tpl_free');
    } elseif ($tag === 'paid') {
        $sub_title = _lang('store_title_tpl_paid');
    } elseif ($tag === 'promo') {
        $sub_title = _lang('store_title_promo');
    } elseif ($tag === 'paid_top') {
        $sub_title = _lang('store_title_buy_top');
    } elseif ($tag === 'download_top') {
        $sub_title = _lang('store_title_download_top');
    }

    include View::getAdmView('header');
    require_once(View::getAdmView('store_tpl'));
    require_once(View::getAdmView('store_app_list'));
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
    $apps = $r['plugins'];
    $tab_type = 'plu';
    $has_more = $r['has_more'];

    $sub_title = _lang('store_title_plu');
    if ($tag === 'free') {
        $sub_title = _lang('store_title_plu_free');
    } elseif ($tag === 'paid') {
        $sub_title = _lang('store_title_plu_paid');
    } elseif ($tag === 'promo') {
        $sub_title = _lang('store_title_promo');
    } elseif ($tag === 'paid_top') {
        $sub_title = _lang('store_title_buy_top');
    } elseif ($tag === 'download_top') {
        $sub_title = _lang('store_title_download_top');
    }

    include View::getAdmView('header');
    require_once(View::getAdmView('store_plu'));
    require_once(View::getAdmView('store_app_list'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'mine') {
    $addons = $Store_Model->getMyAddon();
    $sub_title = _lang('store_title_mine');

    include View::getAdmView('header');
    require_once(View::getAdmView('store_mine'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'svip') {
    $addons = $Store_Model->getSvipAddon();
    $sub_title = _lang('store_title_svip');

    include View::getAdmView('header');
    require_once(View::getAdmView('store_svip'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'favorite') {
    $page = Input::getIntVar('page', 1);
    $r = $Store_Model->getFavorites($page);
    $apps = isset($r['favorites']) ? $r['favorites'] : [];
    $tab_type = 'favorite';
    $has_more = isset($r['has_more']) ? $r['has_more'] : false;
    $sub_title = _lang('store_title_favorite');

    include View::getAdmView('header');
    require_once(View::getAdmView('store_favorite'));
    include View::getAdmView('footer');
    View::output();
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
    $source = Input::getStrVar('source', ''); // plugin/down/11
    $source_type = Input::getStrVar('type', '');

    if (empty($source)) {
        exit(_lang('store_install_failed'));
    }

    $store_url = base64_decode('aHR0cHM6Ly9zdG9yZS5lbWxvZy5uZXQv');
    $temp_file = emFetchFile($store_url . $source);

    if (!$temp_file) {
        if (false === Register::verifyDownload($source)) {
            exit(_lang('store_register_error'));
        }
        exit(_lang('store_install_timeout'));
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
            exit(sprintf(_lang('store_install_success_link'), $suc_url));
        case 1:
            exit(_lang('store_install_failed_permission'));
        case 2:
            exit(_lang('store_install_failed_download'));
        case 3:
            exit(_lang('store_install_failed_zip'));
        default:
            exit(_lang('store_install_failed_invalid'));
    }
}

if ($action === 'ajax_load') {
    $type = Input::getStrVar('type', 'all'); // all, tpl, plu
    $tag = Input::getStrVar('tag');
    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $author_id = Input::getStrVar('author_id');
    $sid = Input::getIntVar('sid');

    $Store_Model = new Store_Model();

    switch ($type) {
        case 'tpl':
            $r = $Store_Model->getTemplates($tag, $keyword, $page, $author_id, $sid);
            $apps = $r['templates'];
            break;
        case 'plu':
            $r = $Store_Model->getPlugins($tag, $keyword, $page, $author_id, $sid);
            $apps = $r['plugins'];
            break;
        case 'favorite':
            $r = $Store_Model->getFavorites($page);
            $apps = isset($r['favorites']) ? $r['favorites'] : [];
            break;
        default:
            $r = $Store_Model->getApps($tag, $keyword, $page, $author_id, $sid);
            $apps = $r['apps'];
            break;
    }

    $count = $r['count'];
    $page_count = $r['page_count'];
    $has_more = isset($r['has_more']) ? $r['has_more'] : ($page < $page_count);
    $next_page = $has_more ? $page + 1 : null;

    // 为每个应用添加状态信息
    foreach ($apps as &$app) {
        // 检查是否正在使用
        if ($app['app_type'] === 'template') {
            $app['is_active'] = Template::isActive($app['alias']);
        } else {
            $app['is_active'] = Plugin::isActive($app['alias']);
        }
        $app['user_is_svip'] = (Register::getRegType() === 2);
    }

    $response = [
        'code' => 200,
        'data' => [
            'apps' => $apps,
            'count' => $count,
            'page_count' => $page_count
        ],
        'has_more' => $has_more,
        'current_page' => $page,
        'next_page' => $next_page
    ];

    Output::json($response);
}

if ($action === 'add_favorite') {
    $app_type = Input::postStrVar('app_type'); // plugin 或 template
    $app_id = Input::postIntVar('app_id');

    if (empty($app_type) || empty($app_id)) {
        Output::json(['code' => 400, 'msg' => _lang('store_param_error')]);
    }

    if (!in_array($app_type, ['plugin', 'template'])) {
        Output::json(['code' => 400, 'msg' => _lang('store_type_error')]);
    }

    $result = $Store_Model->addFavorite($app_type, $app_id);
    Output::json($result);
}

if ($action === 'remove_favorite') {
    $app_type = Input::postStrVar('app_type'); // plugin 或 template
    $app_id = Input::postIntVar('app_id');

    if (empty($app_type) || empty($app_id)) {
        Output::json(['code' => 400, 'msg' => _lang('store_param_error')]);
    }

    if (!in_array($app_type, ['plugin', 'template'])) {
        Output::json(['code' => 400, 'msg' => _lang('store_type_error')]);
    }

    $result = $Store_Model->removeFavorite($app_type, $app_id);
    Output::json($result);
}
