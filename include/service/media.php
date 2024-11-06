<?php

/**
 * Service: Media
 *
 * @package EMLOG
 * @link https://www.emlog.net
 */

class Media
{

    static function checkUpload($attach)
    {
        if (!$attach) {
            return '上传失败，未收到文件信息，可更换浏览器重试';
        }
        $fileName = $attach['name'];
        $errorNum = $attach['error'];
        $fileSize = $attach['size'];
        $extension = getFileSuffix($fileName);

        if ($errorNum == 1) {
            return '文件大小超过PHP' . ini_get('upload_max_filesize') . '限制';
        }

        if ($errorNum > 1) {
            return '上传失败,错误码：' . $errorNum;
        }

        // 检查类型和大小限制
        $attType = User::haveEditPermission() ? Option::getAdminAttType() : Option::getAttType();
        $maxSize = User::haveEditPermission() ? Option::getAdminAttMaxSize() : Option::getAttMaxSize();
        if (!in_array($extension, $attType)) {
            return '不能上传该类型文件';
        }
        if ($fileSize > $maxSize) {
            return '文件太大了，系统限制上传：' . changeFileSize($maxSize);
        }
        return true;
    }

    static function uploadRespond($ret, $isEditor, $isSuccess = false)
    {
        if ($isEditor) {
            exit(json_encode($ret));
        } else {
            if ($isSuccess) {
                header("HTTP/1.0 200 OK");
                exit($ret['message']);
            }
            header("HTTP/1.0 400 Bad Request");
            exit($ret['message']);
        }
    }
}
