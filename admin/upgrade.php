<?php
/**
 * upgrade
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if ($action === 'check_update') {
    $emcurl = new EmCurl();
    $emcurl->setPost([
        'emkey'     => Option::get('emkey'),
        'version'   => Option::EMLOG_VERSION,
        'timestamp' => Option::EMLOG_VERSION_TIMESTAMP,
    ]);

    $emcurl->request('https://www.emlog.net/service/upgrade');
    $retStatus = $emcurl->getHttpStatus();
    $response = $emcurl->getRespone();
    header('Content-Type: application/json; charset=UTF-8');
    if ($retStatus !== 200) {
        exit('{"result":"fail"}');
    }
    exit($response);
}

if ($action === 'update' && User::isAdmin()) {
    $source = isset($_GET['source']) ? trim($_GET['source']) : '';
    $upsql = isset($_GET['upsql']) ? trim($_GET['upsql']) : '';

    if (empty($source)) {
        exit('error');
    }

    // update files
    //$temp_zip_file = emFetchFile($source);
    if (!$temp_zip_file) {
        exit('error_down');
    }
    $ret = emUnZip($temp_zip_file, '../', 'update');
    switch ($ret) {
        case 1:
        case 2:
            exit('error_dir');
        case 3:
            exit('error_zip');
    }
    @unlink($temp_zip_file);

    // update database
    if ($upsql) {
        $temp_sql_file = emFetchFile($upsql);
        if (!$temp_sql_file) {
            exit('error_down');
        }
        $DB = Database::getInstance();
        $setchar = "ALTER DATABASE `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;";
        $sql = file($temp_sql_file);
        array_unshift($sql, $setchar);
        $query = '';
        foreach ($sql as $value) {
            // 只执行当前版本需要的更新
            if (!empty($value) && $value[0] == '#') {
                preg_match("/#\s(pro\s[\.\d]+)/i", $value, $v);
                $ver = isset($v[1]) ? trim($v[1]) : '';
                if (Option::EMLOG_VERSION > $ver) {
                    break;
                }
            }
            if (!$value || $value[0] == '#') {
                continue;
            }
            $value = str_replace("{db_prefix}", DB_PREFIX, trim($value));
            $query .= $value;
            if (preg_match("/\;$/i", $value)) {
                $DB->query($query, 1);
                $query = '';
            }
        }
        $CACHE->updateCache();
        @unlink($temp_sql_file);
    }
    exit('succ');
}