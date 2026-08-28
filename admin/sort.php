<?php

/**
 * sort manager
 * @package EMLOG
 * 
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Sort_Model = new Sort_Model();

if (empty($action)) {
    $sorts = $Sort_Model->getSorts();

    $Template_Model = new Template_Model();
    $customTemplates = $Template_Model->getCustomTemplates('sort');

    include View::getAdmView('header');
    require_once View::getAdmView('sort');
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'taxis') {
    $sort = Input::postStrArray('sort', []);

    if (empty($sort)) {
        Output::error(_lang('no_sortable_sort'));
    }

    foreach ($sort as $key => $value) {
        $value = (int)$value;
        $key = (int)$key;
        $Sort_Model->updateSort(array('taxis' => $key), $value);
    }

    $CACHE->updateCache(['sort', 'navi']);
    Output::ok();
}

if ($action == 'save') {
    $sid = Input::postIntVar('sid');
    $sortname = Input::postStrVar('sortname');
    $alias = Input::postStrVar('alias');
    $pid = Input::postIntVar('pid');
    $template = Input::postStrVar('template') != 'log_list' ? Input::postStrVar('template') : '';
    $description = Input::postStrVar('description');
    $kw = Input::postStrVar('kw');
    $title = Input::postStrVar('title');
    $sortimg = Input::postStrVar('sortimg');
    $page_count = Input::postIntVar('page_count');
    $allow_user_post = Input::postStrVar('allow_user_post') === 'y' ? 'y' : 'n';

    if (empty($sortname)) {
        FlashMsg::redirectAdmin('sort', 'error_a');
    }

    $sort_cache = $CACHE->readCache('sort');

    if ($pid == 0) {
        foreach ($sort_cache as $key => $value) {
            if ($sid && $sid == $key) {
                continue;
            }
            if ($value['pid'] == 0 && $value['sortname'] === $sortname) {
                FlashMsg::redirectAdmin('sort', 'error_b');
            }
        }
    }

    if ($sid && $sid == $pid) {
        FlashMsg::redirectAdmin('sort', 'error_f');
    }

    if (!empty($alias)) {
        if (!preg_match("|^[\w-]+$|", $alias)) {
            FlashMsg::redirectAdmin('sort', 'error_c');
        } elseif (preg_match("|^[0-9]+$|", $alias)) {
            FlashMsg::redirectAdmin('sort', 'error_c');
        } elseif (in_array($alias, array('post', 'record', 'sort', 'tag', 'author', 'page', 'posts'))) {
            FlashMsg::redirectAdmin('sort', 'error_e');
        } else {
            foreach ($sort_cache as $key => $value) {
                if ($sid && $sid == $key) {
                    continue;
                }
                if ($alias == $value['alias']) {
                    FlashMsg::redirectAdmin('sort', 'error_d');
                }
            }
        }
    }

    $sort_data = [
        'sortname'        => $sortname,
        'pid'             => $pid,
        'template'        => $template,
        'description'     => $description,
        'kw'              => $kw,
        'title'           => $title,
        'alias'           => $alias,
        'sortimg'         => $sortimg,
        'page_count'      => $page_count,
        'allow_user_post' => $allow_user_post
    ];

    if ($sid) {
        $Sort_Model->updateSort($sort_data, $sid);
    } else {
        $Sort_Model->addSort($sort_data);
    }

    doAction('save_sort', $sid, $sort_data);

    $CACHE->updateCache(['sort', 'logsort', 'navi']);
    FlashMsg::redirectAdmin('sort', 'active_save');
}

if ($action == 'del') {
    LoginAuth::checkToken();
    $sid = Input::getIntVar('sid');
    if ($sid > 0) {
        $Sort_Model->deleteSort($sid);
    } else {
        $sort_ids = Input::postIntArray('sort_ids', []);
        foreach ($sort_ids as $id) {
            $Sort_Model->deleteSort((int)$id);
        }
    }
    $CACHE->updateCache(['sort', 'logsort', 'navi']);
    FlashMsg::redirectWithFlash('./sort.php', array(), 'sort_flash_messages', 'active_del');
}
