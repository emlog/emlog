<?php
/**
 * Media management
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$DB = Database::getInstance();

if (empty($action)) {
    $sql = "SELECT * FROM " . DB_PREFIX . "attachment WHERE thumfor = 0 order by aid desc";
    $query = $DB->query($sql);
    $attach = array();
    while ($row = $DB->fetch_array($query)) {
        $attsize = changeFileSize($row['filesize']);
        $filename = htmlspecialchars($row['filename']);
        $attach[$row['aid']] = array(
            'attsize' => $attsize,
            'aid' => $row['aid'],
            'filepath' => $row['filepath'],
            'filename' => $filename,
            'addtime' => date("Y-m-d H:i", $row['addtime']),
            'width' => $row['width'],
            'height' => $row['height'],
        );
        $thum = $DB->once_fetch_array('SELECT * FROM ' . DB_PREFIX . 'attachment WHERE thumfor = ' . $row['aid']);
        if ($thum) {
            $attach[$row['aid']]['thum_filepath'] = $thum['filepath'];
            $attach[$row['aid']]['thum_width'] = $thum['width'];
            $attach[$row['aid']]['thum_height'] = $thum['height'];
        }
    }
    $attachnum = count($attach);

    include View::getView('header');
    require_once(View::getView('media'));
    include View::getView('footer');
    View::output();
}

if ($action === 'upload_multi') {
    $logid = isset($_GET['logid']) ? (int)$_GET['logid'] : 0;
    $attach = $_FILES['file'] ?? '';

    if (!$attach || $attach['error'] == 4) {
        return;
    }

    $isthumbnail = Option::get('isthumbnail') === 'y';
    $attach['name'] = Database::getInstance()->escape_string($attach['name']);
    $file_info = uploadFileBySwf($attach['name'], $attach['error'], $attach['tmp_name'], $attach['size'], Option::getAttType(), false, $isthumbnail);

    // Write attachment information
    $query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s',0)";
    $query = sprintf($query, $logid, $file_info['file_name'], $file_info['size'], $file_info['file_path'], time(), $file_info['width'], $file_info['height'], $file_info['mime_type']);
    $DB->query($query);
    $aid = $DB->insert_id();
    $DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum+1 WHERE gid=$logid");

    // Write thumbnail information
    if (isset($file_info['thum_file'])) {
        $query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype, thumfor) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s')";
        $query = sprintf($query, $logid, $file_info['file_name'], $file_info['thum_size'], $file_info['thum_file'], time(), $file_info['thum_width'], $file_info['thum_height'], $file_info['mime_type'], $aid);
        $DB->query($query);
    }
}

//Delete attachment
if ($action === 'delete') {
    LoginAuth::checkToken();
    $aid = isset($_GET['aid']) ? (int)$_GET['aid'] : '';
    $query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE aid = $aid ");
    $attach = $DB->fetch_array($query);
    $logid = $attach['blogid'];
    if (file_exists($attach['filepath'])) {
/*vot*/ @unlink($attach['filepath']) or emMsg(lang('attachment_delete_error'));
    }

    $query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE thumfor = " . $attach['aid']);
    $thum_attach = $DB->fetch_array($query);
    if ($thum_attach) {
        if (file_exists($thum_attach['filepath'])) {
/*vot*/     @unlink($thum_attach['filepath']) or emMsg(lang('attachment_delete_error'));
        }
        $DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$thum_attach['aid']} ");
    }

    $DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum-1 WHERE gid = {$attach['blogid']}");
    $DB->query("DELETE FROM " . DB_PREFIX . "attachment WHERE aid = {$attach['aid']} ");
    emDirect("media.php?active_del=1");
}
