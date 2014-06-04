<?php

/**
 * Basic function library
 * @copyright (c) Emlog All Rights Reserved
 */
function __autoload($class) {
	global $lang;
	$class = strtolower($class);
	if (file_exists(EMLOG_ROOT . '/include/model/' . $class . '.php')) {
		require_once(EMLOG_ROOT . '/include/model/' . $class . '.php');
	} elseif (file_exists(EMLOG_ROOT . '/include/lib/' . $class . '.php')) {
		require_once(EMLOG_ROOT . '/include/lib/' . $class . '.php');
	} elseif (file_exists(EMLOG_ROOT . '/include/controller/' . $class . '.php')) {
		require_once(EMLOG_ROOT . '/include/controller/' . $class . '.php');
	} else {
		emMsg($class . $lang['load_failed']);
	}
}

/**
 * Remove redundant escape characters
 */
function doStripslashes() {
	if (get_magic_quotes_gpc()) {
		$_GET = stripslashesDeep($_GET);
		$_POST = stripslashesDeep($_POST);
		$_COOKIE = stripslashesDeep($_COOKIE);
		$_REQUEST = stripslashesDeep($_REQUEST);
	}
}

/**
 * Recursively remove escape characters
 */
function stripslashesDeep($value) {
	$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
	return $value;
}

/**
 * Convert HTML code function
 *
 * @param unknown_type $content
 * @param unknown_type $wrap Whether to wrap
 */
function htmlClean($content, $nl2br = true) {
	$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
	if ($nl2br) {
		$content = nl2br($content);
	}
	$content = str_replace('  ', '&nbsp;&nbsp;', $content);
	$content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
	return $content;
}

/**
 * Get user ip address
 */
function getIp() {
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if (!ip2long($ip)) {
		$ip = '';
	}
	return $ip;
}

/**
 * Get the blog address (only for the root directory script, currently only used for homepage ajax requests)
 */
function getBlogUrl() {
	$phpself = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
	if (preg_match("/^.*\//", $phpself, $matches)) {
		return 'http://' . $_SERVER['HTTP_HOST'] . $matches[0];
	} else {
		return BLOG_URL;
	}
}

function isIE6Or7() {
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 7.0") || strpos($_SERVER['HTTP_USER_AGENT'], "MSIE 6.0")) {
			return true;
		}
	}
	return false;
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
 * Load jQuery
 */
function emLoadJQuery() {
	static $isJQueryLoaded = false;
	if (!$isJQueryLoaded) {
		global $emHooks;
		if (!isset($emHooks['index_head'])) {
			$emHooks['index_head'] = array();
		}
		array_unshift($emHooks['index_head'], 'loadJQuery');
		$isJQueryLoaded = true;

		function loadJQuery() {
			echo '<script src="' . BLOG_URL . 'include/lib/js/jquery/jquery-1.7.1.js?v=' . Option::EMLOG_VERSION . '" type="text/javascript"></script>';
		}

	}
}

/**
Verify email address format
 */
function checkMail($email) {
	if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && mb_strlen($email) <= 60) {
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
 * @return string
 */
function subString($strings, $start, $length) {
	if (function_exists('mb_substr') && function_exists('mb_strlen')) {
		$sub_str = mb_substr($strings, $start, $length, 'utf8');
		return mb_strlen($sub_str, 'utf8') < mb_strlen($strings, 'utf8') ? $sub_str . '...' : $sub_str;
	}
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0; $i < mb_strlen($str); $i++) {
		if (ord($str[$i]) >= 128)
			$char++;
	}
	$str2 = substr($strings, $start, $length + 1);
	$str3 = substr($strings, $start, $length + 2);
	if ($char % 3 == 1) {
		if ($length <= mb_strlen($strings)) {
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char % 3 == 2) {
		if ($length <= mb_strlen($strings)) {
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char % 3 == 0) {
		if ($length <= mb_strlen($strings)) {
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
	$search = array("/([\r\n])[\s]+/",	// Remove whitespace characters
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
	$replace = array(" ", "\"", "&", " ", " ", "", chr(161), chr(162), chr(163), chr(169), "");
	$data = trim(subString(preg_replace($search, $replace, $data), 0, $len));
	return $data;
}

/**
 * Convert attachment size unit
 *
 * @param string $fileSize File size, kb
 */
function changeFileSize($fileSize) {
	global $lang;
	if ($fileSize >= 1073741824) {
		$fileSize = round($fileSize / 1073741824, 2) . 'GB';
	} elseif ($fileSize >= 1048576) {
		$fileSize = round($fileSize / 1048576, 2) . 'MB';
	} elseif ($fileSize >= 1024) {
		$fileSize = round($fileSize / 1024, 2) . 'KB';
	} else {
		$fileSize = $fileSize . $lang['bytes'];
	}
	return $fileSize;
}

/**
 * Get file suffix
 */
function getFileSuffix($fileName) {
	return strtolower(pathinfo($fileName,  PATHINFO_EXTENSION));
}

/**
 * Paging function
 *
 * @param int $count Total number of entries
 * @param int $perlogs Number of items displayed per page
 * @param int $page Current page number
 * @param string $url Page URL
 */
function pagination($count, $perlogs, $page, $url, $anchor = '') {
	global $lang;
	$pnums = @ceil($count / $perlogs);
	$re = '';
	$urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|", "", $url);
	for ($i = $page - 5; $i <= $page + 5 && $i <= $pnums; $i++) {
		if ($i > 0) {
			if ($i == $page) {
				$re .= " <span>$i</span> ";
			} elseif ($i == 1) {
				$re .= " <a href=\"$urlHome$anchor\">$i</a> ";
			} else {
				$re .= " <a href=\"$url$i$anchor\">$i</a> ";
			}
		}
	}
	if ($page > 6)
		$re = "<a href=\"{$urlHome}$anchor\" title=\"{$lang['first_page']}\">&laquo;</a><em>...</em>$re";
	if ($page + 5 < $pnums)
		$re .= "<em>...</em> <a href=\"$url$pnums$anchor\" title=\"{$lang['last_page']}\">&raquo;</a>";
	if ($pnums <= 1)
		$re = '';
	return $re;
}

/**
 * This function is called in the plug-in, and the plug-in function is mounted to the reserved hook
 *
 * @param string $hook
 * @param string $actionFunc
 * @return boolearn
 */
function addAction($hook, $actionFunc) {
	global $emHooks;
	if (!@in_array($actionFunc, $emHooks[$hook])) {
		$emHooks[$hook][] = $actionFunc;
	}
	return true;
}

/**
 * Execute the function hung on the hook, support multiple parameters eg:doAction('post_comment', $author, $email, $url, $comment);
 *
 * @param string $hook
 */
function doAction($hook) {
	global $emHooks;
	$args = array_slice(func_get_args(), 1);
	if (isset($emHooks[$hook])) {
		foreach ($emHooks[$hook] as $function) {
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
function breakLog($content, $lid) {
	global $lang;
	$ret = explode('[break]', $content, 2);
	if (!empty($ret[1])) {
		$ret[0].='<p class="readmore"><a href="' . Url::log($lid) . '">'.$lang['read_more'] . '&gt;&gt;</a></p>';
        return $ret[0];
	} elseif(Option::get('isexcerpt') == 'y') {
        return subString(trim(strip_tags($content)), 0, Option::get('excerpt_subnum')) . '<p class="readmore"><a href="' . Url::log($lid) . '">'.$lang['read_more'] . '&gt;&gt;</a></p>';
    } else {
        return $content;
    }
}

/**
 * Remove the [break] tag
 *
 * @param string $content Post content
 */
function rmBreak($content) {
	$content = str_replace('[break]', '', $content);
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
function smartDate($datetemp, $dstr = 'Y-m-d H:i') {
	global $lang;
	$timezone = Option::get('timezone');
	$op = '';
	$sec = time() - $datetemp;
	$hover = floor($sec / 3600);
	if ($hover == 0) {
		$min = floor($sec / 60);
		if ($min == 0) {
			$op = $sec . $lang['seconds_ago'];
		} else {
			$op = $min.$lang['minutes_ago'];
		}
	} elseif ($hover < 24) {
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
function getRandStr($length = 12, $special_chars = true) {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ($special_chars) {
		$chars .= '!@#$%^&*()';
	}
	$randStr = '';
	for ($i = 0; $i < $length; $i++) {
		$randStr .= substr($chars, mt_rand(0, mb_strlen($chars) - 1), 1);
	}
	return $randStr;
}

/**
 * Find all the different elements of the two arrays
 */
function findArray($array1, $array2) {
	$r1 = array_diff($array1, $array2);
	$r2 = array_diff($array2, $array1);
	$r = array_merge($r1, $r2);
	return $r;
}

function uploadFile($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon = false, $is_thumbnail = true) {
	global $lang;
	$result = upload($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon, $is_thumbnail);
	switch ($result) {
		case '100':
			emMsg($lang['attachment_exceed_system_limit'] . ini_get('upload_max_filesize'));
			break;
		case '101':
			emMsg($lang['backup_sql_error'] . $errorNum);
			break;
		case '102':
			emMsg($lang['wrong_file_type']);
			break;
		case '103':
			$ret = changeFileSize(Option::getAttMaxSize());
			emMsg($lang['file_size_exceeded'] . $ret);
			break;
		case '104':
			emMsg($lang['attachment_create_failed']);
			break;
		case '105':
			emMsg($lang['uploads_not_written']);
			break;
		default:
			return $result;
			break;
	}
}

//Batch upload of attachments
function uploadFileBySwf($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon = false, $is_thumbnail = true) {
	$result = upload($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon, $is_thumbnail);
	switch ($result) {
		case '100':
		case '101':
		case '102':
		case '103':
		case '104':
		case '105':
			header("HTTP/1.1 404 Not Found");
			exit;
			break;
		default:
			return $result;
			break;
	}
}

/**
 * Update file
 *
 * Keys of the returned array
 * mime_type File type
 * size      File size (in KB)
 * file_path File path
 * width     Width
 * height    Height
 * Optional values (only works when the uploaded file is a picture and the system turns on thumbnails)
 * thum_file   Thumbnail path
 * thum_width  Thumbnail width
 * thum_height Thumbnail height
 * thum_size   Thumbnail size (in KB)
 *
 * @param string $fileName File name
 * @param string $errorNum Error code: $_FILES['error']
 * @param string $tmpFile Temporary file after upload
 * @param string $fileSize File size KB
 * @param array $type File types allowed to upload
 * @param boolean $isIcon Whether to upload an avatar
 * @param boolean $is_thumbnail Whether to generate thumbnail
 * @return string File path
 * @return array File data
 * 
 */
function upload($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon = false, $is_thumbnail = true) {
	if ($errorNum == 1) {
		return '100';//File size exceeds system limit
	} elseif ($errorNum > 1) {
		return '101';//Failed to upload file
	}
	$extension = getFileSuffix($fileName);
	if (!in_array($extension, $type)) {
		return '102';//Wrong file type
	}
	if ($fileSize > Option::getAttMaxSize()) {
		return '103';//File size exceeds emlog limit
	}
	$file_info = array();
	$file_info['file_name'] = $fileName;
	$file_info['mime_type'] = get_mimetype($extension);
	$file_info['size'] = $fileSize;
	$file_info['width'] = 0;
	$file_info['height'] = 0;
	$uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
	$fname = substr(md5($fileName), 0, 4) . time() . '.' . $extension;
	$attachpath = $uppath . $fname;
	$file_info['file_path'] = $attachpath;
	if (!is_dir(Option::UPLOADFILE_PATH)) {
		@umask(0);
		$ret = @mkdir(Option::UPLOADFILE_PATH, 0777);
		if ($ret === false) {
			return '104';//Failed to create file upload directory
		}
	}
	if (!is_dir($uppath)) {
		@umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false) {
			return '105';//Upload failed. File upload directory (content/uploadfile) is not writable
		}
	}
	doAction('attach_upload', $tmpFile);

	// Generate thumbnail
	$thum = $uppath . 'thum-' . $fname;
	if ($is_thumbnail) {
		if ($isIcon && resizeImage($tmpFile, $thum, Option::ICON_MAX_W, Option::ICON_MAX_H)) {
			$file_info['thum_file'] = $thum;
			$file_info['thum_size'] = filesize($thum);
			$size = getimagesize($thum);
			if ($size) {
				$file_info['thum_width'] = $size[0];
				$file_info['thum_height'] = $size[1];
			}
			resizeImage($tmpFile, $uppath . 'thum52-' . $fname, 52, 52);
		} elseif (resizeImage($tmpFile, $thum, Option::get('att_imgmaxw'), Option::get('att_imgmaxh'))) {
			$file_info['thum_file'] = $thum;
			$file_info['thum_size'] = filesize($thum);
			$size = getimagesize($thum);
			if ($size) {
				$file_info['thum_width'] = $size[0];
				$file_info['thum_height'] = $size[1];
			}
		}
	}

	if (@is_uploaded_file($tmpFile)) {
		if (@!move_uploaded_file($tmpFile, $attachpath)) {
			@unlink($tmpFile);
			return '105';//Upload failed. File upload directory (content/uploadfile) is not writable
		}
		@chmod($attachpath, 0777);
	}
	
	// If the attachment is a picture
	if (in_array($file_info['mime_type'], array('image/jpeg', 'image/png', 'image/gif', 'image/bmp'))) {
		$size = getimagesize($file_info['file_path']);
		if ($size) {
			$file_info['width'] = $size[0];
			$file_info['height'] = $size[1];
		}
	}
	return $file_info;
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
	if (function_exists('imagecreatefromstring')) {
		$src_img = imagecreatefromstring(file_get_contents($src_image));
	} else {
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
			} else {
				return false;
			}
			break;
		case 'jpg':
		default:
			if (function_exists('imagejpeg') && imagejpeg($new_img, $dst_path)) {
				ImageDestroy($new_img);
				return true;
			} else {
				return false;
			}
			break;
		case 'gif':
			if (function_exists('imagegif') && imagegif($new_img, $dst_path)) {
				ImageDestroy($new_img);
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
function chImageSize($img, $max_w, $max_h) {
	$size = @getimagesize($img);
	$w = $size[0];
	$h = $size[1];
	//Calculate the ratio
	@$w_ratio = $max_w / $w;
	@$h_ratio = $max_h / $h;
	//Calculate the width and height of the processed image
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
 * Get Gravatar Avatar
 * http://en.gravatar.com/site/implement/images/
 * @param $email
 * @param $s size
 * @param $d default avatar
 * @param $g
 */
function getGravatar($email, $s = 40, $d = 'mm', $g = 'g') {
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
	if ($origin_tz === null) {
		if (!is_string($origin_tz = date_default_timezone_get())) {
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
 */
function getMonthDayNum($month, $year) {
	$month = (int)$month;
	$year = (int)$year;
	
	$months_map = array(1=>31, 3=>31, 4=>30, 5=>31, 6=>30, 7=>31, 8=>31, 9=>30, 10=>31, 11=>30, 12=>31);
	if (array_key_exists($month, $months_map)) {
		return $months_map[$month];
	}
	else {
		if ($year % 100 === 0) {
			if ($year % 400 === 0) {
				return 29;
			} else {
				return 28;
			}
		}
		else if ($year % 4 === 0) {
			return 29;
		}
		else {
			return 28;
		}
	}
}

/**
 * Unzip the zip archive
 * @param type $zipfile File to unzip
 * @param type $path Unzip to this directory
 * @param type $type
 * @return int
 */
function emUnZip($zipfile, $path, $type = 'tpl') {
	if (!class_exists('ZipArchive', FALSE)) {
		return 3;//zip module problem
	}
	$zip = new ZipArchive();
	if (@$zip->open($zipfile) !== TRUE) {
		return 2;//File permission issues
	}
	$r = explode('/', $zip->getNameIndex(0), 2);
	$dir = isset($r[0]) ? $r[0] . '/' : '';
	switch ($type) {
		case 'tpl':
			$re = $zip->getFromName($dir . 'header.php');
			if (false === $re)
				return -2;
			break;
		case 'plugin':
			$plugin_name = substr($dir, 0, -1);
			$re = $zip->getFromName($dir . $plugin_name . '.php');
			if (false === $re)
				return -1;
			break;
		case 'backup':
			$sql_name = substr($dir, 0, -1);
			if (getFileSuffix($sql_name) != 'sql')
				return -3;
			break;
		case 'update':
			break;
	}
	if (true === @$zip->extractTo($path)) {
		$zip->close();
		return 0;
	} else {
		return 1;//File permission issues
	}
}

/**
 * zip compression
 */
function emZip($orig_fname, $content) {
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
	} else {
		return false;
	}
}

/**
 * Get remote file
 * @param type $source Remote file address
 * @return Temporary file address
 */
function emFecthFile($source) {
    $temp_file = tempnam('/tmp', 'emtemp_');
    $rh = fopen($source, 'rb');
    $wh = fopen($temp_file, 'w+b');
    if ( ! $rh || ! $wh) {
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
 * Delete file or directory
 */
function emDeleteFile($file) {
	if (empty($file))
		return false;
	if (@is_file($file))
		return @unlink($file);
	$ret = true;
	if ($handle = @opendir($file)) {
		while ($filename = @readdir($handle)) {
			if ($filename == '.' || $filename == '..')
				continue;
			if (!emDeleteFile($file . '/' . $filename))
				$ret = false;
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
function emMsg($msg, $url = 'javascript:history.back(-1);', $isAutoGo = false) {
	global $lang;
	$language = EMLOG_LANGUAGE;
	if ($msg == '404') {
		header("HTTP/1.1 404 Not Found");
		$msg = $lang['page_not_exists'];
	}
	echo <<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$language}">
<head>
EOT;
	if ($isAutoGo) {
		echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
	}
	echo <<<EOT
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$lang['redirect_title']}</title>
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
	width:650px;
	margin:60px auto 0px;
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
EOT;
	if ($url != 'none') {
		echo '<p><a href="' . $url . '">&laquo;' . $lang['return_back'] . '</a></p>';
	}
	echo <<<EOT
</div>
</body>
</html>
EOT;
	exit;
}

/**
 * Display 404 error page
 * 
 */
function show_404_page() {
	if (is_file(TEMPLATE_PATH . '404.php')) {
		header("HTTP/1.1 404 Not Found");
		include View::getView('404');
		exit;
	} else {
		emMsg('404', BLOG_URL);
	}
}

/**
 * Replace emoji
 *
 * @param $t
 */
function emoFormat($t){
	$emos = array('[Smile]'=>'0.gif', '[Disappoint]'=>'1.gif', '[Love]'=>'2.gif', '[Crazy]'=>'3.gif', '[Cool]'=>'4.gif', '[Tear]'=>'5.gif', '[Shy]'	=>'6.gif', '[Shutdown]'=>'7.gif', '[Sleep]'=>'8.gif', '[Cry]'	=>'9.gif', '[Confused]'=>'10.gif', '[Evil]'=>'11.gif', '[Tongue]'=>'12.gif', '[Lol]'	=>'13.gif', '[Amazed]'=>'14.gif', '[Sad]'	=>'15.gif', '[Displeased]'=>'16.gif', '[Weary]'=>'17.gif', '[Angry]'=>'18.gif', '[Vomit]'=>'19.gif', '[Giggle]'=>'20.gif', '[Happy]'=>'21.gif', '[Unsure]'=>'22.gif', '[Curvedlips]'=>'23.gif', '[Lick]'=>'24.gif', '[Sleepy]'=>'25.gif', '[Tired]'=>'26.gif', '[Sweaty]'=>'27.gif', '[Loud]'=>'28.gif', '[Martinet]'=>'29.gif', '[Pirate]'=>'30.gif', '[Swear]'=>'31.gif', '[Bemused]'=>'32.gif', '[Secret]'=>'33.gif', '[Bewitched]'=>'34.gif', '[Disagree]'=>'35.gif');
	if(!empty($t) && preg_match_all('/\[.+?\]/',$t,$matches)){
		$matches = array_unique($matches[0]);
		foreach ($matches as $data) {
			if(isset($emos[$data]))
				$t = str_replace($data,'<img title="'.$data.'" src="'.BLOG_URL.'admin/editor/plugins/emoticons/images/'.$emos[$data].'"/>',$t);
		}
	}
	return $t;
}

/**
 * hmac encryption
 *
 * @param unknown_type $algo hash algorithm md5
 * @param unknown_type $data Username and expiration time
 * @param unknown_type $key
 * @return unknown
 */
if(!function_exists('hash_hmac')) {
	function hash_hmac($algo, $data, $key) {
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
 * Get the mime type according to the file suffix
 * @param string $extension
 * @return string
 */
 function get_mimetype($extension) {
	$ct['htm'] = 'text/html';
	$ct['html'] = 'text/html';
	$ct['txt'] = 'text/plain';
	$ct['asc'] = 'text/plain';
	$ct['bmp'] = 'image/bmp';
	$ct['gif'] = 'image/gif';
	$ct['jpeg'] = 'image/jpeg';
	$ct['jpg'] = 'image/jpeg';
	$ct['jpe'] = 'image/jpeg';
	$ct['png'] = 'image/png';
	$ct['ico'] = 'image/vnd.microsoft.icon';
	$ct['mpeg'] = 'video/mpeg';
	$ct['mpg'] = 'video/mpeg';
	$ct['mpe'] = 'video/mpeg';
	$ct['qt'] = 'video/quicktime';
	$ct['mov'] = 'video/quicktime';
	$ct['avi'] = 'video/x-msvideo';
	$ct['wmv'] = 'video/x-ms-wmv';
	$ct['mp2'] = 'audio/mpeg';
	$ct['mp3'] = 'audio/mpeg';
	$ct['rm'] = 'audio/x-pn-realaudio';
	$ct['ram'] = 'audio/x-pn-realaudio';
	$ct['rpm'] = 'audio/x-pn-realaudio-plugin';
	$ct['ra'] = 'audio/x-realaudio';
	$ct['wav'] = 'audio/x-wav';
	$ct['css'] = 'text/css';
	$ct['zip'] = 'application/zip';
	$ct['pdf'] = 'application/pdf';
	$ct['doc'] = 'application/msword';
	$ct['bin'] = 'application/octet-stream';
	$ct['exe'] = 'application/octet-stream';
	$ct['class'] = 'application/octet-stream';
	$ct['dll'] = 'application/octet-stream';
	$ct['xls'] = 'application/vnd.ms-excel';
	$ct['ppt'] = 'application/vnd.ms-powerpoint';
	$ct['wbxml'] = 'application/vnd.wap.wbxml';
	$ct['wmlc'] = 'application/vnd.wap.wmlc';
	$ct['wmlsc'] = 'application/vnd.wap.wmlscriptc';
	$ct['dvi'] = 'application/x-dvi';
	$ct['spl'] = 'application/x-futuresplash';
	$ct['gtar'] = 'application/x-gtar';
	$ct['gzip'] = 'application/x-gzip';
	$ct['js'] = 'application/x-javascript';
	$ct['swf'] = 'application/x-shockwave-flash';
	$ct['tar'] = 'application/x-tar';
	$ct['xhtml'] = 'application/xhtml+xml';
	$ct['au'] = 'audio/basic';
	$ct['snd'] = 'audio/basic';
	$ct['midi'] = 'audio/midi';
	$ct['mid'] = 'audio/midi';
	$ct['m3u'] = 'audio/x-mpegurl';
	$ct['tiff'] = 'image/tiff';
	$ct['tif'] = 'image/tiff';
	$ct['rtf'] = 'text/rtf';
	$ct['wml'] = 'text/vnd.wap.wml';
	$ct['wmls'] = 'text/vnd.wap.wmlscript';
	$ct['xsl'] = 'text/xml';
	$ct['xml'] = 'text/xml';
	
	return isset($ct[strtolower($extension)]) ? $ct[strtolower($extension)] : 'text/html';
}

//------------------------------------------------------------------
// Functions added by Valery Votintsev (vot) at codersclub.org

/**
 * Unix Style Dir Name
 *
 * @param string $file //original path
 * @param boolean $remove_drive //If need to remove the Windows-like drive, i.e. C:\windows\system32\...
 * @return unix style path
 * @author Valery Votintsev, codersclub.org
 */
function udir($file='', $remove_drive = false) {
  $file = str_replace('\\','/',$file);
  if($remove_drive) {
    $file = preg_replace("/^\w:/",'',$file);
  }
  return $file;
}


/**
 * Load Language File
 *
 * @param string $model //Language File Name
 * @return none
 * @author Valery Votintsev, codersclub.org
 */
function load_language($model='') {
  global $LANGUAGE;

//DEBUG
//echo '<pre>';
//echo 'load_language:', "\n";
//echo '	model=', $model, "\n";
//echo '</pre>';

  if(!isset($LANGUAGE)) {$LANGUAGE = array()};

  if($model) {
    $file = EMLOG_ROOT.'/lang/'.EMLOG_LANGUAGE.'/lang_'.$model.'.php';
//DEBUG
//echo '<pre>';
//echo '	file=', $file, "\n";
//echo '</pre>';

    if(is_file($file)) {

      $lang = array();
      @require_once $file;

      // Language file must contain $lang = array(...);
      $LANGUAGE = array_merge($LANGUAGE, $lang);

      unset($lang);
    }
  }
}

/**
 * Return Language Variable
 *
 * @param string $key //Language Keyword
 * @return string //Language Value
 * @author Valery Votintsev, codersclub.org
 */
function lang($key='') {
  global $LANGUAGE;
  return isset($LANGUAGE[$key]) ? $LANGUAGE[$key] : '{'.$key.'}';
}

