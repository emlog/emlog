<?php
/**
 * Basic function library
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

/**
 * Load template file
 *
 * @param string $template Template name
 * @param string $ext Template suffix
 * @return string Template path
 */
function getViews($template, $ext = '.php'){
	if (!is_dir(TEMPLATE_PATH)){
	    emMsg($lang['template_damaged'], BLOG_URL . 'admin/template.php');
	}
	$path = TEMPLATE_PATH.$template.$ext;
	return $path;
}

/**
 * Remove redundant escape characters
 *
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
 *
 * @param unknown_type $value
 * @return unknown
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
 * @return unknown
 */
function htmlClean($content, $wrap=true){
	$content = htmlspecialchars($content);
	if($wrap){
		$content = str_replace("\n", '<br>', $content);
	}
	$content = str_replace('  ', '&nbsp;&nbsp;', $content);
	$content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
	return $content;
}

/**
 * Get user ip address
 *
 * @return string
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
 *
 * @return string
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
 * Statistics
 *
 */
function viewCount() {
	global $CACHE, $viewcount_day, $viewcount_all, $viewcount_date, $utctimestamp, $timezone;
	$userip = getIp();
	$em_viewip = isset($_COOKIE['em_viewip']) ? $_COOKIE['em_viewip'] : '';
	if ($em_viewip != $userip){
		$ret = setcookie('em_viewip', getIp(), $utctimestamp + (12*3600));
		$curtime = gmdate('Y-m-d', $utctimestamp + $timezone * 3600);
		if ($viewcount_date != $curtime){
			updateOption('viewcount_date', $curtime);
			updateOption('viewcount_day', 1);
		} else {
			updateOption('viewcount_day', 'option_value+1', true);
		}
		updateOption('viewcount_all', 'option_value+1', true);
		$CACHE->updateCache('options');
	}
}

/**
 * Update blog options
 *
 */
function updateOption($name, $value, $isSyntax = false){
	global $DB;
	$value = $isSyntax ? $value : "'$value'";
	$DB->query('UPDATE '.DB_PREFIX."options SET option_value=$value where option_name='$name'");
}

/**
 * Check the plugin
 *
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
 *
 * @param unknown_type $email
 * @return unknown
 */
function checkMail($email){
	if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && strlen($email) <= 60){
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
 * @return unknown
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
 * Convert attachment size unit
 *
 * @param string $fileSize File size, kb
 * @return unknown
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
 * Paging function
 *
 * @param int $count Total number of entries
 * @param int $perlogs Number of items displayed per page
 * @param int $page Current page number
 * @param string $url Page URL
 * @return unknown
 */
function pagination($count,$perlogs,$page,$url){
	$pnums = @ceil($count / $perlogs);
	$re = '';
	for ($i = $page-5;$i <= $page+5 && $i <= $pnums; $i++){
		if ($i > 0){
			if ($i == $page){
				$re .= " <span>$i</span> ";
			} else {
				$re .= " <a href=\"$url=$i\">$i</a> ";
			}
		}
	}
	if ($page > 6) $re = "<a href=\"$url=1\" title=\"{$lang['first_page']}\">&laquo;</a><em>...</em>$re";
	if ($page + 5 < $pnums) $re .= "<em>...</em> <a href=\"$url=$pnums\" title=\"{$lang['last_page']}\">&raquo;</a>";
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
 * Clear the comments in the template and complete URL optimization
 *
 */
function cleanPage($beUrlRewrite = false){
	global $isurlrewrite,$isgzipenable,$searchlink,$replacelink;
	$output = str_replace(array('?>','<?php',"<?php\r\n?>"),array('','',''),ob_get_contents());
	if($beUrlRewrite){
		switch ($isurlrewrite){
			case '1':
				$searchlink = "/href\=\"([^\"]*)(\/index\.php|\/)\?(post|record|sort|author|page|tag)=([%+-_A-Za-z0-9]+)(#*[\w]*)\"/i";
				$replacelink = "href=\"$1/$3-$4.html$5\"";
				$output = preg_replace($searchlink, $replacelink, $output);
				break;
			case '2':
				$searchlink = "/href\=\"([^\"]*)(\/index\.php|\/)\?(post|record|sort|author|page|tag)=([%+-_A-Za-z0-9]+)(#*[\w]*)\"/i";
				$replacelink = "href=\"$1/$3/$4$5\"";
				$output = preg_replace($searchlink, $replacelink, $output);
				break;
		}
	}
	ob_end_clean();
	if ($isgzipenable == 'y' && function_exists('ob_gzhandler')){
		ob_start('ob_gzhandler');
	} else {
		ob_start();
	}
	echo $output;
	exit;
}

/**
 * Split blog post
 *
 * @param string $content Post content
 * @param int $lid Post id
 * @return unknown
 */
function breakLog($content,$lid){
	$a = explode('[break]',$content,2);
	if(!empty($a[1]))
	$a[0].='<p><a href="'.BLOG_URL.'?post='.$lid.'">'.$lang['read_more'].'&gt;&gt;</a></p>';
	return $a[0];
}

/**
 * Remove the [break] tag
 *
 * @param string $content Post content
 * @return unknown
 */
function rmBreak($content){
	$content = str_replace('[break]','',$content);
	return $content;
}

/**
 * Get remote file content
 *
 * @param $url File http address
 * @return unknown
 */
function fopen_url($url){
	if (function_exists('file_get_contents')) {
		$file_content = @file_get_contents($url);
	} elseif (ini_get('allow_url_fopen') && ($file = @fopen($url, 'rb'))){
		$i = 0;
		while (!feof($file) && $i++ < 1000) {
			$file_content .= strtolower(fread($file, 4096));
		}
		fclose($file);
	} elseif (function_exists('curl_init')) {
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($curl_handle, CURLOPT_FAILONERROR,1);
		curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Trackback Spam Check');
		$file_content = curl_exec($curl_handle);
		curl_close($curl_handle);
	} else {
		$file_content = '';
	}
	return $file_content;
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
	global $utctimestamp, $timezone;
	$op = '';
	$sec = $utctimestamp - $datetemp;
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
		$randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
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
 * @param string $fileType Type of uploaded file eg:image/jpeg
 * @param array $type File types allowed to upload
 * @param boolean $isIcon Whether to upload an avatar
 * @return string File path
 */
function uploadFile($fileName, $errorNum, $tmpFile, $fileSize, $fileType, $type, $isIcon = 0){
	if ($errorNum == 1){
		formMsg($lang['attachment_exceed_system_limit'].ini_get('upload_max_filesize'), 'javascript:history.go(-1);', 0);
	}elseif ($errorNum > 1){
		formMsg($lang['upload_failed_code'].$errorNum, 'javascript:history.go(-1);', 0);
	}
	$extension  = strtolower(substr(strrchr($fileName, "."),1));
	if (!in_array($extension, $type)){
		formMsg($lang['wrong_file_type'],"javascript:history.go(-1);",0);
	}
	if ($fileSize > UPLOADFILE_MAXSIZE){
		$ret = changeFileSize(UPLOADFILE_MAXSIZE);
		formMsg($lang['file_size_exceeded'].$ret.$lang['restrictions'],"javascript:history.go(-1);",0);
	}
	$uppath = UPLOADFILE_PATH . gmdate('Ym') . '/';
	$fname = md5($fileName) . gmdate('YmdHis') .'.'. $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir(UPLOADFILE_PATH)){
		umask(0);
		$ret = @mkdir(UPLOADFILE_PATH, 0777);
		if ($ret === false){
			formMsg($lang['attachment_create_failed'], "javascript:history.go(-1);", 0);
		}
	}
	if (!is_dir($uppath)){
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false){
			formMsg($lang['uploads_not_written'],"javascript:history.go(-1);",0);
		}
	}
	doAction('attach_upload', $tmpFile);
	//resizeImage
	$imtype = array('jpg','png','jpeg');
	$thum = $uppath . 'thum-' . $fname;
	$attach = $attachpath;
	if (IS_THUMBNAIL && in_array($extension, $imtype) && function_exists('ImageCreate')){
	    if ($isIcon && resizeImage($tmpFile, $fileType, $thum, ICON_MAX_W, ICON_MAX_H)) {
	        $attach = $thum;
	        resizeImage($tmpFile, $fileType, $uppath.'thum52-'. $fname, 52, 52);
	    } elseif (resizeImage($tmpFile, $fileType, $thum, IMG_ATT_MAX_W, IMG_ATT_MAX_H)){
	        $attach = $thum;
	    }
	}

	if (@is_uploaded_file($tmpFile)){
		if (@!move_uploaded_file($tmpFile ,$attachpath)){
			@unlink($tmpFile);
			formMsg($lang['uploads_not_written'],"javascript:history.go(-1);",0);
		}
		chmod($attachpath, 0777);
	}
	return 	$attach;
}

/**
 * Generate image thumbnail
 *
 * @param string $img Original image
 * @param unknown_type $imgType Type of uploaded file eg:image/jpeg
 * @param string $thumPatch Generate thumbnail path
 * @param int $max_w Maximum thumbnail width px
 * @param int $max_h Maximum thumbnail height px
 * @return unknown
 */
function resizeImage($img, $imgType, $thumPatch, $max_w, $max_h){
	$size = chImageSize($img,$max_w,$max_h);
    $newwidth = $size['w'];
	$newheight = $size['h'];
	$w =$size['rc_w'];
	$h = $size['rc_h'];
	if ($w <= $max_w && $h <= $max_h){
		return false;
	}
	if ($imgType == 'image/pjpeg' || $imgType == 'image/jpeg'){
		if(function_exists('imagecreatefromjpeg')){
			$img = imagecreatefromjpeg($img);
		}else{
			return false;
		}
	} elseif ($imgType == 'image/x-png' || $imgType == 'image/png') {
		if (function_exists('imagecreatefrompng')){
			$img = imagecreatefrompng($img);
		}else{
			return false;
		}
	}
	if (function_exists('imagecopyresampled')){
		$newim = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
	} else {
		$newim = imagecreate($newwidth, $newheight);
		imagecopyresized($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
	}
	if ($imgType == 'image/pjpeg' || $imgType == 'image/jpeg'){
		if(!imagejpeg($newim,$thumPatch)){
			return false;
		}
	} elseif ($imgType == 'image/x-png' || $imgType == 'image/png') {
		if (!imagepng($newim,$thumPatch)){
			return false;
		}
	}
	ImageDestroy ($newim);
	return true;
}

/**
 * Change the picture size according to the proportion (not generating thumbnails)
 *
 * @param string $img Image path
 * @param int $max_w Max thumb width
 * @param int $max_h Max thumb height
 * @return unknown
 */
function chImageSize ($img,$max_w,$max_h){
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
 * Background operation return information
 *
 * @param string $msg
 * @param string $url
 * @param boolean $type
 */
function formMsg($msg,$url,$type){
	$typeimg = $type ? 'mc_ok.gif' : 'mc_no.gif';
	require_once(getViews('msg'));
	cleanPage();
	exit;
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
 *
 */
function emStrtotime($timeStr) {
    global $timezone;
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
 * Display system message
 *
 * @param string $msg Message
 * @param string $url Return URL
 * @param boolean $isAutoGo Whether to return automatically, true/false
 */
function emMsg($msg,$url='javascript:history.back(-1);', $isAutoGo=false){
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
<p><a href="$url">&laquo;{$lang['return_back']}</a></p>
</div>
</body>
</html>
EOT;
	exit;
}
