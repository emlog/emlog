<?php

/**
 * Basic Function library
 * @package EMLOG (www.emlog.net)
 */
function emAutoload($class) {
	$class = strtolower($class);
	if (file_exists(EMLOG_ROOT . '/include/model/' . $class . '.php')) {
/*vot*/        load_language($class);
		require_once(EMLOG_ROOT . '/include/model/' . $class . '.php');
	} elseif (file_exists(EMLOG_ROOT . '/include/lib/' . $class . '.php')) {
		require_once(EMLOG_ROOT . '/include/lib/' . $class . '.php');
	} elseif (file_exists(EMLOG_ROOT . '/include/controller/' . $class . '.php')) {
		require_once(EMLOG_ROOT . '/include/controller/' . $class . '.php');
	} else {
/*vot*/        emMsg($class . lang('_load_failed'));
	}
}

/**
 * HTML code conversion function
 *
 * @param unknown_type $content
 * @param unknown_type $wrap = Do wrap
 * @return string
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
 * Get User Ip
 */
function getIp() {
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if (!filter_var($ip, FILTER_VALIDATE_IP)) {
		$ip = '';
	}
	return $ip;
}

/**
 * Get site URL (Only for the root directory script, currently used only for home ajax request)
 */
function getBlogUrl() {
	$phpself = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '';
	if (preg_match("/^.*\//", $phpself, $matches)) {
		return 'http://' . $_SERVER['HTTP_HOST'] . $matches[0];
	} else {
		return BLOG_URL;
	}
}

/**
 * Get the current access base url
 */
function realUrl() {
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
	$real_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
	$real_url .= $_SERVER["SERVER_NAME"];
	$real_url .= in_array($_SERVER['SERVER_PORT'], array(80, 443)) ? '' : ':' . $_SERVER['SERVER_PORT'];
	$real_url .= $best_match;

	return $real_url;
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
 * Check Plugin
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
			echo '<script src="' . BLOG_URL . 'include/lib/js/jquery/jquery-1.7.1.js" type="text/javascript"></script>';
		}

	}
}

/**
 * Validate email address format
 */
function checkMail($email) {
	if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && strlen($email) <= 60) {
		return true;
	} else {
		return false;
	}
}

/**
 * Get utf8 substring
 *
 * @param string $strings //source string 
 * @param int $start //start position, eg:0
 * @param int $length //substring length
 */
function subString($strings, $start, $length) {
	if (function_exists('mb_substr') && function_exists('mb_strlen')) {
		$sub_str = mb_substr($strings, $start, $length, 'utf8');
		return mb_strlen($sub_str, 'utf8') < mb_strlen($strings, 'utf8') ? $sub_str . '...' : $sub_str;
	}
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0, $iMax = strlen($str); $i < $iMax; $i++) {
		if (ord($str[$i]) >= 128)
			$char++;
	}
	$str2 = substr($strings, $start, $length + 1);
	$str3 = substr($strings, $start, $length + 2);
	if ($char % 3 == 1) {
		if ($length <= strlen($strings)) {
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char % 3 == 2) {
		if ($length <= strlen($strings)) {
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char % 3 == 0) {
		if ($length <= strlen($strings)) {
			$str = $str .= '...';
		}
		return $str;
	}
}

/**
 * Extract plain text from html content
 *
 * @param string $data
 * @param int $len
 */
function extractHtmlData($data, $len) {
	$data = subString(strip_tags($data), 0, $len + 30);
	$search = array(
		"/([\r\n])[\s]+/", // Remove whitespace characters
		"/&(quot|#34);/i", // Replace HTML entities
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
 * Convert Attachment size unit
 *
 * @param string $fileSize //File Size kb
 */
function changeFileSize($fileSize) {
	if ($fileSize >= 1073741824) {
		$fileSize = round($fileSize / 1073741824, 2) . ' GB';
	} elseif ($fileSize >= 1048576) {
		$fileSize = round($fileSize / 1048576, 2) . ' MB';
	} elseif ($fileSize >= 1024) {
		$fileSize = round($fileSize / 1024, 2) . ' KB';
	} else {
/*vot*/        $fileSize .= lang('_bytes');
	}
	return $fileSize;
}

/**
 * Get the file name suffix
 */
function getFileSuffix($fileName) {
	return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
}

/**
 * Pagination Function
 *
 * @param int $count The total number of entries
 * @param int $perlogs The number of articles per page
 * @param int $page The current page number
 * @param string $url Page address
 * @return string
 */
function pagination($count, $perlogs, $page, $url, $anchor = '') {
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
/*vot*/        $re = "<a href=\"{$urlHome}$anchor\" title=\"".lang('first_page')."\">&laquo;</a><em> ... </em>$re";
	if ($page + 5 < $pnums)
/*vot*/        $re .= "<em> ... </em> <a href=\"$url$pnums$anchor\" title=\"".lang('last_page')."\">&raquo;</a>";
	if ($pnums <= 1)
		$re = '';
	return $re;
}

/**
 * Plug-in function call, mounted plug-in function to a hook on the reserved
 *
 * @param string $hook
 * @param string $actionFunc
 * @return boolearn
 */
function addAction($hook, $actionFunc) {
    // Use global variables to store plug-in functions mounted on the mount point
	global $emHooks;
	if (!isset($emHooks[$hook]) || !in_array($actionFunc, $emHooks[$hook])) {
		$emHooks[$hook][] = $actionFunc;
	}
	return true;
}

/**
 * Implementation of the hanging hook function, support multi-parameter eg:doAction('post_comment', $author, $email, $url, $comment);
 *
 * @param string $hook
 */
function doAction($hook) {
	global $emHooks;
	$args = array_slice(func_get_args(), 1);
	if (isset($emHooks[$hook])) {
		foreach ($emHooks[$hook] as $function) {
			call_user_func_array($function, $args);
		}
	}
}

/**
 * Post split
 *
 * @param string $content Post Content
 * @param int $lid Post id
 */
function breakLog($content, $lid) {
	$ret = explode('[break]', $content, 2);
	if (!empty($ret[1])) {
/*vot*/        $ret[0] .= '<p class="readmore"><a href="' . Url::log($lid) . '">'.lang('read_more').'</a></p>';
		return $ret[0];
	} elseif (Option::get('isexcerpt') == 'y') {
/*vot*/        return subString(trim(strip_tags($content)), 0, Option::get('excerpt_subnum')) . '<p class="readmore"><a href="' . Url::log($lid) . '">'.lang('read_more').'</a></p>';
	} else {
		return $content;
	}
}

/**
 * Time transformation function
 *
 * @param $now
 * @param $datetemp
 * @param $dstr
 * @return string
 */
function smartDate($datetemp, $dstr = 'Y-m-d H:i') {
	$op = '';
	$sec = time() - $datetemp;
	$hover = floor($sec / 3600);
	if ($hover == 0) {
		$min = floor($sec / 60);
		if ($min == 0) {
/*vot*/     $op = $sec . lang('_sec_ago');
		} else {
/*vot*/     $op = $min . lang('_min_ago');
		}
	} elseif ($hover < 24) {
/*vot*/     $op = lang('about_') . $hover . lang('_hour_ago');
	} else {
		$op = date($dstr, $datetemp);
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
		$randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $randStr;
}

/**
 * Looking for all the different elements of the two arrays
 */
function findArray($array1, $array2) {
	$r1 = array_diff($array1, $array2);
	$r2 = array_diff($array2, $array1);
	$r = array_merge($r1, $r2);
	return $r;
}

function uploadFile($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon = false, $is_thumbnail = true) {
	$result = upload($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon, $is_thumbnail);
	switch ($result) {
		case '100':
/*vot*/     emMsg(lang('file_size_exceeds_system') . ini_get('upload_max_filesize') . lang('_limit'));
			break;
		case '101':
/*vot*/     emMsg(lang('upload_failed_error_code') . $errorNum);
			break;
		case '102':
/*vot*/     emMsg(lang('file_type_not_supported'));
			break;
		case '103':
			$ret = changeFileSize(Option::getAttMaxSize());
/*vot*/     emMsg(lang('file_size_exceeds_') . $ret . lang('_of_limit'));
			break;
		case '104':
/*vot*/     emMsg(lang('upload_folder_create_error'));
			break;
		case '105':
/*vot*/     emMsg(lang('upload_folder_unwritable'));
			break;
		default:
			return $result;
			break;
	}
}

//Use for Attachment Bulk Upload
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
 * File Upload
 *
 * returned Array of indexes
 * mime_type File Type
 * size      File Size (in KB)
 * file_path File Path
 * width     Width
 * height    Height
 * Optional values (Only if the is an image and the system have to make a thjumbnail)
 * thum_file   Thumbnail path
 * thum_width  Thumbnail Width
 * thum_height Thumbnail height
 * thum_size   Thumbnail size (in KB)
 *
 * @param string $fileName File Name
 * @param string $errorNum Error code: $_FILES['error']
 * @param string $tmpFile Temporary File Uploaded
 * @param string $fileSize File Size KB
 * @param array $type Allowed to upload file types
 * @param boolean $isIcon Whether it is the avatar uploaded
 * @param boolean $is_thumbnail Whether to generate thumbnail
 * @return array File Data Index
 * 
 */
function upload($fileName, $errorNum, $tmpFile, $fileSize, $type, $isIcon = false, $is_thumbnail = true) {
	if ($errorNum == 1) {
        return '100'; //File size exceeds the system limit
	} elseif ($errorNum > 1) {
        return '101'; //File upload failed
	}
	$extension = getFileSuffix($fileName);
	if (!in_array($extension, $type)) {
        return '102'; //Incorrect file type
	}
	if ($fileSize > Option::getAttMaxSize()) {
        return '103'; //File size exceeds the emlog limit
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
            return '104'; //Create the file upload directory failed
		}
	}
	if (!is_dir($uppath)) {
		@umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false) {
            return '105'; //Upload failed. File upload directory (content/uploadfile) is not writable
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
			resizeImage($tmpFile, $uppath . 'thum70-' . $fname, 70, 70);
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
            return '105'; //Upload failed. File upload directory (content/uploadfile) is not writable
		}
		@chmod($attachpath, 0777);
	}

    // If the attachment is an image, then need to extract the width and height
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
 * Generate thumbnail image
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
 * Image Crop & Resize
 *
 * @param string $src_image Original image
 * @param string $dst_path Cropped Image save path
 * @param int $dst_x New image coordinates x
 * @param int $dst_y New image coordinates y
 * @param int $src_x Original coordinates x
 * @param int $src_y Original coordinates y
 * @param int $dst_w New image width
 * @param int $dst_h New image height
 * @param int $src_w Original width
 * @param int $src_h Original height
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
 * Proportional image zoom size
 *
 * @param string $img Image Path
 * @param int $max_w Max zoom Width
 * @param int $max_h Maximum zoom Height
 * @return array
 */
function chImageSize($img, $max_w, $max_h) {
	$size = @getimagesize($img);
	$w = $size[0];
	$h = $size[1];
    //Calculate zoom ratio
	@$w_ratio = $max_w / $w;
	@$h_ratio = $max_h / $h;
    //Verify the Image width and height
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
/*vot*/ $avatar = "http://www.gravatar.com/avatar/$hash?s=$s&d=$d&r=$g";
	return $avatar;
}

/**
 * Calculate time zone difference
 * @param string $remote_tz Remote time zone
 * @param string $origin_tz Original time zone
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
 * Gets a number of days of the specified month
 */
function getMonthDayNum($month, $year) {
	$month = (int)$month;
	$year = (int)$year;

	$months_map = array(1 => 31, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);
	if (array_key_exists($month, $months_map)) {
		return $months_map[$month];
	} else {
		if ($year % 100 === 0) {
			if ($year % 400 === 0) {
				return 29;
			} else {
				return 28;
			}
		} else if ($year % 4 === 0) {
			return 29;
		} else {
			return 28;
		}
	}
}

/**
 * Extract zip
 * @param type $zipfile Original Zip File
 * @param type $path Extract to the directory
 * @param type $type
 * @return int
 */
function emUnZip($zipfile, $path, $type = 'tpl') {
	if (!class_exists('ZipArchive', FALSE)) {
        return 3;//zip Module problem
	}
	$zip = new ZipArchive();
	if (@$zip->open($zipfile) !== TRUE) {
        return 2;//File permissions problem
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
        return 1;//File permissions problem
	}
}

/**
 * zip Compression
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
 * Get Remote File
 * @param type $source Remote file address
 * @return Temporary file address
 */
function emFecthFile($source) {
	$temp_file = tempnam('/tmp', 'emtemp_');
	$rh = fopen($source, 'rb');
	$wh = fopen($temp_file, 'w+b');
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
 * Deleting a file or directory
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
 * Page Redirection
 */
function emDirect($directUrl) {
	header("Location: $directUrl");
	exit;
}

/**
 * Display system info
 *
 * @param string $msg Message
 * @param string $url Return Address
 * @param boolean $isAutoGo Whether or not auto-return true false
 */
function emMsg($msg, $url = 'javascript:history.back(-1);', $isAutoGo = false) {
	if ($msg == '404') {
		header("HTTP/1.1 404 Not Found");
/*vot*/        $msg = lang('404_description');
	}
/*vot*/    $lang = EMLOG_LANGUAGE;
/*vot*/    $dir  = EMLOG_LANGUAGE_DIR;
/*vot*/    echo <<<EOT
<!DOCTYPE html>
<html dir="$dir" lang="$lang">
<head>
EOT;
	if ($isAutoGo) {
		echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
	}
/*vot*/ $title = lang('prompt');
	echo <<<EOT
<meta charset="utf-8">
<title>$title</title>
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
/*vot*/        echo '<p><a href="' . $url . '">'. lang('click_return').'</a></p>';
	}
	echo <<<EOT
</div>
</body>
</html>
EOT;
	exit;
}

/**
 * Show error 404 page
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
 * Replace Emoticons
 *
 * @param $t
 */
function emoFormat($t) {
/*vot*/    require_once(EMLOG_ROOT . '/admin/views/js/emo.php'); //$emos = array(code=>image,...);
	if (!empty($t) && preg_match_all('/\[.+?\]/', $t, $matches)) {
		$matches = array_unique($matches[0]);
		foreach ($matches as $data) {
			if (isset($emos[$data]))
				$t = str_replace($data, '<img title="' . $data . '" src="' . BLOG_URL . 'admin/editor/plugins/emoticons/images/' . $emos[$data] . '"/>', $t);
		}
	}
	return $t;
}

/**
 * hmac Encryption
 *
 * @param unknown_type $algo hash Algorithm md5
 * @param unknown_type $data User name and expiration date
 * @param unknown_type $key
 * @return unknown
 */
if (!function_exists('hash_hmac')) {
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
 * Get the MIME type based on the file extension
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

/**
 * Convert a string to a time zone independent UNIX timestamp
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
					 * But the time we pass in is actually the local time of the time zone configured by the blog, not the local time of the server time zone
					 * Therefore, we need to subtract / add the time difference between the two time zones to get the UTC time.
					 */
					$offset = getTimeZoneOffset($serverTimeZone);
					// First subtract/add the time difference configured by the local time zone
					$unixPostDate -= $timezone * 3600;
					// Then subtract/add the time difference between the server time zone and UTC to get the UTC time.
					$unixPostDate -= $offset;
				}
			}
		}
		return $unixPostDate;
	} else {
		return false;
	}
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
  global $LANGLIST;

    $model = strtolower($model);
    $model = str_replace('_controller','',$model);
    $model = str_replace('_model','',$model);

//DEBUG
//echo '<pre>';
//echo 'load_language:', "\n";
//echo '    model=', $model, "\n";
//echo '</pre>';

  if(!isset($LANGUAGE)) {$LANGUAGE = array();}
  if(!isset($LANGLIST)) {$LANGLIST = array();}

/*vot*/  if($model && !isset($LANGLIST[$model])) {

    $file = EMLOG_ROOT.'/lang/'.EMLOG_LANGUAGE.'/lang_'.$model.'.php';

//DEBUG
//echo '<pre>';
//echo '    file=', $file, "\n";
//if(!is_file($file)) {
//  echo '    file NOT FOUND!', "\n";
//}
//echo '</pre>';

    if(is_file($file)) {

      $lang = array();
      $ok = @require_once $file;

      // Language file must contain $lang = array(...);
      $LANGUAGE = array_merge($LANGUAGE, $lang);

      unset($lang);

      $LANGLIST[$model] = 1;

//DEBUG
//echo '<pre>';
//echo '    require_ok=', intval($ok), "\n";
//echo '    key number=', count($LANGUAGE), "\n";
//echo 'LANGUAGE=';
//print_r($LANGUAGE);
//echo '</pre>';

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

/**
 * Return the date/time formatted
 *
 * @param integer $date Source date
 * @param boolean $show_time Show time or not
 * @return string Formatted date
 * @author Valery Votintsev, codersclub.org
 */
function emdate($date=0, $show_time=0) {

  $format = $show_time ? 'date_time_format' : 'date_format';

  return gmdate(lang($format), $date);
}

// Load the core Lang File
/*vot*/ load_language('core');
