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
    $sort = isset($_POST['sort']) ? $_POST['sort'] : '';

    if (empty($sort)) {
        emDirect("./sort.php?error_b=1");
    }
    foreach ($sort as $key => $value) {
        $value = (int)$value;
        $key = (int)$key;
        $Sort_Model->updateSort(array('taxis' => $key), $value);
    }

    $CACHE->updateCache(['sort', 'navi']);
    emDirect("./sort.php?active_taxis=1");
}

if ($action == 'save') {
    $sid = Input::postIntVar('sid');
    $sortname = Input::postStrVar('sortname');
    $alias = Input::postStrVar('alias');
    $pid = Input::postIntVar('pid');
    $template = isset($_POST['template']) && $_POST['template'] != 'log_list' ? addslashes(trim($_POST['template'])) : '';
    $description = Input::postStrVar('description');
    $kw = Input::postStrVar('kw');

    if (empty($sortname)) {
        emDirect("./sort.php?action=mod_sort&sid={$sid}&error_a=1");
    }

    if (!empty($alias)) {
        if (!preg_match("|^[\w-]+$|", $alias)) {
            emDirect("./sort.php?error_c=1");
        } elseif (preg_match("|^[0-9]+$|", $alias)) {
            emDirect("./sort.php?error_c=1");
        } elseif (in_array($alias, array('post', 'record', 'sort', 'tag', 'author', 'page', 'posts'))) {
            emDirect("./sort.php?error_e=1");
        } else {
            $sort_cache = $CACHE->readCache('sort');
            if ($sid) {
                unset($sort_cache[$sid]);
            }
            foreach ($sort_cache as $key => $value) {
                if ($alias == $value['alias']) {
                    emDirect("./sort.php?error_d=1");
                }
            }
        }
    }

    $sort_data = [
        'sortname'    => $sortname,
        'pid'         => $pid,
        'template'    => $template,
        'description' => $description,
        'kw'          => $kw,
        'alias'       => $alias
    ];

    if ($sid) {
        $Sort_Model->updateSort($sort_data, $sid);
    } else {
        $Sort_Model->addSort($sort_data);
    }
    $CACHE->updateCache(['sort', 'logsort', 'navi']);
    emDirect("./sort.php?active_edit=1");
}

if ($action == 'del') {
    $sid = Input::getIntVar('sid');

    LoginAuth::checkToken();

    $Sort_Model->deleteSort($sid);
    $CACHE->updateCache(['sort', 'logsort', 'navi']);
    emDirect("./sort.php?active_del=1");
}
