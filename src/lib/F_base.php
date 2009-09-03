<?php
/**
 * Miscellaneous Functions
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

/**
 * Load template file
 *
 * @param string $template Template Name
 * @param string $ext Template suffix
 * @return string Template path
 */
function getViews($template, $ext = '.php')
{
	global $lang;
	if (!is_dir(TPL_PATH))
	{
		exit($lang['template_path_error']);
	}
	$path = TPL_PATH.$template.$ext;
	return $path;
}

/**
 * Remove of escaped characters
 *
 */
function doStripslashes()
{
	if (get_magic_quotes_gpc())
	{
		$_GET = stripslashesDeep($_GET);
		$_POST = stripslashesDeep($_POST);
		$_COOKIE = stripslashesDeep($_COOKIE);
		$_REQUEST = stripslashesDeep($_REQUEST);
	}
}

/**
 * Recursive removal of escaped characters
 *
 * @param unknown_type $value
 * @return unknown
 */
function stripslashesDeep($value)
{
	$value = is_array($value) ? array_map('stripslashesDeep', $value) : stripslashes($value);
	return $value;
}

/**
 * Clean HTML code
 *
 * @param unknown_type $content
 * @param unknown_type $wrap Do wrap
 * @return unknown
 */
function htmlClean($content, $wrap=true)
{
	$content = htmlspecialchars($content);
	if($wrap)
	{
		$content = str_replace("\n", '<br>', $content);
	}
	$content = str_replace('  ', '&nbsp;&nbsp;', $content);
	$content = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $content);
	return $content;
}

/**
 * Get User IP
 *
 * @return string
 */
function getIp()
{
	if (isset($_SERVER))
	{
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
	} else {
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('HTTP_CLIENT_IP')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} else {
			$ip = getenv('REMOTE_ADDR');
		}
	}
	if(!preg_match("/^\d+\.\d+\.\d+\.\d+$/", $ip))
	{
		$ip = '';
	}
	return $ip;
}

/**
 * Get Statistics
 *
 */
function viewCount()
{
	global $CACHE,$viewcount_day,$viewcount_all,$viewcount_date,$DB,$localdate;
	$userip = getIp();
	$em_viewip = isset($_COOKIE['em_viewip']) ? $_COOKIE['em_viewip'] : '';
	if ($em_viewip != $userip)
	{
		$ret = setcookie('em_viewip', getIp(), $localdate + (12*3600));
		if ($ret)
		{
			$curtime = date('Y-m-d', $localdate);
			if ($viewcount_date != $curtime)
			{
				$DB->query('UPDATE '.DB_PREFIX."options SET option_value ='$curtime' where option_name='viewcount_date'");
				$DB->query('UPDATE '.DB_PREFIX."options SET option_value ='1' where option_name='viewcount_day'");
			} else {
				$DB->query('UPDATE '.DB_PREFIX."options SET option_value =option_value+1 where option_name='viewcount_day'");
			}
			$DB->query('UPDATE '.DB_PREFIX."options SET option_value =option_value+1 where option_name='viewcount_all'");
			$CACHE->mc_options();
		}
	}
}

/**
 * Validate email address format
 *
 * @param unknown_type $address
 * @return unknown
 */
function checkMail($address)
{
	if (preg_match("/^[_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3}$/",$address))
	{
		return true;
	} else {
		return false;
	}
}

/**
 * SUbstring of utf8 encoded string
 *
 * @param string $strings Source string
 * @param int $start Start position, eg: 0
 * @param int $length Substring length
 * @return unknown
 */
function subString($strings,$start,$length)
{
	$str = substr($strings, $start, $length);
	$char = 0;
	for ($i = 0; $i < strlen($str); $i++)
	{
		if (ord($str[$i]) >= 128)
		$char++;
	}
	$str2 = substr($strings, $start, $length+1);
	$str3 = substr($strings, $start, $length+2);
	if ($char % 3 == 1)
	{
		if ($length <= strlen($strings))
		{
			$str3 = $str3 .= '...';
		}
		return $str3;
	}
	if ($char%3 == 2)
	{
		if ($length <= strlen($strings))
		{
			$str2 = $str2 .= '...';
		}
		return $str2;
	}
	if ($char%3 == 0)
	{
		if ($length <= strlen($strings))
		{
			$str = $str .= '...';
		}
		return $str;
	}
}

/**
 * Convert Attachment size units
 *
 * @param string $filesize File Size kb
 * @return unknown
 */
function changeFileSize($filesize)
{
	global $lang;

	if($filesize >= 1073741824)
	{
		$filesize = round($filesize / 1073741824  ,2) . 'GB';
	} elseif($filesize >= 1048576){
		$filesize = round($filesize / 1048576 ,2) . 'MB';
	} elseif($filesize >= 1024){
		$filesize = round($filesize / 1024, 2) . 'KB';
	} else{
		$filesize = $filesize . ' '.$lang['bytes'];
	}
	return $filesize;
}

/**
 * Pagination Function
 *
 * @param int $count The total number of entries
 * @param int $perlogs The number of articles per page
 * @param int $page The current page number
 * @param string $url Page URL
 * @return unknown
 */
function pagination($count,$perlogs,$page,$url)
{
	global $lang;
	$pnums = @ceil($count / $perlogs);
	$re = '';
	for ($i = $page-5;$i <= $page+5 && $i <= $pnums; $i++)
	{
		if ($i > 0)
		{
			if ($i == $page)
			{
				$re .= " <span>$i</span> ";
			} else {
				$re .= " <a href=\"$url=$i\">$i</a> ";
			}
		}
	}
	if ($page > 6) $re = "<a href=\"$url=1\" title=\"".$lang['first_page']."\">&laquo;</a> ... $re";
	if ($page + 5 < $pnums) $re .= "... <a href=\"$url=$pnums\" title=\"".$lang['last_page']."\">&raquo;</a>";
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
function addAction($hook, $actionFunc)
{
	global $emHooks;
	if (!@in_array($actionFunc, $emHooks[$hook]))
	{
		$emHooks[$hook][] = $actionFunc;
	}
	return true;
}

/**
 * Execute the hook function, support multiple parameters eg:doAction('post_comment', $author, $email, $url, $comment);
 *
 * @param string $hook
 */
function doAction($hook)
{
	global $emHooks;

	$args = array_slice(func_get_args(), 1);

	if (isset($emHooks[$hook]))
	{
		foreach ($emHooks[$hook] as $function)
		{
			$string = call_user_func_array($function, $args);
		}
	}
}

/**
 * Change the image size according to the proportion (not generating thumbnails)
 *
 * @param string $img Image path
 * @param int $max_w Max width
 * @param int $max_h Max height
 * @return unknown
 */
function chImageSize ($img,$max_w,$max_h)
{
	$size = @getimagesize($img);
	$w = $size[0];
	$h = $size[1];

	//Calculate the scaling
	@$w_ratio = $max_w / $w;
	@$h_ratio =	$max_h / $h;

	//Decide what to do with widh and height
	if( ($w <= $max_w) && ($h <= $max_h) )
	{
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
 * Change the ratio of image attachment for template
 *
 * @param string $attstr Attachment string in cache
 * @param int $width New width
 * @param int $height New height
 * @return unknown
 */
function getAttachment($attstr,$width,$height)
{
	$re = '';
	if (!empty($attstr)) {
		$att_array = explode("</a>",$attstr);
		foreach ($att_array as $value) {
			if (preg_match("/.+src=\"(.+)\" width=.+/i",$value,$imgpath))
			{
				$image = "./".$imgpath[1];
				$size = chImageSize($image,$width,$height);
				$attsize = "width=\"".$size['w']."\" height=\"".$size['h']."\"";
				$t = preg_replace("/width=\"[0-9]{3}\" height=\"[0-9]{3}\"/",$attsize,$value);
				$re .= $t .'</a>';
			}
		}
		return $re;
	} else {
		return '';
	}
}

/**
 * Clear the template comments and complete URL optimization
 *
 */
function cleanPage($beUrlRewrite = false)
{
	global $isurlrewrite,$isgzipenable,$searchlink,$replacelink;
	$output = str_replace(array('?>','<?php',"<?php\r\n?>"),array('','',''),ob_get_contents());
	if($beUrlRewrite)
	{
		if ($isurlrewrite == 'y' )
		{
			$searchlink = "/href\=\"(index\.php|\.\/|\.\/index.php)\?(post|record|sort|author|page|tag)=(\d+|[%+-_A-Za-z0-9]+)(#*[\w]*)\"/i";
			$replacelink = "href=\"./$2-$3.html$4\"";
			doAction('url_rewrite');
			$output = preg_replace($searchlink, $replacelink, $output);
		}
	}
	ob_end_clean();
	if ($isgzipenable == 'y' && function_exists('ob_gzhandler'))
	{
		ob_start('ob_gzhandler');
	} else {
		ob_start();
	}
	echo $output;
	exit;
}

/**
 * Blog cutting by [break] tag
 *
 * @param string $content Blog content
 * @param int $lid Blog id
 * @return unknown
 */
function breakLog($content,$lid)
{
	global $lang;
	$a = explode('[break]',$content,2);
	if(!empty($a[1]))
	$a[0].='<p><a href="./?post='.$lid.'">'.$lang['read_more'].'&gt;&gt;</a></p>';
	return $a[0];
}

/**
 * Remove the [break] tag
 *
 * @param string $content Content
 * @return unknown
 */
function rmBreak($content)
{
	$content = str_replace('[break]','',$content);
	return $content;
}

/**
 * Load the remote file content
 *
 * @param $url File http address
 * @return unknown
 */
function fopen_url($url)
{
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
 * Time transformation function
 *
 * @param $now
 * @param $datetemp
 * @param $dstr
 * @return string
 */
function smartyDate($datetemp,$dstr='Y-m-d H:i')
{
	global $lang;
	global $localdate;
	$op = '';
	$sec = $localdate-$datetemp;
	$hover = floor($sec/3600);
	if ($hover == 0){
		$min = floor($sec/60);
		if ( $min == 0) {
			$op = $sec . $lang['seconds_ago'];
		} else {
			$op = $min . $lang['minutes_ago'];
		}
	} elseif ($hover < 24){
		$op = $lang['about']." ".$hover . $lang['hours_ago'];
	} else {
		$op = date($dstr,$datetemp);
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
function getRandStr($length = 12, $special_chars = true)
{
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	if ( $special_chars )
	{
		$chars .= '!@#$%^&*()';
	}
	$randStr = '';
	for ( $i = 0; $i < $length; $i++ )
	{
		$randStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $randStr;
}

/**
 * Looking for all the different elements in two arrays
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function findArray($array1,$array2)
{
	#Merging arrays
	$num1 = count($array1) ;
	$num2 = count($array2);
	$temp = array();
	if (!empty($array1[0]))
	{
		for ($i = 0;$i < $num1 + $num2;$i++)
		{
			if ($i < $num1)
			{
				$addarray[$i] = $array1[$i];
			} else {
				$addarray[$i] = $array2[$i-$num1];
			}
		}
		$k = 0;

		#Look for different items
		for($n = 0;$n < count($addarray);$n++)
		{
			$a = 0;
			for ($j = 0;$j < count($addarray);$j++)
			{
				if($addarray[$n] == $addarray[$j])
				{
					$a++;
				}
			}
			if ($a == 1)
			{
				$temp[$k] = $addarray[$n];
				$k++;
			}
		}
		return $temp;
	} else {
		return $array2;
	}
}

/**
 * Upload Attachment
 *
 * @param string $filename File Name
 * @param string $errorNum Error Code: $_FILES['error']
 * @param string $tmpfile Temporary files after upload
 * @param string $filesize File Size KB
 * @param string $filetype Upload file type eg:image/jpeg
 * @param array $type Permit to upload file types
 * @param boolean $isIcon Whether or not to upload image
 * @return string 
 * -1 Wrong attachment type
 * -2 attachment size limit is invalid
 * -3 permissions
 * -4 Can not create attachment directory, upload attachment failure
 */
function uploadFile($filename, $errorNum, $tmpfile, $filesize, $filetype, $type, $isIcon = 0)
{
	global $lang;
	if ($errorNum == 1)
	{
		formMsg($lang['attachment_exceed_system_limit'].' '.ini_get('upload_max_filesize').' '.$lang['bytes'], 'javascript:history.go(-1);', 0);
	}elseif ($errorNum > 1)
	{
		formMsg($lang['upload_failed_code'].': '.$errorNum, 'javascript:history.go(-1);', 0);
	}
	$extension  = strtolower(substr(strrchr($filename, "."),1));
	if (!in_array($extension, $type))
	{
		formMsg($lang['wrong_file_type'],"javascript:history.go(-1);",0);
	}
	if ($filesize > UPLOADFILE_MAXSIZE)
	{
		$ret = changeFileSize(UPLOADFILE_MAXSIZE);
		formMsg($lang['file_size_exceeded']." ".$ret." ".$lang['restrictions'],"javascript:history.go(-1);",0);
	}
	$uppath = UPLOADFILE_PATH . date('Ym') . '/';
	$fname = md5($filename) . date('YmdHis') .'.'. $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir(UPLOADFILE_PATH))
	{
		umask(0);
		$ret = @mkdir(UPLOADFILE_PATH, 0777);
		if ($ret === false)
		{
			formMsg($lang['attachment_create_failed'], "javascript:history.go(-1);", 0);
		}
	}
	if (!is_dir($uppath))
	{
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false)
		{
			formMsg($lang['uploads_not_written'],"javascript:history.go(-1);",0);
		}
	}
	doAction('attach_upload');
	//resizeImage
	$imtype = array('jpg','png','jpeg');
	$thum = $uppath.'thum-'. $fname;
	if (IS_THUMBNAIL && in_array($extension, $imtype) && function_exists('ImageCreate') && resizeImage($tmpfile,$filetype,$thum,$isIcon))
	{
		$attach = $thum;
	} else{
		$attach = $attachpath;
	}

	if (@is_uploaded_file($tmpfile))
	{
		if (@!move_uploaded_file($tmpfile ,$attachpath))
		{
			@unlink($tmpfile);
			formMsg($lang['uploads_not_written'],"javascript:history.go(-1);",0);
		}
		chmod($attachpath, 0777);
	}
	return 	$attach;
}

/**
 * Generate thumbnails (Resize image)
 *
 * @param string $img original image
 * @param unknown_type $imgtype Upload file type eg:image/jpeg
 * @param string $name Thumbnail name
 * @param boolean $isIcon Whether to upload a personal avatar
 * @return unknown
 */
function resizeImage($img,$imgtype,$name,$isIcon)
{
	if ($isIcon)
	{
		$max_w = ICON_MAX_W;
		$max_h = ICON_MAX_H;
	} else {
		$max_w = IMG_ATT_MAX_W;
		$max_h = IMG_ATT_MAX_H;
	}
	$size = chImageSize($img,$max_w,$max_h);
	$newwidth = $size['w'];
	$newheight = $size['h'];
	$w =$size['rc_w'];
	$h = $size['rc_h'];
	if ($w <= $max_w && $h <= $max_h)
	{
		return false;
	}
	if ($imgtype == 'image/pjpeg' || $imgtype == 'image/jpeg')
	{
		if(function_exists('imagecreatefromjpeg'))
		{
			$img = imagecreatefromjpeg($img);
		}else{
			return false;
		}
	} elseif ($imgtype == 'image/x-png' || $imgtype == 'image/png') {
		if (function_exists('imagecreatefrompng'))
		{
			$img = imagecreatefrompng($img);
		}else{
			return false;
		}
	}
	if (function_exists('imagecopyresampled'))
	{
		$newim = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
	} else {
		$newim = imagecreate($newwidth, $newheight);
		imagecopyresized($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
	}
	if ($imgtype == 'image/pjpeg' || $imgtype == 'image/jpeg')
	{
		if(!imagejpeg($newim,$name))
		{
			return false;
		}
	} elseif ($imgtype == 'image/x-png' || $imgtype == 'image/png') {
		if (!imagepng($newim,$name))
		{
			return false;
		}
	}
	ImageDestroy ($newim);
	return true;
}

/**
 * Delete the same element in the array, only keep unique
 *
 * @param array $array
 * @return array
 */
function formatArray($array)
{
	sort($array);
	$tem = '';
	$temarray = array();
	$j = 0;
	for ($i = 0;$i < count($array);$i++)
	{
		if ($array[$i] != $tem)
		{
			$temarray[$j] = $array[$i];
			$j++;
		}
		$tem = $array[$i];
	}
	return $temarray;
}

/**
 * Background operation information
 *
 * @param string $msg
 * @param string $url
 * @param boolean $type
 */
function formMsg($msg,$url,$type)
{
	global $lang;
	$typeimg = $type ? 'mc_ok.gif' : 'mc_no.gif';
	require_once(getViews('msg'));
	cleanPage();
	exit;
}

/**
 * Display system information
 *
 * @param string $msg Message
 * @param string $url Return to URL
 * @param boolean $isAutoGo Whether or not auto-return: true/false
 */
function emMsg($msg,$url='javascript:history.back(-1);', $isAutoGo=false)
{
	global $lang;
	echo <<<EOT
<html>
<head>
EOT;
	if($isAutoGo)
	{
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
<p><a href="$url">&laquo; {$lang['return_back']}</a></p>
</div>
</body>
</html>
EOT;
	exit;
}

?>