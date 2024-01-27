<?php
/*
Plugin Name: 图片本地化
Version: v1.2
Plugin URL:
Author:
Description: 保存日志时将日志中的远程图片本地化
Author URL:

*/
header('content-Type: text/html; charset=utf-8');
addAction('save_log', 'img2local');
define('BASE_PATH', str_replace('\\', '/', realpath(EMLOG_ROOT . '/')) . "/");

function img2local($logid) {
    global $logData;
    $Log_Model = new Log_Model();
    $isImg2local = isset($_POST['img2local']) ? trim($_POST['img2local']) : '';
    if (!$isImg2local) {
        return;
    }
    $logData['content'] = stripslashes($logData['content']);
    $logData['excerpt'] = stripslashes($logData['excerpt']);
    $logData['content'] = preg_replace_callback("/<img([^>]+)src=\"([^>\"]+)\"?([^>]*)>/i", "image2local", $logData['content']);
    $logData['excerpt'] = preg_replace_callback("/<img([^>]+)src=\"([^>\"]+)\"?([^>]*)>/i", "image2local", $logData['excerpt']);
    $logData['content'] = addslashes($logData['content']);
    $logData['excerpt'] = addslashes($logData['excerpt']);
    $Log_Model->updateLog($logData, $logid);
}

function image2local($matches) {
    $url = $matches[2];
    $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    $content = curl_exec($ch);

    $curlinfo = curl_getinfo($ch);
    print_r($curlinfo);

    curl_close($ch);
    $host = $_SERVER['HTTP_HOST'];
    $urlhost = parse_url($curlinfo['url']);
    if ($curlinfo['http_code'] == 200 && isset($urlhost) && $urlhost != $host) {

        if ($curlinfo['content_type'] == 'image/jpeg') {
            $exf = '.jpg';
        } else if ($curlinfo['content_type'] == 'image/png') {
            $exf = '.png';
        } else if ($curlinfo['content_type'] == 'image/gif') {
            $exf = '.gif';
        }

        $array = explode("/", $curlinfo['url']);
        global $blogid;
        $DB = MySql::getInstance();
        $images_name = array_slice($array, -1, 1);
        $fname = $images_name[0];
        $sql = "SELECT * FROM " . DB_PREFIX . "attachment WHERE filename='$fname' AND blogid=$blogid";
        $row = $DB->once_fetch_array($sql);
        if (!$row) {
            $uppath = BASE_PATH . "content/uploadfile/" . gmdate('Ym') . "/";

            $imgUrl = BLOG_URL . 'content/uploadfile/' . gmdate('Ym') . "/" . $fname;
            $imgUrl1 = Option::UPLOADFILE_PATH . gmdate('Ym') . "/" . $fname;
            $attachpath = $uppath . $fname;
            if (!is_dir($uppath)) {
                umask(0);
                $ret = @mkdir($uppath, 0777);
                if ($ret === false) {
                    emMsg('创建文件上传目录失败', "javascript:history.go(-1);");
                }
            }
            if (!is_dir($uppath)) {
                umask(0);
                $ret = @mkdir($uppath, 0777);
                if ($ret === false) {
                    emMsg('上传失败。文件上传目录(content/uploadfile)不可写', "javascript:history.go(-1);");
                }
            }

            $content = file_get_contents($url);

            file_put_contents($attachpath, $content);
            $imgLength = filesize($attachpath);
            $sql = "INSERT INTO " . DB_PREFIX . "attachment (blogid,filename,filesize,filepath,addtime) values ($blogid,'" . $images_name[0] . "','" . $imgLength . "','" . $imgUrl1 . "','" . time() . "')";
            $DB->query($sql);
            $DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum+1 WHERE gid=$blogid");

        } else {
            $attachpath = $row['filepath'];
            $imgUrl = BLOG_URL . substr($attachpath, 3);
        }
        return "<img{$matches[1]}src=\"{$imgUrl}\"{$matches[3]}>";
    } else {
        return "<img{$matches[1]}src=\"{$matches[2]}\"{$matches[3]}>";
    }

}

function img2local_option() {
    ?>
    <input type="checkbox" value="1" name="img2local" checked="checked"/> 图片本地化
    <?php
}

addAction('adm_writelog_head', 'img2local_option');
