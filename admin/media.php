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
    $uid = Input::getStrVar('uid');

    if (!User::haveEditPermission()) {
        $uid = UID;
    }

    $page_count = 24;
    $page_url = 'media.php?';
    $page_url .= $sid ? "sid=$sid&" : '';
    $page_url .= $date ? "date=$date&" : '';
    $page_url .= $uid ? "uid=$uid&" : '';
    $dateTime = $date . ' 23:59:59';
    $medias = $Media_Model->getMedias($page, $page_count, $uid, $sid, $dateTime);
    $count = $Media_Model->getMediaCount($uid, $sid, $dateTime);
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
        $data['media_path'] = $v['filepath'];
        $data['media_url'] = rmUrlParams(getFileUrl($v['filepath']));
        $data['media_name'] = subString($v['filename'], 0, 20);
        $data['attsize'] = $v['attsize'];
        $data['media_type'] = '';
        $data['media_icon'] = "./views/images/fnone.png";
        if (isImage($v['mimetype'])) {
            $data['media_icon'] = getFileUrl($v['filepath_thum']);
            $data['media_type'] = 'image';
        } elseif (isZip($v['filename'])) {
            $data['media_icon'] = "./views/images/zip.jpg";
        } elseif (isVideo($v['filename'])) {
            $data['media_type'] = 'video';
            $data['media_icon'] = "./views/images/video.png";
        } elseif (isAudio($v['filename'])) {
            $data['media_type'] = 'audio';
            $data['media_icon'] = "./views/images/audio.png";
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

    // 注册用户限制24小时发文数量（包括草稿）, 为0时禁止发布笔记和上传图文资源
    if (!User::haveEditPermission() && Option::get('posts_per_day') <= 0) {
        $ret['message'] = '抱歉，系统限制用户上传资源';
        if ($editor) {
            exit(json_encode($ret));
        } else {
            header("HTTP/1.0 400 Bad Request");
            exit($ret['message']);
        }
    }

    if (!$attach || $attach['error'] === 4) {
        if ($editor) {
            echo json_encode(['success' => 0, 'message' => 'upload error']);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo "upload error";
        }
        exit;
    }

    $ret = '';

    addAction('upload_media', 'upload2local');
    doOnceAction('upload_media', $attach, $ret);

    if (empty($ret['success'])) {
        if ($editor) {
            echo json_encode($ret);
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo $ret['message'];
        }
        exit;
    }

    $aid = $Media_Model->addMedia($ret['file_info'], $sid);
    if ($editor) {
        echo json_encode($ret);
    } else {
        echo 'success';
    }
}

if ($action === 'delete') {
    LoginAuth::checkToken();
    $aid = Input::getIntVar('aid');
    $Media_Model->deleteMedia($aid);
    emDirect("media.php?active_del=1");
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
            emDirect("media.php?active_del=1");
            break;
        case 'move':
            foreach ($aids as $id) {
                $Media_Model->updateMedia(['sortid' => $sort], $id);
            }
            emDirect("media.php?active_mov=1");
            break;
    }
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
    emDirect("./media.php?active_del=1");
}
