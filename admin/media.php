<?php

/**
 * media
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$DB = Database::getInstance();

$Media_Model = new Media_Model();
$MediaSortModel = new MediaSort_Model();

if (empty($action)) {
    $sid = Input::getIntVar('sid');
    $page = Input::getIntVar('page', 1);
    $date = Input::getStrVar('date');
    $uid = Input::getIntVar('uid');
    $keyword = Input::getStrVar('keyword');
    $show = Input::getStrVar('show');

    if (!User::haveEditPermission()) {
        $uid = UID;
    }

    if ($show === 'list' || $show === 'grid') {
        Option::updateOption('media_show_model', $show);
        $CACHE->updateCache('options');
    }
    $show = Option::get('media_show_model');
    if ($show !== 'list' && $show !== 'grid') {
        $show = 'grid';
    }

    $page_count = 24;
    $page_url = 'media.php?';
    $page_url .= $sid ? "sid=$sid&" : '';
    $page_url .= $date ? "date=$date&" : '';
    $page_url .= $uid ? "uid=$uid&" : '';
    $page_url .= $keyword ? "keyword=$keyword&" : '';
    $dateTime = $date ? $date . ' 23:59:59' : '';
    $medias = $Media_Model->getMedias($page, $page_count, $uid, $sid, $dateTime, $keyword);
    $count = $Media_Model->getMediaCount($uid, $sid, $dateTime, $keyword);
    $page = pagination($count, $page_count, $page, $page_url . 'page=');

    $sorts = $MediaSortModel->getSorts();

    include View::getAdmView(User::haveEditPermission() ? 'header' : 'uc_header');
    require_once(View::getAdmView('media'));
    include View::getAdmView(User::haveEditPermission() ? 'footer' : 'uc_footer');
    View::output();
}

if ($action === 'lib') {
    $sid = Input::getIntVar('sid');
    $page = Input::getIntVar('page', 1);
    $uid = User::haveEditPermission() ? null : UID;
    $perPageCount = 12;

    $medias = $Media_Model->getMedias($page, $perPageCount, $uid, $sid);
    $count = $Media_Model->getMediaCount($uid, $sid);

    $ret['hasMore'] = !(count($medias) < $perPageCount);
    foreach ($medias as $v) {
        $data['media_id'] = $v['aid'];
        $data['media_alias'] = $v['alias'];
        $data['media_path'] = $v['filepath'];
        $data['media_url'] = rmUrlParams(getFileUrl($v['filepath']));
        $data['media_down_url'] = BLOG_URL . '?resource_alias=' . $v['alias'];
        $data['media_name'] = subString($v['filename'], 0, 20);
        $data['attsize'] = $v['attsize'];
        $data['media_type'] = '';
        $data['media_icon'] = "./views/images/fnone.webp";
        if (isImage($v['mimetype'])) {
            $data['media_icon'] = getFileUrl($v['filepath_thum']);
            $data['media_type'] = 'image';
        } elseif (isZip($v['filename'])) {
            $data['media_icon'] = "./views/images/zip.webp";
            $data['media_type'] = 'zip';
        } elseif (isVideo($v['mimetype'])) {
            $data['media_type'] = 'video';
            $data['media_icon'] = "./views/images/video.webp";
        } elseif (isAudio($v['filename'])) {
            $data['media_type'] = 'audio';
            $data['media_icon'] = "./views/images/audio.webp";
        }
        $ret['images'][] = $data;
    }
    Output::ok($ret);
}

if ($action === 'upload') {
    $sid = Input::getIntVar('sid');
    $editor = isset($_GET['editor']) ? 1 : 0; // 是否来自Markdown编辑器的上传
    $attach = isset($_FILES['file']) ? $_FILES['file'] : '';
    if ($editor) {
        $attach = isset($_FILES['editormd-image-file']) ? $_FILES['editormd-image-file'] : '';
    }

    if (!User::haveEditPermission() && Option::get('forbid_user_upload') === 'y') {
        Media::uploadRespond(['message' => '系统关闭了资源上传'], $editor);
    }

    $uploadCheckResult = Media::checkUpload($attach);
    if ($uploadCheckResult !== true) {
        Media::uploadRespond(['message' => $uploadCheckResult], $editor);
    }

    $ret = '';

    addAction('upload_media', 'upload2local');
    doOnceAction('upload_media', $attach, $ret);

    if (empty($ret['success'])) {
        Media::uploadRespond($ret, $editor);
    }

    $aid = $Media_Model->addMedia($ret['file_info'], $sid);
    Media::uploadRespond($ret, $editor, true);
}

if ($action === 'delete') {
    LoginAuth::checkToken();
    $aid = Input::getIntVar('aid');
    $Media_Model->deleteMedia($aid);
    emDirect("media.php");
}

if ($action === 'delete_async') {
    $aid = Input::postIntVar('aid');
    $Media_Model->deleteMedia($aid);
    output::ok();
}

if ($action === 'operate_media') {
    $operate = Input::postStrVar('operate');
    $sort = Input::postIntVar('sort');
    $aids = isset($_POST['aids']) ? array_map('intval', $_POST['aids']) : array();

    LoginAuth::checkToken();
    switch ($operate) {
        case 'del':
            foreach ($aids as $value) {
                $Media_Model->deleteMedia($value);
            }
            emDirect("media.php");
            break;
        case 'move':
            foreach ($aids as $id) {
                $Media_Model->updateMedia(['sortid' => $sort], $id);
            }
            emDirect("media.php?active_mov=1");
            break;
    }
}

if ($action === 'update_media') {
    $filename = Input::postStrVar('filename');
    $id = Input::postIntVar('id');

    if (empty($filename)) {
        emDirect("./media.php?error_a=1");
    }

    $Media_Model->updateMedia(["filename" => $filename], $id);
    emDirect("./media.php?active_edit=1");
}

if ($action === 'add_media_sort') {
    if (!User::isAdmin()) {
        emMsg('权限不足！', './');
    }
    $sortname = Input::postStrVar('sortname');
    if (empty($sortname)) {
        emDirect("./media.php?error_a=1");
    }

    $MediaSortModel->addSort($sortname);
    emDirect("./media.php?active_add=1");
}

if ($action === 'update_media_sort') {
    if (!User::isAdmin()) {
        emMsg('权限不足！', './');
    }
    $sortname = Input::postStrVar('sortname');
    $id = isset($_POST['id']) ? (int)$_POST['id'] : '';

    if (empty($sortname)) {
        emDirect("./media.php?error_a=1");
    }

    $MediaSortModel->updateSort(["sortname" => $sortname], $id);
    emDirect("./media.php?active_edit=1");
}

if ($action === 'del_media_sort') {
    if (!User::isAdmin()) {
        emMsg('权限不足！', './');
    }
    $id = Input::getIntVar('id');

    LoginAuth::checkToken();

    $MediaSortModel->deleteSort($id);
    emDirect("./media.php");
}
