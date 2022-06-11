<?php
/**
 * Basic function library
 * @package EMLOG
 * @link https://www.emlog.net
 */

t();

function emAutoload($class) {
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
 * 转换HTML代码函数
 *
 * @param unknown_type $content
 * @param unknown_type $wrap 是否换行
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
 * 获取用户ip地址
 */
function getIp() {
	$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
	if (!filter_var($ip, FILTER_VALIDATE_IP)) {
		$ip = '';
	}
	return $ip;
}

/**
 * 获取站点地址(仅限根目录脚本使用,目前仅用于首页ajax请求)
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
 * 获取当前访问的base url
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
function checkMail($email) {
	if (preg_match("/^[\w\.\-]+@\w+([\.\-]\w+)*\.\w+$/", $email) && strlen($email) <= 60) {
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
 * 从可能包含html标记的内容中萃取纯文本摘要
 *
 * @param string $data
 * @param int $len
 */
function extractHtmlData($data, $len) {
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
function changeFileSize($fileSize) {
	if ($fileSize >= 1073741824) {
		$fileSize = round($fileSize / 1073741824, 2) . ' GB';
	} elseif ($fileSize >= 1048576) {
		$fileSize = round($fileSize / 1048576, 2) . ' MB';
	} elseif ($fileSize >= 1024) {
		$fileSize = round($fileSize / 1024, 2) . ' KB';
	} else {
		$fileSize .= ' 字节';
	}
	return $fileSize;
}

/**
 * 获取文件名后缀
 */
function getFileSuffix($fileName) {
	return strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
}

/**
 * 将相对路径转换为完整URL，eg：../content/uploadfile/xxx.jpeg
 * @param $filePath
 * @return string
 */
function getFileUrl($filePath) {
	if (!stristr($filePath, 'http')) {
		return BLOG_URL . substr($filePath, 3);
	}
	return $filePath;
}

/**
 * 去除url的参数
 */
function rmUrlParams($url) {
	$urlInfo = explode("?", $url);
	if (empty($urlInfo[0])) {
		return $url;
	}
	return $urlInfo[0];
}

/**
 * 根据文件名后缀判断是否图片
 */
function isImage($mimetype) {
	if (strstr($mimetype, "image")) {
		return true;
	}
	return false;
}

/**
 * 根据文件名后缀判断是否视频
 */
function isVideo($fileName) {
	$suffix = getFileSuffix($fileName);
	if ($suffix == 'mp4') {
		return true;
	}
	return false;
}

/**
 * 根据文件名后缀判断是否压缩包
 */
function isZip($fileName) {
	$suffix = getFileSuffix($fileName);
	if (in_array($suffix, ['zip', 'rar'])) {
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
function pagination($count, $perlogs, $page, $url, $anchor = '') {
	$pnums = @ceil($count / $perlogs);
	$re = '';
	$urlHome = preg_replace("|[\?&/][^\./\?&=]*page[=/\-]|", "", $url);
	for ($i = $page - 5; $i <= $page + 5 && $i <= $pnums; $i++) {
		if ($i <= 0) {
			continue;
		}
		if ($i == $page) {
			$re .= " <span>$i</span> ";
		} elseif ($i == 1) {
			$re .= " <a href=\"$urlHome$anchor\">$i</a> ";
		} else {
			$re .= " <a href=\"$url$i$anchor\">$i</a> ";
		}
	}
	if ($page > 6)
		$re = "<a href=\"{$urlHome}$anchor\" title=\"首页\">&laquo;</a><em> ... </em>$re";
	if ($page + 5 < $pnums)
		$re .= "<em> ... </em> <a href=\"$url$pnums$anchor\" title=\"尾页\">&raquo;</a>";
	if ($pnums <= 1)
		$re = '';
	return $re;
}

/**
 * 该函数在插件中调用,挂载插件函数到预留的钩子上
 *
 * @param string $hook
 * @param string $actionFunc
 * @return boolearn
 */
function addAction($hook, $actionFunc) {
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
 * 挂载执行方式2（单次接管式挂载）：执行挂在钩子上的第一个函数,仅执行行一次，接收输入input，且会修改传入的变量$ret
 * eg：接管文件上传函数，将上传本地改为上传云端
 */
function doOnceAction($hook, $input, &$ret) {
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
function doMultiAction($hook, $input, &$ret) {
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
function subContent($content, $len, $clean = 0) {
	if ($clean) {
		$content = strip_tags($content);
	}
	return subString($content, 0, $len);
}

/**
 * 时间转化函数
 *
 * @param $datetemp
 * @param $dstr
 * @return string
 */
function smartDate($datetemp, $dstr = 'Y-m-d H:i') {
	$sec = time() - $datetemp;
	$hover = floor($sec / 3600);
	if ($hover == 0) {
		$min = floor($sec / 60);
		if ($min == 0) {
			$op = $sec . ' 秒前';
		} else {
			$op = "$min 分钟前";
		}
	} elseif ($hover < 24) {
		$op = "约 {$hover} 小时前";
	} else {
		$op = date($dstr, $datetemp);
	}
	return $op;
}

/**
 * 生成一个随机的字符串
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
 * 上传文件到当前服务器
 * @param $attach array 文件FILE信息
 * @param $result array 上传结果
 */
function upload2local($attach, &$result) {
	$fileName = $attach['name'];
	$errorNum = $attach['error'];
	$tmpFile = $attach['tmp_name'];
	$fileSize = $attach['size'];

	$isthum = Option::get('isthumbnail') === 'y';
	$fileName = Database::getInstance()->escape_string($fileName);
	$type = Option::getAttType();

	$ret = upload($fileName, $errorNum, $tmpFile, $fileSize, $type, $isthum);
	$success = 0;
	switch ($ret) {
		case '100':
			$message = '文件大小超过系统' . ini_get('upload_max_filesize') . '限制';
			break;
		case '101':
		case '104':
			$message = '上传文件失败,错误码：' . $errorNum;
			break;
		case '102':
			$message = '错误的文件类型';
			break;
		case '103':
			$r = changeFileSize(Option::getAttMaxSize());
			$message = "文件大小超出{$r}的限制";
			break;
		case '105':
			$message = '上传失败。文件上传目录(content/uploadfile)不可写';
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
 * @param string $errorNum 错误码：$_FILES['error']
 * @param string $tmpFile 上传后的临时文件
 * @param string $fileSize 文件大小 KB
 * @param array $type 允许上传的文件类型
 * @param boolean $is_thumbnail 是否生成缩略图
 * @return array 文件数据 索引
 *
 */
function upload($fileName, $errorNum, $tmpFile, $fileSize, $type, $is_thumbnail = true) {
	if ($errorNum == 1) {
		return '100'; //文件大小超过系统限制
	} elseif ($errorNum > 1) {
		return '101'; //上传文件失败
	}
	$extension = getFileSuffix($fileName);
	if (!in_array($extension, $type)) {
		return '102'; //错误的文件类型
	}
	if ($fileSize > Option::getAttMaxSize()) {
		return '103'; //文件大小超出emlog的限制
	}
	$file_info = [];
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
			return '104'; //创建文件上传目录失败
		}
	}
	if (!is_dir($uppath)) {
		@umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false) {
			return '105'; //上传失败。文件上传目录(content/uploadfile)不可写
		}
	}
	doAction('attach_upload', $tmpFile);

	// 生成缩略图
	$thum = $uppath . 'thum-' . $fname;
	if ($is_thumbnail && resizeImage($tmpFile, $thum, Option::get('att_imgmaxw'), Option::get('att_imgmaxh'))) {
		$file_info['thum_file'] = $thum;
	}

	if (@is_uploaded_file($tmpFile) && @!move_uploaded_file($tmpFile, $attachpath)) {
		@unlink($tmpFile);
		return '105'; //上传失败。文件上传目录(content/uploadfile)不可写
	}

	// 提取图片宽高
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
 * 图片生成缩略图
 *
 * @param string $img 预缩略的图片
 * @param string $thum_path 生成缩略图路径
 * @param int $max_w 缩略图最大宽度 px
 * @param int $max_h 缩略图最大高度 px
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
 * 按比例计算图片缩放尺寸
 *
 * @param string $img 图片路径
 * @param int $max_w 最大缩放宽
 * @param int $max_h 最大缩放高
 * @return array
 */
function chImageSize($img, $max_w, $max_h) {
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
 * 获取Gravatar头像，使用Gravatar国内镜像源：极客族公共加速服务 https://cdn.geekzu.org/donate.html
 * http://en.gravatar.com/site/implement/images/
 */
function getGravatar($email, $s = 40) {
	$hash = md5($email);
	return "//sdn.geekzu.org/avatar/$hash?s=$s";
}

/**
 * 获取指定月份的天数
 */
function getMonthDayNum($month, $year) {
	$month = (int)$month;
	$year = (int)$year;

	$months_map = array(1 => 31, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31);
	if (array_key_exists($month, $months_map)) {
		return $months_map[$month];
	}

	if ($year % 100 === 0) {
		if ($year % 400 === 0) {
			return 29;
		}
		return 28;
	}

	if ($year % 4 === 0) {
		return 29;
	}

	return 28;
}

/**
 * 解压zip
 * @param type $zipfile 要解压的文件
 * @param type $path 解压到该目录
 * @param type $type
 * @return int
 */
function emUnZip($zipfile, $path, $type = 'tpl') {
	if (!class_exists('ZipArchive', FALSE)) {
		return 3;//zip模块问题
	}
	$zip = new ZipArchive();
	if (@$zip->open($zipfile) !== TRUE) {
		return 2;//文件权限问题
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
 * zip压缩
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
	}

	return false;
}

/**
 * Download remote files
 * @param string $source file url
 * @return string Temporary file path
 */
function emFetchFile($source) {
	$temp_file = tempnam(EMLOG_ROOT . '/content/cache/', 'tmp_');
	$wh = fopen($temp_file, 'w+b');

	$r = parse_url($source);
	if (isset($r['host']) && sha1($r['host']) !== '1ca2f71c0b27a1c6dbbf1583dc4d4e422b0683ac') {
		return FALSE;
	}

	$ctx_opt = set_ctx_option();
	$ctx = stream_context_create($ctx_opt);
	$rh = fopen($source, 'rb', false, $ctx);

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
function emDownFile($source) {
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

function set_ctx_option(): array {
	$data = http_build_query(['emkey' => Option::get('emkey')]);
	return [
		'http' => [
			'timeout' => 120,
			'method'  => 'POST',
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n"
				. "Content-Length: " . strlen($data) . "\r\n"
				. "Referer: " . BLOG_URL . "\r\n"
				. "User-Agent: emlog " . Option::EMLOG_VERSION . "\r\n",
			'content' => $data
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
 * 页面跳转
 */
function emDirect($directUrl) {
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
function emMsg($msg, $url = 'javascript:history.back(-1);', $isAutoGo = false) {
	if ($msg == '404') {
		header("HTTP/1.1 404 Not Found");
		$msg = '抱歉，你所请求的页面不存在！';
	}
	echo <<<EOT
<!doctype html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
EOT;
	if ($isAutoGo) {
		echo "<meta http-equiv=\"refresh\" content=\"2;url=$url\" />";
	}
	echo <<<EOT
<title>提示信息</title>
<style>
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
</style>
</head>
<body>
<div class="main">
<p>$msg</p>
EOT;
	if ($url != 'none') {
		echo '<p><a href="' . $url . '">&larr;点击返回</a></p>';
	}
	echo <<<EOT
</div>
</body>
</html>
EOT;
	exit;
}

function show_404_page($show_404_only = false) {
	if ($show_404_only) {
		header("HTTP/1.1 404 Not Found");
		exit;
	} elseif (is_file(TEMPLATE_PATH . '404.php')) {
		header("HTTP/1.1 404 Not Found");
		include View::getView('404');
		exit;
	} else {
		emMsg('404', BLOG_URL);
	}
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
 * 根据文件后缀获取其mine类型
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
 * 将字符串转换为时区无关的UNIX时间戳
 */
function emStrtotime($timeStr) {
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

function t() {
	if (mt_rand(1, 5) !== 5) {
		return true;
	}
	$a = sha1_file(EMLOG_ROOT . '/include/lib/emcurl.php');
	if ($a !== '0f85f470fdd9032ff164f50141771e0ba47d0015') {
		exit;
	}
}

/**
 * 计算时区的时差
 * @param string $remote_tz 远程时区
 * @param string $origin_tz 标准时区
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
 * 上传裁剪后的图片（封面、头像）
 */
function uploadCropImg() {
	$attach = $_FILES['image'] ?? '';
	if (!$attach || $attach['error'] === 4) {
		echo "error";
		exit;
	}

	$ret = '';
	upload2local($attach, $ret);
	if (empty($ret['success'])) {
		echo "error";
		exit;
	}
	return $ret;
}
