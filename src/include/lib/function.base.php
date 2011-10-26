<?php
/**
 * Basic function library
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
    	emMsg($class.$lang['load_failed'], BLOG_URL);
    }
}

/**
 * Remove redundant escape characters
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
 * Recursively remove escape characters
 */
function stripslashesDeep($value){
	$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
	return $value;
}

/**
 * Convert HTML code function
 *
 * @param unknown_type $content
 * @param unknown_type $wrap Whether to wrap
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
 * Get user ip address
 */
function getIp(){
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if(!preg_match("/^\d+\.\d+\.\d+\.\d+$/", $ip)){
		$ip = '';
	}
	return $ip;
}

/**
 * Get the blog address (only for the root directory script, currently only used for homepage ajax requests)
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
 * Check the plugin
 */
function checkPlugin($plugin) {
    if (is_string($plugin) && preg_match("/^[\w\-\/]+\.php$/", $plugin) && file_exists(EMLOG_ROOT . '/content/plugins/' . $plugin)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Verify email address format
 */
function checkMail($email){
	if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && mb_strlen($email) <= 60){
		return true;
	} else {
		return false;
	}
}

/**
 * Get a substring encoded as utf8
 *
 * @param string $strings Original string
 * @param int $start Start position eg:0
 * @param int $length Substring length
 */
function subString($strings,$start,$length){
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0; $i < mb_strlen($str); $i++){
		if (ord($str[$i]) >= 128)
		$char++;
	}
	$str2 = substr($strings, $start, $length+1);
	$str3 = substr($strings, $start, $length+2);
	if ($char % 3 == 1){
		if ($length <= mb_strlen($strings)){
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char%3 == 2){
		if ($length <= mb_strlen($strings)){
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char%3 == 0){
		if ($length <= mb_strlen($strings)){
			$str = $str .= '...';
		}
		return $str;
	}
}

/**
 * Extract plain text summaries from content that may contain html markup
 *
 * @param string $data
 * @param int $len
 */
function extractHtmlData($data, $len) {
	$data = strip_tags(subString($data, 0, $len + 30));
	$search = array ("/([\r\n])[\s]+/",	// Remove whitespace characters
		             "/&(quot|#34);/i",	// Replace HTML entities
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
 * Convert attachment size unit
 *
 * @param string $fileSize File size, kb
 */
function changeFileSize($fileSize){
    global $lang;
	if($fileSize >= 1073741824){
		$fileSize = round($fileSize / 1073741824  ,2) . 'GB';
	} elseif($fileSize >= 1048576){
		$fileSize = round($fileSize / 1048576 ,2) . 'MB';
	} elseif($fileSize >= 1024){
		$fileSize = round($fileSize / 1024, 2) . 'KB';
	} else{
		$fileSize = $fileSize . $lang['bytes'];
	}
	return $fileSize;
}

/**
 * Get file suffix
 * @param string $fileName
 */
function getFileSuffix($fileName) { 
	return strtolower(substr(strrchr($fileName, "."),1));
}

/**
 * Paging function
 *
 * @param int $count Total number of entries
 * @param int $perlogs Number of items displayed per page
 * @param int $page Current page number
 * @param string $url Page URL
 */
function pagination($count,$perlogs,$page,$url,$anchor=''){
	$pnums = @ceil($count / $perlogs);
	$re = '';
	$urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|","",$url);
	for ($i = $page-5;$i <= $page+5 && $i <= $pnums; $i++){
		if ($i > 0){
			if ($i == $page){
				$re .= " <span>$i</span> ";
			} elseif($i == 1) {
				$re .= " <a href=\"$urlHome$anchor\">$i</a> ";
			} else {
				$re .= " <a href=\"$url$i$anchor\">$i</a> ";
			}
		}
	}
	if ($page > 6) $re = "<a href=\"{$urlHome}$anchor\" title=\"{$lang['first_page']}\">&laquo;</a><em>...</em>$re";
	if ($page + 5 < $pnums) $re .= "<em>...</em> <a href=\"$url$pnums$anchor\" title=\"{$lang['last_page']}\">&raquo;</a>";
	if ($pnums <= 1) $re = '';
	return $re;
}

/**
 * This function is called in the plug-in, and the plug-in function is mounted to the reserved hook
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
 * Execute the function hung on the hook, support multiple parameters eg:doAction('post_comment', $author, $email, $url, $comment);
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
 * Split blog post
 *
 * @param string $content Post content
 * @param int $lid Post id
 */
function breakLog($content,$lid){
    global $lang;
	$a = explode('[break]',$content,2);
	if(!empty($a[1]))
	$a[0].='<p class="readmore"><a href="'.Url::log($lid).'">'.$lang['read_more'].'&gt;&gt;</a></p>';
	return $a[0];
}

/**
 * Remove the [break] tag
 *
 * @param string $content Post content
 */
function rmBreak($content){
	$content = str_replace('[break]','',$content);
	return $content;
}

/**
 * Time conversion function
 *
 * @param $now
 * @param $datetemp
 * @param $dstr
 * @return string
 */
function smartDate($datetemp, $dstr='Y-m-d H:i'){
    global $lang;
	$timezone = Option::get('timezone');
	$op = '';
	$sec = time() - $datetemp;
	$hover = floor($sec / 3600);
	if ($hover == 0){
		$min = floor($sec / 60);
		if ( $min == 0) {
			$op = $sec.$lang['seconds_ago'];
		} else {
			$op = $min.$lang['minutes_ago'];
		}
	} elseif ($hover < 24){
		$op = $lang['approximately'].$hover.$lang['hours_ago'];
	} else {
		$op = gmdate($dstr, $datetemp + $timezone * 3600);
	}
	return $op;
}

/**
 * Generate a random string
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
		$randStr .= substr($chars, mt_rand(0, mb_strlen($chars) - 1), 1);
	}
	return $randStr;
}

/**
 * Find all the different elements of the two arrays
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
 * Update file
 *
 * @param string $fileName File name
 * @param string $errorNum Error code: $_FILES['error']
 * @param string $tmpFile Temporary file after upload
 * @param string $fileSize File size KB
 * @param array $type File types allowed to upload
 * @param boolean $isIcon Whether to upload an avatar
 * @param boolean $is_thumbnail Whether to generate thumbnail
 * @return string File path
 */
function uploadFile($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon=false, $is_thumbnail=Option::IS_THUMBNAIL){
    global $lang;
	if ($errorNum == 1){
		emMsg($lang['attachment_exceed_system_limit'].ini_get('upload_max_filesize'));
	}elseif ($errorNum > 1){
		emMsg($lang['upload_failed_code'].$errorNum);
	}
	$extension  = getFileSuffix($fileName);
	if (!in_array($extension, $type)){
		emMsg($lang['wrong_file_type']);
	}
	if ($fileSize > Option::UPLOADFILE_MAXSIZE){
		$ret = changeFileSize(Option::UPLOADFILE_MAXSIZE);
		emMsg($lang['file_size_exceeded'].$ret.$lang['restrictions']);
	}
	$uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
	$fname = md5($fileName) . gmdate('YmdHis') .'.'. $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir(Option::UPLOADFILE_PATH)){
		umask(0);
		$ret = @mkdir(Option::UPLOADFILE_PATH, 0777);
		if ($ret === false){
			emMsg($lang['attachment_create_failed']);
		}
	}
	if (!is_dir($uppath)){
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false){
			emMsg($lang['uploads_not_written']);
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
			emMsg($lang['uploads_not_written']);
		}
		chmod($attachpath, 0777);
	}
	return 	$attach;
}

/**
 * Generate image thumbnail
 *
 * @param string $img Original image
 * @param string $thum_path Generate thumbnail path
 * @param int $max_w Maximum thumbnail width px
 * @param int $max_h Maximum thumbnail height px
 * @return unknown
 */
function resizeImage($img, $thum_path, $max_w, $max_h) {
	//Only support PNG, JPG image abbreviation
	if (!in_array(getFileSuffix($thum_path), array('jpg','png','jpeg'))) {
		return false;
	}
	//Whether to support GD
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
 * Crop and zoom image
 *
 * @param string $src_image Original image
 * @param string $dst_path Save path of the cropped image
 * @param int $dst_x New image coordinate x
 * @param int $dst_y New image coordinate y
 * @param int $src_x Original image coordinate x
 * @param int $src_y Original image coordinate y
 * @param int $dst_w New image width
 * @param int $dst_h New image height
 * @param int $src_w Original image width
 * @param int $src_h Original image height
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
 * Change the picture size according to the proportion (not generating thumbnails)
 *
 * @param string $img Image path
 * @param int $max_w Max thumb width
 * @param int $max_h Max thumb height
 * @return array
 */
function chImageSize ($img, $max_w, $max_h){
	$size = @getimagesize($img);
	$w = $size[0];
	$h = $size[1];
	//Calculate the ratio
	@$w_ratio = $max_w / $w;
	@$h_ratio =	$max_h / $h;
	//Calculate the width and height of the processed image
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
 * Get Gravatar Avatar
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
 * Calculate the time difference of the time zone
 * @param string $remote_tz Remote time zone
 * @param string $origin_tz Standard time zone
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
 * Convert string to UNIX timestamp independent of time zone
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
            		* If the server configuration defaults to the time zone, then PHP will recognize the incoming time as the local time in the time zone
            	    * But the time we passed in is actually the local time in the time zone configured by the blog, not the local time in the server time zone
            		* Therefore, we need to remove the time obtained by strtotime / add the time difference between the two time zones to get the UTC time
            		*/
            		$offset = getTimeZoneOffset($serverTimeZone);
            		// First subtract/add the time difference of the local time zone configuration
            		$unixPostDate -= $timezone * 3600;
            		// Subtract/add the time difference between the server time zone and utc to get the utc time
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
 * Get the number of days in a specified month
 *
 * @param string $month Month
 * @param string $year Year
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
 * Unzip the zip archive
 */
function emUnZip ($zipfile, $path, $type = 'tpl') {
	if(class_exists('ZipArchive', FALSE)) {
	    $zip = new ZipArchive();
	    if (@$zip->open($zipfile) === TRUE) {
	    	$r = explode('/', $zip->getNameIndex(0), 2);
	    	$dir = isset($r[0]) ? $r[0].'/' : '';
	    	switch ($type) {
	    		case 'tpl':
	    			$re = $zip->getFromName($dir.'header.php');
	    			if (false === $re)
	    			return -2;
	    			break;
	    		case 'plugin':
	    			$plugin_name = substr($dir, 0, -1);
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
 * Delete file or directory
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
 * Page redirect
 */
function emDirect($directUrl) {
	header("Location: $directUrl");
	exit;
}

/**
 * Display system message
 *
 * @param string $msg Message
 * @param string $url Return URL
 * @param boolean $isAutoGo Whether to return automatically, true/false
 */
function emMsg($msg, $url='javascript:history.back(-1);', $isAutoGo=false){
    global $lang;
	if ($msg == '404') {
		header("HTTP/1.1 404 Not Found");
		$msg = $lang['page_not_exists'];
	}
	$language = EMLOG_LANGUAGE;
	echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$language}">
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
	font-size: 12px;
	color: #666666;
	width:750px;
	margin:100px auto;
	border-radius: 10px;
	padding:30px 10px;
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
<p><a href="$url">&laquo;{$lang['return_back']}</a></p>
</div>
</body>
</html>
EOT;
	exit;
}
