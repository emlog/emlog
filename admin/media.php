<?php
/**
 * 链接管理
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

$DB = Database::getInstance();

if (empty($action)) {
    $sql = "SELECT * FROM " . DB_PREFIX . "attachment WHERE thumfor = 0";
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
