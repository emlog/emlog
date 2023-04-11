<?php
/**
 * sort manager
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$Sort_Model = new Sort_Model();
$sorts = $CACHE->readCache('sort');

if (empty($action)) {
    include View::getAdmView('header');
    require_once View::getAdmView('sort');
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'taxis') {
    $sort = isset($_POST['sort']) ? $_POST['sort'] : '';
    if (!empty($sort)) {
        foreach ($sort as $key => $value) {
            $value = (int)$value;
            $key = (int)$key;
            $Sort_Model->updateSort(array('taxis' => $value), $key);
        }
        $CACHE->updateCache('sort');
        emDirect("./sort.php?active_taxis=1");
    } else {
        emDirect("./sort.php?error_b=1");
    }
}

if ($action == 'add') {
    $sortname = isset($_POST['sortname']) ? addslashes(trim($_POST['sortname'])) : '';
    $alias = isset($_POST['alias']) ? addslashes(trim($_POST['alias'])) : '';
    $pid = isset($_POST['pid']) ? (int)$_POST['pid'] : 0;
    $template = isset($_POST['template']) && $_POST['template'] != 'log_list' ? addslashes(trim($_POST['template'])) : '';
    $description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';

    if (empty($sortname)) {
        emDirect("./sort.php?error_a=1");
    }
    if (!empty($alias)) {
        if (!preg_match("|^[\w-]+$|", $alias)) {
            emDirect("./sort.php?error_c=1");
        } elseif (preg_match("|^[0-9]+$|", $alias)) {
            emDirect("./sort.php?error_f=1");
        } elseif (in_array($alias, array('post', 'record', 'sort', 'tag', 'author', 'page'))) {
            emDirect("./sort.php?error_e=1");
        } else {
            $sort_cache = $CACHE->readCache('sort');
            foreach ($sort_cache as $key => $value) {
                if ($alias == $value['alias']) {
                    emDirect("./sort.php?error_d=1");
                }
            }
        }
    }
    if ($pid != 0 && !isset($sorts[$pid])) {
        $pid = 0;
    }

    $Sort_Model->addSort($sortname, $alias, $pid, $description, $template);
    $CACHE->updateCache(array('sort', 'navi'));
    emDirect("./sort.php?active_add=1");
}

if ($action == 'mod_sort') {
    $sid = isset($_GET['sid']) ? (int)$_GET['sid'] : '';

    $sortData = $Sort_Model->getOneSortById($sid);
    extract($sortData);

    include View::getAdmView('header');
    require_once(View::getAdmView('sortedit'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'update') {
    $sid = isset($_POST['sid']) ? (int)$_POST['sid'] : '';
    $sortname = isset($_POST['sortname']) ? addslashes(trim($_POST['sortname'])) : '';
    $pid = isset($_POST['pid']) ? (int)$_POST['pid'] : 0;
    $template = isset($_POST['template']) && $_POST['template'] != 'log_list' ? addslashes(trim($_POST['template'])) : '';
    $description = isset($_POST['description']) ? addslashes(trim($_POST['description'])) : '';

    $sort_data = [];
    if (empty($sortname)) {
        emDirect("./sort.php?action=mod_sort&sid={$sid}&error_a=1");
    }
    $sort_data['sortname'] = $sortname;
    $sort_data['pid'] = $pid;
    $sort_data['template'] = $template;
    $sort_data['description'] = $description;

    if (isset($_POST['alias'])) {
        $sort_data['alias'] = addslashes(trim($_POST['alias']));
        if (!empty($sort_data['alias'])) {
            if (!preg_match("|^[\w-]+$|", $sort_data['alias'])) {
                emDirect("./sort.php?action=mod_sort&sid={$sid}&error_c=1");
            } elseif (preg_match("|^[0-9]+$|", $sort_data['alias'])) {
                emDirect("././sort.php?action=mod_sort&sid={$sid}&error_c=1");
            } elseif (in_array($sort_data['alias'], array('post', 'record', 'sort', 'tag', 'author', 'page'))) {
                emDirect("././sort.php?action=mod_sort&sid={$sid}&error_e=1");
            } else {
                $sort_cache = $CACHE->readCache('sort');
                unset($sort_cache[$sid]);
                foreach ($sort_cache as $key => $value) {
                    if ($sort_data['alias'] == $value['alias']) {
                        emDirect("././sort.php?action=mod_sort&sid={$sid}&error_d=1");
                    }
                }
            }
        }
    }

    $Sort_Model->updateSort($sort_data, $sid);
    $CACHE->updateCache(array('sort', 'logsort', 'navi'));
    emDirect("./sort.php?active_edit=1");
}

if ($action == 'del') {
    $sid = isset($_GET['sid']) ? (int)$_GET['sid'] : '';

    LoginAuth::checkToken();

    $Sort_Model->deleteSort($sid);
    $CACHE->updateCache(array('sort', 'logsort', 'navi'));
    emDirect("./sort.php?active_del=1");
}
