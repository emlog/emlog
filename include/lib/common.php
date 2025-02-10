<?php

/**
 * Common function library
 * @package EMLOG
 * @link https://www.emlog.net
 */

function emAutoload($class)
{
    $class = strtolower($class);
    if (file_exists(EMLOG_ROOT . '/include/model/' . $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/model/' . $class . '.php');
    } elseif (file_exists(EMLOG_ROOT . '/include/lib/' . $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/lib/' . $class . '.php');
    } elseif (file_exists(EMLOG_ROOT . '/include/controller/' . $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/controller/' . $class . '.php');
    } elseif (file_exists(EMLOG_ROOT . '/include/service/' . $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/service/' . $class . '.php');
    }
}

/**
 * Convert HTML Code
 */
function htmlClean($content, $nl2br = true)
{
    $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
    if ($nl2br) {
        $content = nl2br($content);
    }
    $content = str_replace('  ', '&nbsp;&nbsp;', $content);
    $content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
    return $content;
}

if (!function_exists('getIp')) {
    function getIp()
    {
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = $list[0];
        }
        if (!ip2long($ip)) {
            $ip = '';
        }
        return $ip;
    }
}

if (!function_exists('getUA')) {
    function getUA()
    {
        return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    }
}

/**
 * 获取站点地址(仅限根目录脚本使用,目前仅用于首页ajax请求)
 */
function getBlogUrl()
{
    $phpself = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
    if (preg_match("/^.*\//", $phpself, $matches)) {
        return 'http://' . $_SERVER['HTTP_HOST'] . $matches[0];
    } else {
        return BLOG_URL;
    }
}

/**
 * 获取当前访问的base url
 */
function realUrl()
{
    static $real_url = NULL;
    if ($real_url !== NULL) {
        return $real_url;
    }

    $emlog_path = EMLOG_ROOT . DIRECTORY_SEPARATOR;
    $script_path = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);
    $script_path = str_replace('\\', '/', $script_path);
    $path_element = explode('/', $script_path);

    $this_match = '';
    $best_match = '';
    $current_deep = 0;
    $max_deep = count($path_element);
    while ($current_deep < $max_deep) {
        $this_match = $this_match . $path_element[$current_deep] . DIRECTORY_SEPARATOR;
        if (substr($emlog_path, strlen($this_match) * (-1)) === $this_match) {
            $best_match = $this_match;
        }
        $current_deep++;
    }
    $best_match = str_replace(DIRECTORY_SEPARATOR, '/', $best_match);

    $protocol = 'http://';
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') { // 兼容nginx反向代理的情况
        $protocol = 'https://';
    } elseif (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = 'https://';
    }
    $host = $_SERVER['HTTP_HOST'];
    $real_url = $protocol . $host . $best_match;
    return $real_url;
}


/**
 * 检查插件
 */
function checkPlugin($plugin)
{
    if (is_string($plugin) && preg_match("/^[\w\-\/]+\.php$/", $plugin) && file_exists(EMLOG_ROOT . '/content/plugins/' . $plugin)) {
        return true;
    }

    return false;
}

/**
 * 验证email地址格式
 */
function checkMail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }

    return false;
}

/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings, $start, $length, $dot = '...')
{
    if (function_exists('mb_substr') && function_exists('mb_strlen')) {
        $sub_str = mb_substr($strings, $start, $length, 'UTF-8');
        return mb_strlen($sub_str, 'UTF-8') < mb_strlen($strings, 'UTF-8') ? $sub_str . $dot : $sub_str;
    } else {
        $sub_str = substr($strings, $start, $length);
        return strlen($sub_str) < strlen($strings) ? $sub_str . $dot : $sub_str;
    }
}

/**
 * 从可能包含html标记的内容中萃取纯文本摘要
 */
function extractHtmlData($data, $len)
{
    $data = subString(strip_tags($data), 0, $len + 30);
    $search = array(
        "/([\r\n])[\s]+/", // 去掉空白字符
        "/&(quot|#34);/i", // 替换 HTML 实体
        "/&(amp|#38);/i",
        "/&(lt|#60);/i",
        "/&(gt|#62);/i",
        "/&(nbsp|#160);/i",
        "/&(iexcl|#161);/i",
        "/&(cent|#162);/i",
        "/&(pound|#163);/i",
        "/&(copy|#169);/i",
        "/\"/i",
    );
    $replace = array(" ", "\"", "&", " ", " ", "", chr(161), chr(162), chr(163), chr(169), "");
    $data = trim(subString(preg_replace($search, $replace, $data), 0, $len));
    return $data;
}

/**
 * 转换文件大小单位
 *
 * @param string $fileSize 文件大小 kb
 */
function changeFileSize($fileSize)
{
    if ($fileSize >= 1073741824) {
        $fileSize = round($fileSize / 1073741824, 2) . 'GB';
    } elseif ($fileSize >= 1048576) {
        $fileSize = round($fileSize / 1048576, 2) . 'MB';
    } elseif ($fileSize >= 1024) {
        $fileSize = round($fileSize / 1024, 2) . 'KB';
    } else {
        $fileSize .= '字节';
    }
    return $fileSize;
}

/**
 * 获取文件名后缀
 */
function getFileSuffix($fileName)
{
    return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
}

/**
 * 将相对路径转换为完整URL，eg：../content/uploadfile/xxx.jpeg
 */
function getFileUrl($filePath)
{
    if (stripos($filePath, 'http') === false) {
        return BLOG_URL . substr($filePath, 3);
    }
    return $filePath;
}

/**
 * 去除url的参数
 */
function rmUrlParams($url)
{
    $urlInfo = explode("?", $url);
    if (empty($urlInfo[0])) {
        return $url;
    }
    return $urlInfo[0];
}

function isImage($mimetype)
{
    if (strpos($mimetype, "image") !== false) {
        return true;
    }
    return false;
}

function isVideo($mimetype)
{
    if (strpos($mimetype, "video") !== false) {
        return true;
    }
    return false;
}

function isAudio($fileName)
{
    $suffix = getFileSuffix($fileName);
    return $suffix === 'mp3';
}

function isZip($fileName)
{
    $suffix = getFileSuffix($fileName);
    if (in_array($suffix, ['zip', 'rar', '7z', 'gz'])) {
        return true;
    }
    return false;
}

/**
 * 分页函数
 *
 * @param int $count 条目总数
 * @param int $perlogs 每页显示条数目
 * @param int $page 当前页码
 * @param string $url 页码的地址
 * @return string
 */
function pagination($count, $perlogs, $page, $url, $anchor = '')
{
    $pnums = @ceil($count / $perlogs);
    $re = '';
    $urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|", "", $url);

    $frontContent = '';
    $paginContent = '';
    $endContent = '';
    $circle_a = 1;
    $circle_b = $pnums;
    $neighborNum = 1;
    $minKey = 4;

    if ($pnums == 1)
        return $re;
    if ($page >= 1 && $pnums >= 7) {
        $frontContent .= " <a href=\"$urlHome$anchor\">1</a> ";
        $frontContent .= " <em> ... </em> ";
        $endContent .= " <em> ... </em> ";
        $endContent .= " <a href=\"$url$pnums$anchor\">$pnums</a> ";
        if ($pnums >= 12) {
            $minKey = 7;
            $neighborNum = 3;
        }
        if ($page < $minKey) {
            $circle_b = $minKey;
            $frontContent = '';
        }
        if ($page > ($pnums - $minKey + 1)) {
            $circle_a = $pnums - $minKey + 1;
            $endContent = '';
        }
        if ($page > ($minKey - 1) && $page < ($pnums - $minKey + 2)) {
            $circle_a = $page - $neighborNum;
            $circle_b = $page + $neighborNum;
        }
        if ($page != 1) {
            $frontContent = " <a href=\"$url" . ($page - 1) . "$anchor\" title=\"Previous Page\">&laquo;</a> " . $frontContent;
        }
        if ($page != $pnums) {
            $endContent .= " <a href=\"$url" . ($page + 1) . "$anchor\" title=\"Next Page\">&raquo;</a> ";
        }
    }
    for ($i = $circle_a; $i <= $circle_b; $i++) {
        if ($i == $page) {
            $paginContent .= " <span>$i</span> ";
        } elseif ($i == 1) {
            $paginContent .= " <a href=\"$urlHome$anchor\">$i</a> ";
        } else {
            $paginContent .= " <a href=\"$url$i$anchor\">$i</a> ";
        }
    }
    $re = $frontContent . $paginContent . $endContent;
    return $re;
}

/**
 * 该函数在插件中调用,挂载插件函数到预留的钩子上
 */
function addAction($hook, $actionFunc)
{
    // 通过全局变量来存储挂载点上挂载的插件函数
    global $emHooks;
    if (!isset($emHooks[$hook]) || !in_array($actionFunc, $emHooks[$hook])) {
        $emHooks[$hook][] = $actionFunc;
    }
    return true;
}

/**
 * 挂载执行方式1（插入式挂载）：执行挂在钩子上的函数,支持多参数 eg:doAction('post_comment', $author, $email, $url, $comment);
 * eg：在挂载点插入扩展内容
 */
function doAction($hook)
{
    global $emHooks;
    $args = array_slice(func_get_args(), 1);
    if (isset($emHooks[$hook])) {
        foreach ($emHooks[$hook] as $function) {
            call_user_func_array($function, $args);
        }
    }
}

/**
 * 挂载执行方式2（单次接管式挂载）：执行挂在钩子上的第一个函数,仅执行行一次，接收输入input，且会修改传入的变量$ret
 * eg：接管文件上传函数，将上传本地改为上传云端
 */
function doOnceAction($hook, $input, &$ret)
{
    global $emHooks;
    $args = [$input, &$ret];
    $func = !empty($emHooks[$hook][0]) ? $emHooks[$hook][0] : '';
    if ($func) {
        call_user_func_array($func, $args);
    }
}

/**
 * 挂载执行方式3（轮流接管式挂载）：执行挂在钩子上的所有函数，上一个执行结果作为下一个的输入，且会修改传入的变量$ret
 * eg：不同插件对文章内容进行不同的修改替换。
 */
function doMultiAction($hook, $input, &$ret)
{
    global $emHooks;
    $args = [$input, &$ret];
    if (isset($emHooks[$hook])) {
        foreach ($emHooks[$hook] as $function) {
            call_user_func_array($function, $args);
            $args = [&$ret, &$ret];
        }
    }
}

/**
 * 截取文章内容前len个字符
 */
function subContent($content, $len, $clean = 0)
{
    if ($clean) {
        $content = strip_tags($content);
    }
    return subString($content, 0, $len);
}

/**
 * 时间转化函数
 * @param $timestamp int 时间戳(秒)
 * @param $format
 * @return false|string
 */
function smartDate($timestamp, $format = 'Y-m-d H:i')
{
    $sec = time() - $timestamp;
    if ($sec < 60) {
        $op = $sec . ' 秒前';
    } elseif ($sec < 3600) {
        $op = floor($sec / 60) . " 分钟前";
    } elseif ($sec < 3600 * 24) {
        $op = floor($sec / 3600) . " 小时前";
    } elseif ($sec < 3600 * 24 * 30) {
        $days = floor($sec / (3600 * 24));
        $op = $days . " 天前";
    } elseif ($sec < 3600 * 24 * 365) {
        $months = floor($sec / (3600 * 24 * 30));
        $op = $months . " 个月前";
    } elseif ($sec < 3600 * 24 * 365 * 5) {
        $years = floor($sec / (3600 * 24 * 365));
        $op = $years . " 年前";
    } else {
        $op = date($format, $timestamp);
    }
    return $op;
}

function getRandStr($length = 12, $special_chars = true, $numeric_only = false)
{
    if ($numeric_only) {
        $chars = '0123456789';
    } else {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($special_chars) {
            $chars .= '!@#$%^&*()';
        }
    }
    $randStr = '';
    $chars_length = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $randStr .= substr($chars, em_rand(0, $chars_length - 1), 1);
    }
    return $randStr;
}

function em_rand($min = 0, $max = 0)
{
    if (function_exists('random_int')) {
        try {
            return random_int($min, $max);
        } catch (Exception $e) {
            // 失败时继续使用其他方法
        }
    }
    return mt_rand($min, $max);
}

/**
 * 上传文件到当前服务器
 * @param $attach array 文件FILE信息
 * @param $result array 上传结果
 */
function upload2local($attach, &$result)
{
    $fileName = $attach['name'];
    $tmpFile = $attach['tmp_name'];
    $fileSize = $attach['size'];

    $fileName = Database::getInstance()->escape_string($fileName);

    $ret = upload($fileName, $tmpFile, $fileSize);
    $success = 0;
    switch ($ret) {
        case '105':
            $message = '上传失败。文件上传目录不可写 (content/uploadfile)';
            break;
        default:
            $message = '上传成功';
            $success = 1;
            break;
    }

    $result = [
        'success'   => $success,
        'message'   => $message,
        'url'       => $success ? getFileUrl($ret['file_path']) : '',
        'file_info' => $success ? $ret : [],
    ];
}

/**
 * 文件上传
 *
 * 返回的数组索引
 * mime_type 文件类型
 * size      文件大小(单位KB)
 * file_path 文件路径
 * width     宽度
 * height    高度
 * 可选值（仅在上传文件是图片且系统开启缩略图时起作用）
 * thum_file   缩略图的路径
 *
 * @param string $fileName 文件名
 * @param string $tmpFile 上传后的临时文件
 * @param string $fileSize 文件大小 KB
 * @return array | string 文件数据 索引
 *
 */
function upload($fileName, $tmpFile, $fileSize)
{
    $extension = getFileSuffix($fileName);
    $file_info = [];
    $file_info['file_name'] = $fileName;
    $file_info['mime_type'] = get_mimetype($extension);
    $file_info['size'] = $fileSize;
    $file_info['width'] = 0;
    $file_info['height'] = 0;

    $fileName = substr(md5($fileName), 0, 4) . time() . '.' . $extension;

    // 读取、写入文件使用绝对路径，兼容API文件上传
    $uploadFullPath = Option::UPLOADFILE_FULL_PATH . gmdate('Ym') . '/';
    $uploadFullFile = $uploadFullPath . $fileName;
    $thumFullFile = $uploadFullPath . 'thum-' . $fileName;

    // 输出文件信息使用相对路径，兼容头像上传等业务场景
    $uploadPath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
    $uploadFile = $uploadPath . $fileName;
    $thumFile = $uploadPath . 'thum-' . $fileName;

    $file_info['file_path'] = $uploadFile;

    if (!createDirectoryIfNeeded($uploadFullPath)) {
        return '105'; // 创建上传目录失败
    }

    doAction('attach_upload', $tmpFile);

    // 生成缩略图
    $is_thumbnail = Option::get('isthumbnail') === 'y';
    if ($is_thumbnail && resizeImage($tmpFile, $thumFullFile, Option::get('att_imgmaxw'), Option::get('att_imgmaxh'))) {
        $file_info['thum_file'] = $thumFile;
    }

    // 完成上传
    if (@is_uploaded_file($tmpFile) && @!move_uploaded_file($tmpFile, $uploadFullFile)) {
        @unlink($tmpFile);
        return '105'; //上传失败。上传目录不可写
    }

    // 提取图片宽高
    if (in_array($file_info['mime_type'], array('image/jpeg', 'image/png', 'image/gif', 'image/bmp'))) {
        $size = getimagesize($uploadFullFile);
        if ($size) {
            $file_info['width'] = $size[0];
            $file_info['height'] = $size[1];
        }
    }
    return $file_info;
}

function createDirectoryIfNeeded($path)
{
    if (!is_dir($path)) {
        if (!mkdir($path, 0777, true) && !is_dir($path)) {
            return false;
        }
    }
    return true;
}

/**
 * 图片生成缩略图
 *
 * @param string $img 预缩略的图片
 * @param string $thum_path 生成缩略图路径
 * @param int $max_w 缩略图最大宽度 px
 * @param int $max_h 缩略图最大高度 px
 * @return bool
 */
function resizeImage($img, $thum_path, $max_w, $max_h)
{
    if (!in_array(getFileSuffix($thum_path), array('jpg', 'png', 'jpeg', 'gif'))) {
        return false;
    }
    if (!function_exists('ImageCreate')) {
        return false;
    }

    $size = chImageSize($img, $max_w, $max_h);
    $newwidth = $size['w'];
    $newheight = $size['h'];
    $w = $size['rc_w'];
    $h = $size['rc_h'];
    if ($w <= $max_w && $h <= $max_h) {
        return false;
    }
    return imageCropAndResize($img, $thum_path, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
}

/**
 * 裁剪、缩放图片
 *
 * @param string $src_image 原始图
 * @param string $dst_path 裁剪后的图片保存路径
 * @param int $dst_x 新图坐标x
 * @param int $dst_y 新图坐标y
 * @param int $src_x 原图坐标x
 * @param int $src_y 原图坐标y
 * @param int $dst_w 新图宽度
 * @param int $dst_h 新图高度
 * @param int $src_w 原图宽度
 * @param int $src_h 原图高度
 */
function imageCropAndResize($src_image, $dst_path, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)
{
    if (!function_exists('imagecreatefromstring')) {
        return false;
    }

    $src_img = imagecreatefromstring(file_get_contents($src_image));
    if (!$src_img) {
        return false;
    }

    if (function_exists('imagecopyresampled')) {
        $new_img = imagecreatetruecolor($dst_w, $dst_h);
        imagecopyresampled($new_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
    } elseif (function_exists('imagecopyresized')) {
        $new_img = imagecreate($dst_w, $dst_h);
        imagecopyresized($new_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
    } else {
        return false;
    }

    switch (getFileSuffix($dst_path)) {
        case 'png':
            if (function_exists('imagepng') && imagepng($new_img, $dst_path)) {
                ImageDestroy($new_img);
                return true;
            }
            return false;
        case 'jpg':
        default:
            if (function_exists('imagejpeg') && imagejpeg($new_img, $dst_path)) {
                ImageDestroy($new_img);
                return true;
            }
            return false;
        case 'gif':
            if (function_exists('imagegif') && imagegif($new_img, $dst_path)) {
                ImageDestroy($new_img);
                return true;
            }
            return false;
    }
}

/**
 * 按比例计算图片缩放尺寸
 *
 * @param string $img 图片路径
 * @param int $max_w 最大缩放宽
 * @param int $max_h 最大缩放高
 * @return array
 */
function chImageSize($img, $max_w, $max_h)
{
    $size = @getimagesize($img);
    if (!$size) {
        return [];
    }
    $w = $size[0];
    $h = $size[1];
    //计算缩放比例
    @$w_ratio = $max_w / $w;
    @$h_ratio = $max_h / $h;
    //决定处理后的图片宽和高
    if (($w <= $max_w) && ($h <= $max_h)) {
        $tn['w'] = $w;
        $tn['h'] = $h;
    } else if (($w_ratio * $h) < $max_h) {
        $tn['h'] = ceil($w_ratio * $h);
        $tn['w'] = $max_w;
    } else {
        $tn['w'] = ceil($h_ratio * $w);
        $tn['h'] = $max_h;
    }
    $tn['rc_w'] = $w;
    $tn['rc_h'] = $h;
    return $tn;
}

/**
 * 获取Gravatar头像
 */
if (!function_exists('getGravatar')) {
    function getGravatar($email, $s = 120)
    {
        $hash = md5($email);
        $gravatar_url = "//cravatar.cn/avatar/$hash?s=$s";
        doOnceAction('get_Gravatar', $email, $gravatar_url);

        return $gravatar_url;
    }
}

/**
 * 获取指定月份的天数
 * @param $month string 月份 01-12
 * @param $year string 年份 0000
 * @return false|string
 */
function getMonthDayNum($month, $year)
{
    return date("t", strtotime($year . $month . '01'));
}

/**
 * 解压zip
 * @param string $zipfile 要解压的文件
 * @param string $path 解压到该目录
 * @param string $type
 * @return int
 */
function emUnZip($zipfile, $path, $type = 'tpl')
{
    if (!class_exists('ZipArchive', FALSE)) {
        return 3; //zip模块问题
    }
    $zip = new ZipArchive();
    if (@$zip->open($zipfile) !== TRUE) {
        return 2; //文件权限问题
    }
    $r = explode('/', $zip->getNameIndex(0), 2);
    $dir = isset($r[0]) ? $r[0] . '/' : '';
    switch ($type) {
        case 'tpl':
            $re = $zip->getFromName($dir . 'header.php');
            if (false === $re) {
                return -2;
            }
            break;
        case 'plugin':
            $plugin_name = substr($dir, 0, -1);
            $re = $zip->getFromName($dir . $plugin_name . '.php');
            if (false === $re) {
                return -1;
            }
            break;
        case 'backup':
            $sql_name = substr($dir, 0, -1);
            if (getFileSuffix($sql_name) != 'sql') {
                return -3;
            }
            break;
        case 'update':
            break;
    }
    if (true === @$zip->extractTo($path)) {
        $zip->close();
        return 0;
    }

    return 1; //文件权限问题
}

/**
 * Zip compression
 */
function emZip($orig_fname, $content)
{
    if (!class_exists('ZipArchive', FALSE)) {
        return false;
    }
    $zip = new ZipArchive();
    $tempzip = EMLOG_ROOT . '/content/cache/emtemp.zip';
    $res = $zip->open($tempzip, ZipArchive::CREATE);
    if ($res === TRUE) {
        $zip->addFromString($orig_fname, $content);
        $zip->close();
        $zip_content = file_get_contents($tempzip);
        unlink($tempzip);
        return $zip_content;
    }

    return false;
}

/**
 * Download remote files
 * @param string $source file url
 * @return string Temporary file path
 */
function emFetchFile($source)
{
    $temp_file = tempnam(EMLOG_ROOT . '/content/cache/', 'tmp_');
    $wh = fopen($temp_file, 'w+b');

    $ctx_opt = set_ctx_option();
    $ctx = stream_context_create($ctx_opt);
    $rh = @fopen($source, 'rb', false, $ctx);

    if (!$rh || !$wh) {
        return FALSE;
    }

    while (!feof($rh)) {
        if (fwrite($wh, fread($rh, 4096)) === FALSE) {
            return FALSE;
        }
    }
    fclose($rh);
    fclose($wh);
    return $temp_file;
}

/**
 * Download remote files
 * @param string $source file url
 * @return string Temporary file path
 */
function emDownFile($source)
{
    $ctx_opt = set_ctx_option();
    $context = stream_context_create($ctx_opt);
    $content = file_get_contents($source, false, $context);
    if ($content === false) {
        return false;
    }

    $temp_file = tempnam(EMLOG_ROOT . '/content/cache/', 'tmp_');
    if ($temp_file === false) {
        emMsg('emDownFile：Failed to create temporary file.');
    }
    $ret = file_put_contents($temp_file, $content);
    if ($ret === false) {
        emMsg('emDownFile：Failed to write temporary file.');
    }

    return $temp_file;
}

function set_ctx_option()
{
    $emkey = Option::get('emkey');
    return [
        'http' => [
            'timeout' => 120,
            'method'  => 'GET',
            'header'  => "Referer: " . BLOG_URL . "\r\n"
                . "Emkey: " . $emkey . "\r\n"
                . "User-Agent: emlog " . Option::EMLOG_VERSION . "\r\n",
        ],
        "ssl"  => [
            "verify_peer"      => false,
            "verify_peer_name" => false,
        ]
    ];
}

/**
 * 删除文件或目录
 */
function emDeleteFile($file)
{
    if (empty($file)) {
        return false;
    }
    if (@is_file($file)) {
        return @unlink($file);
    }
    $ret = true;
    if ($handle = @opendir($file)) {
        while ($filename = @readdir($handle)) {
            if ($filename == '.' || $filename == '..') {
                continue;
            }
            if (!emDeleteFile($file . '/' . $filename)) {
                $ret = false;
            }
        }
    } else {
        $ret = false;
    }
    @closedir($handle);
    if (file_exists($file) && !rmdir($file)) {
        $ret = false;
    }
    return $ret;
}

/**
 * 页面跳转
 */
function emDirect($directUrl)
{
    header("Location: $directUrl");
    exit;
}

/**
 * 显示系统信息
 *
 * @param string $msg 信息
 * @param string $url 返回地址
 * @param boolean $isAutoGo 是否自动返回 true false
 */
function emMsg($msg, $url = 'javascript:history.back(-1);', $isAutoGo = false)
{
    if ($msg == '404') {
        header("HTTP/1.1 404 Not Found");
        $msg = '抱歉，你所请求的页面不存在！';
    }
    echo <<<EOT
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="applicable-device" content="pc,mobile">
EOT;
    if ($isAutoGo) {
        echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
    }
    echo <<<EOT
<title>提示信息</title>
<style>
body {
    background-color:#f8f9fc;
    font-family: Arial;
    font-size: 12px;
    line-height:150%;
}
.main {
    background-color: #ffffff;
    font-size: 14px;
    color: #333333;
    width: 650px;
    margin: 80px auto 0;
    border-radius: 8px;
    padding: 20px;
    list-style: none;
    border: 1px solid #e8e8e8;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    line-height: 1.5;
    transition: all 0.3s ease;
}

.main p {
    margin: 16px 0;
    color: #444444;
}

.main a {
    color: #1890ff;
    text-decoration: none;
    transition: color 0.3s;
}

.main a:hover {
    color: #40a9ff;
    text-decoration: underline;
}
.main p {
    line-height: 18px;
    margin: 10px 20px;
}
a {
    color: #333333;
}
@media (max-width: 768px) {
    .main{
        width: unset;   
    }
}
</style>
</head>
<body>
<div class="main">
<p>🚫 $msg</p>
EOT;
    if ($url != 'none') {
        echo '<p><a href="' . $url . '">&larr; 点击返回</a></p>';
    }
    echo <<<EOT
</div>
</body>
</html>
EOT;
    exit;
}

function show_404_page($show_404_only = false)
{
    doAction('page_not_found');
    if ($show_404_only) {
        header("HTTP/1.1 404 Not Found");
        exit;
    }

    if (is_file(TEMPLATE_PATH . '404.php')) {
        header("HTTP/1.1 404 Not Found");
        include View::getView('404');
        exit;
    }

    emMsg('404', BLOG_URL);
}

/**
 * hmac 加密
 *
 * @param unknown_type $algo hash算法 md5
 * @param unknown_type $data 用户名和到期时间
 * @param unknown_type $key
 * @return unknown
 */
if (!function_exists('hash_hmac')) {
    function hash_hmac($algo, $data, $key)
    {
        $packs = array('md5' => 'H32', 'sha1' => 'H40');

        if (!isset($packs[$algo])) {
            return false;
        }

        $pack = $packs[$algo];

        if (strlen($key) > 64) {
            $key = pack($pack, $algo($key));
        } elseif (strlen($key) < 64) {
            $key = str_pad($key, 64, chr(0));
        }

        $ipad = (substr($key, 0, 64) ^ str_repeat(chr(0x36), 64));
        $opad = (substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64));

        return $algo($opad . pack($pack, $algo($ipad . $data)));
    }
}

/**
 * 根据文件后缀获取其mine类型
 */
function get_mimetype($extension)
{
    $ct['txt'] = 'text/plain';
    $ct['asc'] = 'text/plain';
    $ct['css'] = 'text/css';
    $ct['htm'] = 'text/html';
    $ct['html'] = 'text/html';
    $ct['js'] = 'application/x-javascript';
    $ct['xhtml'] = 'application/xhtml+xml';
    $ct['xml'] = 'text/xml';
    $ct['xsl'] = 'text/xml';
    $ct['wml'] = 'text/vnd.wap.wml';
    $ct['wmls'] = 'text/vnd.wap.wmlscript';
    $ct['rtf'] = 'text/rtf';
    $ct['bmp'] = 'image/bmp';
    $ct['gif'] = 'image/gif';
    $ct['jpeg'] = 'image/jpeg';
    $ct['jpg'] = 'image/jpeg';
    $ct['jpe'] = 'image/jpeg';
    $ct['png'] = 'image/png';
    $ct['webp'] = 'image/webp';
    $ct['svg'] = 'image/svg+xml';
    $ct['avif'] = 'image/avif';
    $ct['tiff'] = 'image/tiff';
    $ct['tif'] = 'image/tiff';
    $ct['ico'] = 'image/vnd.microsoft.icon';
    $ct['midi'] = 'audio/midi';
    $ct['mid'] = 'audio/midi';
    $ct['mp3'] = 'audio/mpeg';
    $ct['wav'] = 'audio/x-wav';
    $ct['mpg'] = 'video/mpeg';
    $ct['mpeg'] = 'video/mpeg';
    $ct['mpe'] = 'video/mpeg';
    $ct['qt'] = 'video/quicktime';
    $ct['webm'] = 'video/webm';
    $ct['mov'] = 'video/quicktime';
    $ct['avi'] = 'video/x-msvideo';
    $ct['wmv'] = 'video/x-ms-wmv';
    $ct['mp4'] = 'video/mp4';
    $ct['mkv'] = 'video/x-matroska';
    $ct['bin'] = 'application/octet-stream';
    $ct['class'] = 'application/octet-stream';
    $ct['dll'] = 'application/octet-stream';
    $ct['dvi'] = 'application/x-dvi';
    $ct['exe'] = 'application/octet-stream';
    $ct['gtar'] = 'application/x-gtar';
    $ct['gzip'] = 'application/x-gzip';
    $ct['pdf'] = 'application/pdf';
    $ct['doc'] = 'application/msword';
    $ct['ppt'] = 'application/vnd.ms-powerpoint';
    $ct['wbxml'] = 'application/vnd.wap.wbxml';
    $ct['wmlc'] = 'application/vnd.wap.wmlc';
    $ct['wmlsc'] = 'application/vnd.wap.wmlscriptc';
    $ct['xls'] = 'application/vnd.ms-excel';
    $ct['zip'] = 'application/zip';

    return isset($ct[strtolower($extension)]) ? $ct[strtolower($extension)] : 'text/html';
}

/**
 * 将字符串转换为时区无关的UNIX时间戳
 */
function emStrtotime($timeStr)
{
    if (!$timeStr) {
        return false;
    }

    $timezone = Option::get('timezone');

    $unixPostDate = strtotime($timeStr);
    if (!$unixPostDate) {
        return false;
    }

    $serverTimeZone = date_default_timezone_get();
    if (empty($serverTimeZone) || $serverTimeZone == 'UTC') {
        $unixPostDate -= (int)$timezone * 3600;
    } elseif ($serverTimeZone) {
        /*
         * 如果服务器配置默认了时区，那么PHP将会把传入的时间识别为时区当地时间
         * 但是我们传入的时间实际是blog配置的时区的当地时间，并不是服务器时区的当地时间
         * 因此，我们需要将strtotime得到的时间去掉/加上两个时区的时差，得到utc时间
         */
        $offset = getTimeZoneOffset($serverTimeZone);
        // 首先减去/加上本地时区配置的时差
        $unixPostDate -= (int)$timezone * 3600;
        // 再减去/加上服务器时区与utc的时差，得到utc时间
        $unixPostDate -= $offset;
    }
    return $unixPostDate;
}

/**
 * 加载jQuery
 */
function emLoadJQuery()
{
    static $isJQueryLoaded = false;
    if (!$isJQueryLoaded) {
        global $emHooks;
        if (!isset($emHooks['index_head'])) {
            $emHooks['index_head'] = array();
        }
        array_unshift($emHooks['index_head'], 'loadJQuery');
        $isJQueryLoaded = true;

        function loadJQuery()
        {
            echo '<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>';
        }
    }
}

/**
 * 计算时区的时差
 * @param string $remote_tz 远程时区
 * @param string $origin_tz 标准时区
 *
 * @throws Exception
 */
function getTimeZoneOffset($remote_tz, $origin_tz = 'UTC')
{
    if (($origin_tz === null) && !is_string($origin_tz = date_default_timezone_get())) {
        return false; // A UTC timestamp was returned -- bail out!
    }
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime('now', $origin_dtz);
    $remote_dt = new DateTime('now', $remote_dtz);
    return $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
}

/**
 * Upload the cut pictures (cover and avatar)
 */
function uploadCropImg()
{
    $attach = isset($_FILES['image']) ? $_FILES['image'] : '';

    $uploadCheckResult = Media::checkUpload($attach);
    if ($uploadCheckResult !== true) {
        Output::error($uploadCheckResult);
    }

    $ret = '';
    upload2local($attach, $ret);
    if (empty($ret['success'])) {
        Output::error($ret['message']);
    }
    return $ret;
}

if (!function_exists('split')) {
    function split($str, $delimiter)
    {
        return preg_split($str, $delimiter);
    }
}

if (!function_exists('get_os')) {
    function get_os($user_agent)
    {
        if (false !== stripos($user_agent, "win")) {
            $os = 'Windows';
        } else if (false !== stripos($user_agent, "mac")) {
            $os = 'MAC';
        } else if (false !== stripos($user_agent, "linux")) {
            $os = 'Linux';
        } else if (false !== stripos($user_agent, "unix")) {
            $os = 'Unix';
        } else if (false !== stripos($user_agent, "bsd")) {
            $os = 'BSD';
        } else {
            $os = 'unknown';
        }
        return $os;
    }
}

if (!function_exists('get_browse')) {
    function get_browse($user_agent)
    {
        if (false !== stripos($user_agent, "MSIE")) {
            $br = 'MSIE';
        } else if (false !== stripos($user_agent, "Edg")) {
            $br = 'Edge';
        } else if (false !== stripos($user_agent, "Firefox")) {
            $br = 'Firefox';
        } else if (false !== stripos($user_agent, "Chrome")) {
            $br = 'Chrome';
        } else if (false !== stripos($user_agent, "Safari")) {
            $br = 'Safari';
        } else if (false !== stripos($user_agent, "Opera")) {
            $br = 'Opera';
        } else {
            $br = 'unknown';
        }
        return $br;
    }
}

// 获取内容中的第一张图片
if (!function_exists('getFirstImage')) {
    function getFirstImage($content)
    {
        // 匹配 Markdown 中的图片
        preg_match('/!\[.*?\]\((.*?)\)/', $content, $matches);

        if (!empty($matches[1])) {
            return $matches[1];
        }

        // 匹配 HTML 中的图片
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $imgNode = $xpath->query('//img')->item(0);

        if ($imgNode) {
            return $imgNode->getAttribute('src');
        }

        return null;
    }
}

// 检查PHP是否支持GD图形库
function checkGDSupport()
{
    if (function_exists("gd_info") && function_exists('imagepng')) {
        return true;
    } else {
        return false;
    }
}
