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

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    $sqlSegment = ' ORDER BY date DESC';
    $pages = $emPage->getLogsForAdmin($sqlSegment, '', $page, 'page');
    $pageNum = $emPage->getLogNum('', '', 'page', 1);

    $pageurl = pagination($pageNum, Option::get('admin_perpage_num'), $page, "./page.php?page=");

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
    $pageId = isset($_GET['id']) ? (int)$_GET['id'] : '';
    $pageData = $emPage->getOneLogForAdmin($pageId);
    extract($pageData);

    //media
    $Media_Model = new Media_Model();
    $medias = $Media_Model->getMedias();

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

    $title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
    $content = isset($_POST['pagecontent']) ? addslashes(trim($_POST['pagecontent'])) : '';
    $alias = isset($_POST['alias']) ? addslashes(trim($_POST['alias'])) : '';
    $pageId = isset($_POST['pageid']) ? (int)trim($_POST['pageid']) : -1;
    $ishide = isset($_POST['ishide']) && empty($_POST['ishide']) ? 'n' : addslashes($_POST['ishide']);
    $template = isset($_POST['template']) && $_POST['template'] != 'page' ? addslashes(trim($_POST['template'])) : '';
    $allow_remark = isset($_POST['allow_remark']) ? addslashes(trim($_POST['allow_remark'])) : 'n';
    $home_page = isset($_POST['home_page']) ? addslashes(trim($_POST['home_page'])) : 'n';
    $link = Input::postStrVar('link');

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
    $operate = isset($_POST['operate']) ? $_POST['operate'] : '';
    $pages = isset($_POST['page']) ? array_map('intval', $_POST['page']) : array();

    LoginAuth::checkToken();

    $emPage = new Log_Model();

    switch ($operate) {
        case 'del':
            foreach ($pages as $value) {
                $emPage->deleteLog($value);
                unset($navibar[$value]);
            }
            $navibar = addslashes(serialize($navibar));
            Option::updateOption('navibar', $navibar);
            $CACHE->updateCache(array('options', 'sta', 'comment', 'logalias'));

            emDirect("./page.php?active_del=1");
            break;
        case 'hide':
        case 'pub':
            $ishide = $operate == 'hide' ? 'y' : 'n';
            foreach ($pages as $value) {
                $emPage->hideSwitch($value, $ishide);
                $navibar[$value]['hide'] = $ishide;
            }
            $navibar = addslashes(serialize($navibar));
            Option::updateOption('navibar', $navibar);
            $CACHE->updateCache(array('options', 'sta', 'comment'));
            emDirect("./page.php?active_hide_" . $ishide . "=1");
            break;
    }
}
