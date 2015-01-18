<?php
/**
 * Page Management
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

//Load the Page Management page
if ($action == '') {
    $emPage = new Log_Model();

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

    $pages = $emPage->getLogsForAdmin('', '', $page, 'page');
    $pageNum = $emPage->getLogNum('','','page', 1);

    $pageurl =  pagination($pageNum, Option::get('admin_perpage_num'), $page, "./page.php?page=");

    include View::getView('header');
    require_once(View::getView('admin_page'));
    include View::getView('footer');
    View::output();
}
//Display a new page form 
if ($action == 'new') {
    include View::getView('header');
    require_once(View::getView('add_page'));
    include View::getView('footer');
    View::output();
}
//Show edit page form
if ($action == 'mod') {
    $emPage = new Log_Model();

    $pageId = isset($_GET['id']) ? intval($_GET['id']) : '';
    $pageData = $emPage->getOneLogForAdmin($pageId);
    extract($pageData);

    $pageUrl = isset($navibar[$pageId]['url']) ? $navibar[$pageId]['url'] : '' ;
    $blank = isset($navibar[$pageId]['is_blank']) ? $navibar[$pageId]['is_blank'] : '' ;

    $is_allow_remark = $allow_remark == 'y' ? 'checked="checked"' : '';
    $is_blank = $blank == '_blank' ? 'checked="checked"' : '';

    include View::getView('header');
    require_once(View::getView('edit_page'));
    include View::getView('footer');
    View::output();
}
//Save Page
if ($action == 'add' || $action == 'edit' || $action == 'autosave') {
    $emPage = new Log_Model();
    $Navi_Model = new Navi_Model();

    $title = isset($_POST['title']) ? addslashes(trim($_POST['title'])) : '';
    $content = isset($_POST['content']) ? addslashes(trim($_POST['content'])) : '';
    $alias = isset($_POST['alias']) ? addslashes(trim($_POST['alias'])) : '';
/*vot*/	$pageId = isset($_POST['as_logid']) ? intval(trim($_POST['as_logid'])) : -1;//If they are automatically saved as a draft there blog id number
    $ishide = isset($_POST['ishide']) && empty($_POST['ishide']) ? 'n' : addslashes($_POST['ishide']);
    $template = isset($_POST['template']) && $_POST['template'] != 'page' ? addslashes(trim($_POST['template'])) : '';
    $allow_remark = isset($_POST['allow_remark']) ? addslashes(trim($_POST['allow_remark'])) : 'n';

    LoginAuth::checkToken();

    $postTime = $emPage->postDate(Option::get('timezone'));

    //check alias
    if (!empty($alias)) {
        $logalias_cache = $CACHE->readCache('logalias');
        $alias = $emPage->checkAlias($alias, $logalias_cache, $pageId);
    }

    $logData = array(
    'title'=>$title,
    'content'=>$content,
    'excerpt'=>'',
    'date'=>$postTime,
    'allow_remark'=>$allow_remark,
    'hide'=>$ishide,
    'alias'=>$alias,
    'type'=>'page',
    'template' => $template,
    );

/*vot*/	if ($pageId > 0) {//auto-save, add into update
        $emPage->updateLog($logData, $pageId);
    } else{
        $pageId = $emPage->addlog($logData);
    }

    $CACHE->updateCache(array('options', 'logalias'));

    switch ($action) {
        case 'autosave':
            echo "autosave_gid:{$pageId}_df:0_";
            break;
        case 'add':
        case 'edit':
            if ($action == 'add') {
/*vot*/				emDirect("./page.php?active_hide_n=1");//Page publishing success
            } else {
/*vot*/				emDirect("./page.php?active_savepage=1");//Page saved successfully
            }
            break;
    }
}
//Page Operations
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
            emDirect("./page.php?active_hide_".$ishide."=1");
            break;
    }
}
