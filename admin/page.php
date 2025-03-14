<?php

/**
 * page
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (empty($action)) {
    $emPage = new Log_Model();

    $page = Input::getIntVar('page', 1);
    $keyword = Input::getStrVar('keyword');
    $order = Input::getStrVar('order');

    $condition = '';
    if ($keyword) {
        $condition = "and title like '%$keyword%'";
    }

    $orderBy = ' ORDER BY ';
    switch ($order) {
        case 'view':
            $orderBy .= 'views DESC';
            break;
        case 'comm':
            $orderBy .= 'comnum DESC';
            break;
        default:
            $orderBy .= 'date DESC';
            break;
    }

    $perPage = 20;
    $pages = $emPage->getLogsForAdmin($condition . $orderBy, '', $page, 'page', $perPage);
    $pageNum = $emPage->getLogNum('', $condition, 'page', 1);

    $pageurl = pagination($pageNum, $perPage, $page, "./page.php?page=");

    include View::getAdmView('header');
    require_once(View::getAdmView('page'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'new') {
    $pageData = array(
        'containertitle'  => '新建页面',
        'pageId'          => -1,
        'title'           => '',
        'content'         => '',
        'alias'           => '',
        'hide'            => '',
        'template'        => 'page',
        'is_allow_remark' => 'n',
        'is_home_page'    => 'n',
        'att_frame_url'   => 'attachment.php?action=selectFile',
        'link'            => '',
        'cover'           => '',
    );
    extract($pageData);

    $MediaSort_Model = new MediaSort_Model();
    $mediaSorts = $MediaSort_Model->getSorts();

    $Template_Model = new Template_Model();
    $customTemplates = $Template_Model->getCustomTemplates('page');

    include View::getAdmView('header');
    require_once(View::getAdmView('page_create'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'mod') {
    $emPage = new Log_Model();

    $Template_Model = new Template_Model();
    $customTemplates = $Template_Model->getCustomTemplates('page');

    $containertitle = '编辑页面';
    $pageId = Input::getIntVar('id');
    $pageData = $emPage->getOneLogForAdmin($pageId);
    extract($pageData);

    //media
    $Media_Model = new Media_Model();
    $medias = $Media_Model->getMedias();

    $MediaSort_Model = new MediaSort_Model();
    $mediaSorts = $MediaSort_Model->getSorts();

    $is_allow_remark = $allow_remark == 'y' ? 'checked="checked"' : '';
    $is_home_page = Option::get('home_page_id') == $pageId ? 'checked="checked"' : '';

    include View::getAdmView('header');
    require_once(View::getAdmView('page_create'));
    include View::getAdmView('footer');
    View::output();
}

if ($action == 'save') {
    $emPage = new Log_Model();
    $Navi_Model = new Navi_Model();

    $title = Input::postStrVar('title');
    $content = Input::postStrVar('pagecontent');
    $alias = Input::postStrVar('alias');
    $pageId = Input::postIntVar('pageid', -1);
    $ishide = isset($_POST['ishide']) && empty($_POST['ishide']) ? 'n' : addslashes($_POST['ishide']);
    $template = isset($_POST['template']) && $_POST['template'] != 'page' ? addslashes(trim($_POST['template'])) : '';
    $allow_remark = Input::postStrVar('allow_remark', 'n');
    $home_page = Input::postStrVar('home_page', 'n');
    $link = Input::postStrVar('link');
    $cover = Input::postStrVar('cover');

    $postTime = time();

    if (!empty($alias)) {
        $logalias_cache = $CACHE->readCache('logalias');
        $alias = $emPage->checkAlias($alias, $logalias_cache, $pageId);
    }

    $logData = array(
        'title'        => $title,
        'content'      => $content,
        'excerpt'      => '',
        'date'         => $postTime,
        'allow_remark' => $allow_remark,
        'hide'         => $ishide,
        'alias'        => $alias,
        'type'         => 'page',
        'template'     => $template,
        'link'         => $link,
        'cover'        => $cover,
    );

    $directUrl = '';
    if ($pageId > 0) {
        $emPage->updateLog($logData, $pageId);
        $directUrl = './page.php?active_pubpage=1';
    } else {
        $pageId = $emPage->addlog($logData);
        $directUrl = './page.php?active_hide_n=1';
    }

    if ($home_page === 'y') {
        Option::updateOption('home_page_id', $pageId);
    } elseif (Option::get('home_page_id') == $pageId) {
        Option::updateOption('home_page_id', 0);
    }

    $CACHE->updateCache(array('options', 'logalias'));

    doAction('save_page', $pageId, $logData);

    switch ($action) {
        case 'autosave':
            echo "autosave_gid:{$pageId}_df:0_";
            break;
        case 'save':
            emDirect($directUrl);
            break;
    }
}

if ($action == 'operate_page') {
    $operate = Input::postStrVar('operate');
    $pages = Input::postIntArray('page');

    LoginAuth::checkToken();

    $emPage = new Log_Model();

    switch ($operate) {
        case 'del':
            $home_page_id = Option::get('home_page_id');
            foreach ($pages as $value) {
                $emPage->deleteLog($value);
                // 如果被删除的页面是首页，需要恢复默认首页
                if ($home_page_id == $value) {
                    Option::updateOption('home_page_id', 0);
                }
            }
            $CACHE->updateCache(array('options', 'sta', 'comment', 'logalias'));
            emDirect("./page.php");
            break;
        case 'hide':
        case 'pub':
            $ishide = $operate == 'hide' ? 'y' : 'n';
            foreach ($pages as $value) {
                $emPage->hideSwitch($value, $ishide);
            }
            $CACHE->updateCache(array('options', 'sta', 'comment'));
            emDirect("./page.php?active_hide_" . $ishide . "=1");
            break;
    }
}
