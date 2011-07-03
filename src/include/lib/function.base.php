<?php
/**
 * 基础函数库
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

function __autoload($class) {
	$class = strtolower($class);
    if (file_exists(EMLOG_ROOT . '/include/model/'. $class . '.php')) {
    	require_once(EMLOG_ROOT . '/include/model/'. $class . '.php');
    } elseif (file_exists(EMLOG_ROOT . '/include/lib/'. $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/lib/'. $class . '.php');
    } elseif (file_exists(EMLOG_ROOT . '/include/controller/'. $class . '.php')) {
        require_once(EMLOG_ROOT . '/include/controller/'. $class . '.php');
    } else{
    	emMsg($class.'加载失败。', BLOG_URL);
    }
}

/**
 * 去除多余的转义字符
 */
function doStripslashes(){
	if (get_magic_quotes_gpc()){
		$_GET = stripslashesDeep($_GET);
		$_POST = stripslashesDeep($_POST);
		$_COOKIE = stripslashesDeep($_COOKIE);
		$_REQUEST = stripslashesDeep($_REQUEST);
	}
}

/**
 * 递归去除转义字符
 */
function stripslashesDeep($value){
	$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
	return $value;
}

/**
 * 转换HTML代码函数
 *
 * @param unknown_type $content
 * @param unknown_type $wrap 是否换行
 */
function htmlClean($content, $wrap=true){
	$content = htmlspecialchars($content);
	if($wrap){
		$content = str_replace("\n", '<br />', $content);
	}
	$content = str_replace('  ', '&nbsp;&nbsp;', $content);
	$content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
	return $content;
}

/**
 * 获取用户ip地址
 */
function getIp(){
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if(!preg_match("/^\d+\.\d+\.\d+\.\d+$/", $ip)){
		$ip = '';
	}
	return $ip;
}

/**
 * 获取博客地址(仅限根目录脚本使用,目前仅用于首页ajax请求)
 */
function getBlogUrl(){
	$phpself = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
	if(preg_match("/^.*\//", $phpself, $matches)){
		return 'http://'.$_SERVER['HTTP_HOST'].$matches[0];
	}else{
		return BLOG_URL;
	}
}

/**
 * 检查插件
 */
function checkPlugin($plugin) {
    if (is_string($plugin) && preg_match("/^[\w\-\/]+\.php$/", $plugin) && file_exists(EMLOG_ROOT . '/content/plugins/' . $plugin)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 验证email地址格式
 */
function checkMail($email){
	if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && strlen($email) <= 60){
		return true;
	} else {
		return false;
	}
}

/**
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
 */
function subString($strings,$start,$length){
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0; $i < strlen($str); $i++){
		if (ord($str[$i]) >= 128)
		$char++;
	}
	$str2 = substr($strings, $start, $length+1);
	$str3 = substr($strings, $start, $length+2);
	if ($char % 3 == 1){
		if ($length <= strlen($strings)){
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char%3 == 2){
		if ($length <= strlen($strings)){
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char%3 == 0){
		if ($length <= strlen($strings)){
			$str = $str .= '...';
		}
		return $str;
	}
}

/**
 * 从可能包含html标记的内容中萃取纯文本摘要
 *
 * @param string $data
 * @param int $len
 */
function extractHtmlData($data, $len) {
	$data = strip_tags(subString($data, 0, $len + 30));
	$search = array ("/([\r\n])[\s]+/",	// 去掉空白字符
		             "/&(quot|#34);/i",	// 替换 HTML 实体
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
	$replace = array (" ","\"","&"," "," ","",chr(161),chr(162),chr(163),chr(169), "");
	$data = subString(preg_replace($search, $replace, $data), 0, $len);
	return $data;
}

/**
 * 转换附件大小单位
 *
 * @param string $fileSize 文件大小 kb
 */
function changeFileSize($fileSize){
	if($fileSize >= 1073741824){
		$fileSize = round($fileSize / 1073741824  ,2) . 'GB';
	} elseif($fileSize >= 1048576){
		$fileSize = round($fileSize / 1048576 ,2) . 'MB';
	} elseif($fileSize >= 1024){
		$fileSize = round($fileSize / 1024, 2) . 'KB';
	} else{
		$fileSize = $fileSize . '字节';
	}
	return $fileSize;
}

/**
 * 获取文件后缀
 * @param string $fileName
 */
function getFileSuffix($fileName) { 
	return strtolower(substr(strrchr($fileName, "."),1));
}

/**
 * 分页函数
 *
 * @param int $count 条目总数
 * @param int $perlogs 每页显示条数目
 * @param int $page 当前页码
 * @param string $url 页码的地址
 */
function pagination($count,$perlogs,$page,$url){
	$pnums = @ceil($count / $perlogs);
	$re = '';
	for ($i = $page-5;$i <= $page+5 && $i <= $pnums; $i++){
		if ($i > 0){
			if ($i == $page){
				$re .= " <span>$i</span> ";
			} else {
				$re .= " <a href=\"".Url::page($url, $i)."\">$i</a> ";
			}
		}
	}
	if ($page > 6) $re = "<a href=\"".Url::page($url, 1)."\" title=\"首页\">&laquo;</a><em>...</em>$re";
	if ($page + 5 < $pnums) $re .= "<em>...</em> <a href=\"".Url::page($url, $pnums)."\" title=\"尾页\">&raquo;</a>";
	if ($pnums <= 1) $re = '';
	return $re;
}

/**
 * 该函数在插件中调用,挂载插件函数到预留的钩子上
 *
 * @param string $hook
 * @param string $actionFunc
 * @return boolearn
 */
function addAction($hook, $actionFunc){
	global $emHooks;
	if (!@in_array($actionFunc, $emHooks[$hook])){
		$emHooks[$hook][] = $actionFunc;
	}
	return true;
}

/**
 * 执行挂在钩子上的函数,支持多参数 eg:doAction('post_comment', $author, $email, $url, $comment);
 *
 * @param string $hook
 */
function doAction($hook){
	global $emHooks;
	$args = array_slice(func_get_args(), 1);
	if (isset($emHooks[$hook])){
		foreach ($emHooks[$hook] as $function){
			$string = call_user_func_array($function, $args);
		}
	}
}

/**
 * 日志分割
 *
 * @param string $content 日志内容
 * @param int $lid 日志id
 */
function breakLog($content,$lid){
	$a = explode('[break]',$content,2);
	if(!empty($a[1]))
	$a[0].='<p id="readmore"><a href="'.Url::log($lid).'">阅读全文&gt;&gt;</a></p>';
	return $a[0];
}

/**
 * 删除[break]标签
 *
 * @param string $content 日志内容
 */
function rmBreak($content){
	$content = str_replace('[break]','',$content);
	return $content;
}

/**
 * 时间转化函数
 *
 * @param $now
 * @param $datetemp
 * @param $dstr
 * @return string
 */
function smartDate($datetemp, $dstr='Y-m-d H:i'){
	$timezone = Option::get('timezone');
	$op = '';
	$sec = time() - $datetemp;
	$hover = floor($sec / 3600);
	if ($hover == 0){
		$min = floor($sec / 60);
		if ( $min == 0) {
			$op = $sec.' 秒前';
		} else {
			$op = "$min 分钟前";
		}
	} elseif ($hover < 24){
		$op = "约 {$hover} 小时前";
	} else {
		$op = gmdate($dstr, $datetemp + $timezone * 3600);
	}
	return $op;
}

/**
 * 生成一个随机的字符串
 *
 * @param int $length
 * @param boolean $special_chars
 * @return string
 */
function getRandStr($length = 12, $special_chars = true){
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ( $special_chars ){
		$chars .= '!@#$%^&*()';
	}
	$randStr = '';
	for ( $i = 0; $i < $length; $i++ ){
		$randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $randStr;
}

/**
 * 寻找两数组所有不同元素
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function findArray($array1,$array2){
    $r1 = array_diff($array1, $array2);
    $r2 = array_diff($array2, $array1);
    $r = array_merge($r1, $r2);
    return $r;
}

/**
 * 文件上传
 *
 * @param string $fileName 文件名
 * @param string $errorNum 错误码：$_FILES['error']
 * @param string $tmpFile 上传后的临时文件
 * @param string $fileSize 文件大小 KB
 * @param array $type 允许上传的文件类型
 * @param boolean $isIcon 是否为上传头像
 * @param boolean $is_thumbnail 是否生成缩略图
 * @return string 文件路径
 */
function uploadFile($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon=false, $is_thumbnail=Option::IS_THUMBNAIL){
	if ($errorNum == 1){
		formMsg('文件大小超过系统'.ini_get('upload_max_filesize').'限制', 'javascript:history.go(-1);', 0);
	}elseif ($errorNum > 1){
		formMsg('上传文件失败,错误码：'.$errorNum, 'javascript:history.go(-1);', 0);
	}
	$extension  = getFileSuffix($fileName);
	if (!in_array($extension, $type)){
		formMsg('错误的文件类型',"javascript:history.go(-1);",0);
	}
	if ($fileSize > Option::UPLOADFILE_MAXSIZE){
		$ret = changeFileSize(Option::UPLOADFILE_MAXSIZE);
		formMsg("文件大小超出{$ret}的限制","javascript:history.go(-1);",0);
	}
	$uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
	$fname = md5($fileName) . gmdate('YmdHis') .'.'. $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir(Option::UPLOADFILE_PATH)){
		umask(0);
		$ret = @mkdir(Option::UPLOADFILE_PATH, 0777);
		if ($ret === false){
			formMsg('创建文件上传目录失败', "javascript:history.go(-1);", 0);
		}
	}
	if (!is_dir($uppath)){
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false){
			formMsg('上传失败。文件上传目录(content/uploadfile)不可写',"javascript:history.go(-1);",0);
		}
	}
	doAction('attach_upload', $tmpFile);

	//resizeImage
	$thum = $uppath . 'thum-' . $fname;
	$attach = $attachpath;
	if ($is_thumbnail) {
	    if ($isIcon && resizeImage($tmpFile, $thum, Option::ICON_MAX_W, Option::ICON_MAX_H)) {
	        $attach = $thum;
	        resizeImage($tmpFile, $uppath.'thum52-'. $fname, 52, 52);
	    } elseif (resizeImage($tmpFile, $thum, Option::IMG_MAX_W, Option::IMG_MAX_H)){
	        $attach = $thum;
	    }
	}

	if (@is_uploaded_file($tmpFile)){
		if (@!move_uploaded_file($tmpFile ,$attachpath)){
			@unlink($tmpFile);
			formMsg('上传失败。文件上传目录(content/uploadfile)不可写',"javascript:history.go(-1);",0);
		}
		chmod($attachpath, 0777);
	}
	return 	$attach;
}

/**
 * 图片生成缩略图
 *
 * @param string $img 预缩略的图片
 * @param string $thum_path 生成缩略图路径
 * @param int $max_w 缩略图最大宽度 px
 * @param int $max_h 缩略图最大高度 px
 * @return unknown
 */
function resizeImage($img, $thum_path, $max_w, $max_h) {
	//仅支持PNG,JPG图片的缩略
	if (!in_array(getFileSuffix($thum_path), array('jpg','png','jpeg'))) {
		return false;
	}
	//是否支持GD
	if (!function_exists('ImageCreate')) {
		return false;
	}

	$size = chImageSize($img, $max_w, $max_h);
    $newwidth = $size['w'];
	$newheight = $size['h'];
	$w = $size['rc_w'];
	$h = $size['rc_h'];
	if ($w <= $max_w && $h <= $max_h){
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
function imageCropAndResize($src_image, $dst_path, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h) {
	if (function_exists('imagecreatefromstring')){
		$src_img = imagecreatefromstring(file_get_contents($src_image));
	} else {
		return false;
	}

	if (function_exists('imagecopyresampled')){
		$new_img = imagecreatetruecolor($dst_w, $dst_h);
		imagecopyresampled($new_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
	} elseif(function_exists('imagecopyresized')) {
		$new_img = imagecreate($dst_w, $dst_h);
		imagecopyresized($new_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
	} else {
		return false;
	}

	switch (getFileSuffix($dst_path))
	{
		case 'png':
			if(function_exists('imagepng') && imagepng($new_img, $dst_path)){
				ImageDestroy ($new_img);
				return true;
			} else {
				return false;
			}
			break;
		case 'jpg':
		default:
			if(function_exists('imagejpeg') && imagejpeg($new_img, $dst_path)){
				ImageDestroy ($new_img);
				return true;
			} else {
				return false;
			}
			break;
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
function chImageSize ($img, $max_w, $max_h){
	$size = @getimagesize($img);
	$w = $size[0];
	$h = $size[1];
	//计算缩放比例
	@$w_ratio = $max_w / $w;
	@$h_ratio =	$max_h / $h;
	//决定处理后的图片宽和高
	if( ($w <= $max_w) && ($h <= $max_h) ){
		$tn['w'] = $w;
		$tn['h'] = $h;
	} else if(($w_ratio * $h) < $max_h){
		$tn['h'] = ceil($w_ratio * $h);
		$tn['w'] = $max_w;
	} else {
		$tn['w'] = ceil($h_ratio * $w);
		$tn['h'] = $max_h;
	}
	$tn['rc_w'] = $w;
	$tn['rc_h'] = $h;
	return $tn ;
}

/**
 * 获取Gravatar头像
 * http://en.gravatar.com/site/implement/images/
 * @param $email
 * @param $s size
 * @param $d default avatar
 * @param $g
 */
function getGravatar($email, $s=40, $d='mm', $g='g') {
	$hash = md5($email);
	$avatar = "http://www.gravatar.com/avatar/$hash?s=$s&d=$d&r=$g";
	return $avatar;
}

/**
 * 计算时区的时差
 * @param string $remote_tz 远程时区
 * @param string $origin_tz 标准时区
 *
 */
function getTimeZoneOffset($remote_tz, $origin_tz = 'UTC') {
    if($origin_tz === null) {
        if(!is_string($origin_tz = date_default_timezone_get())) {
            return false; // A UTC timestamp was returned -- bail out!
        }
    }
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime('now', $origin_dtz);
    $remote_dt = new DateTime('now', $remote_dtz);
    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
    return $offset;
}

/**
 * 将字符串转换为时区无关的UNIX时间戳
 */
function emStrtotime($timeStr) {
    $timezone = Option::get('timezone');
    if ($timeStr) {
	    $unixPostDate = @strtotime($timeStr);
	    if ($unixPostDate === false) {
	        return false;
	    } else {
            $serverTimeZone = phpversion() > '5.2' ? @date_default_timezone_get() : ini_get('date.timezone');
            if (empty($serverTimeZone) || $serverTimeZone == 'UTC') {
                $unixPostDate -= $timezone * 3600;
            } else {
                if (phpversion() > '5.2' && $serverTimeZone = date_default_timezone_get()) {
            		/*
            		* 如果服务器配置默认了时区，那么PHP将会把传入的时间识别为时区当地时间
            	    * 但是我们传入的时间实际是blog配置的时区的当地时间，并不是服务器时区的当地时间
            		* 因此，我们需要将strtotime得到的时间去掉/加上两个时区的时差，得到utc时间
            		*/
            		$offset = getTimeZoneOffset($serverTimeZone);
            		// 首先减去/加上本地时区配置的时差
            		$unixPostDate -= $timezone * 3600;
            		// 再减去/加上服务器时区与utc的时差，得到utc时间
            		$unixPostDate -= $offset;
        		}
        	}
        }
        return $unixPostDate;
    } else {
        return false;
    }
}

/**
 * 获取指定月份的天数
 *
 * @param string $month 月份
 * @param string $year 年份
 */
function getMonthDayNum($month, $year) {
    switch(intval($month)){
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            return 31;break;
        case 2:
            if ($year % 4 == 0) {
                return 29;
            } else {
                return 28;
            }
            break;
        default:
            return 30;
            break;
    }
}
/**
 * 解压zip
 */
function emUnZip ($zipfile, $path, $type = 'tpl') {
	if(class_exists('ZipArchive')) {
	    $zip = new ZipArchive();
	    if (@$zip->open($zipfile) === TRUE) {
	    	$dir = $zip->getNameIndex(0);
	    	switch ($type) {
	    		case 'tpl':
	    			$re = $zip->getFromName($dir.'header.php');
	    			if (false === $re)
	    			return -2;
	    			break;
	    		case 'plugin':
	    			$plugin_name = substr($dir, 0 -1);
	    			$re = $zip->getFromName($dir.$plugin_name.'.php');
	    			if (false === $re)
	    				return -1;
	    			break;
	    	}
	    	if (true === @$zip->extractTo($path)) {
	    		$zip->close();
	    		return 0;
	    	} else {
	    		return 1;
	    	}
		} else {
		    return 2;
		}
	} else {
		return 3;
	}
}

/**
 * 删除文件或目录
 */
function emDeleteFile ($file){
    if (empty($file))
    	return false;
    if (@is_file($file))
        return @unlink($file);
   	$ret = true;
   	if ($handle = @opendir($file)) {
		while ($filename = @readdir($handle)){
			if ($filename == '.' || $filename == '..')
				continue;
			if (!emDeleteFile($file . '/' . $filename))
				$ret = false;
		}
   	} else {
   		$ret = false;
   	}
   	@closedir($handle);
	if ( file_exists($file) && !rmdir($file) ){
		$ret = false;
	}
   	return $ret;
}

/**
 * 页面跳转
 */
function emDirect($directUrl) {
	header("Location: $directUrl");
	exit;
}

/**
 * 后台操作返回信息
 *
 * @param string $msg
 * @param string $url
 * @param boolean $type
 */
function formMsg($msg,$url,$type){
	$typeimg = $type ? 'mc_ok.gif' : 'mc_no.gif';
	require_once(View::getView('msg'));
	View::output();
	exit;
}

/**
 * 显示系统信息
 *
 * @param string $msg 信息
 * @param string $url 返回地址
 * @param boolean $isAutoGo 是否自动返回 true false
 */
function emMsg($msg, $url='javascript:history.back(-1);', $isAutoGo=false){
	if ($msg == '404') {
		header("HTTP/1.1 404 Not Found");
		$msg = '404 请求页面不存在！';
	}
	echo <<<EOT
<html>
<head>
EOT;
	if($isAutoGo){
		echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
	}
	echo <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>emlog system message</title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	margin-top:20px;
	font-size: 12px;
	color: #666666;
	width:580px;
	margin:10px 200px;
	padding:10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
}
-->
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
<p><a href="$url">&laquo;点击返回</a></p>
</div>
</body>
</html>
EOT;
	exit;
}
