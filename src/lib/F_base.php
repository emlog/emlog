<?php
/**
 * 基础函数库
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.1
 * $Id$
 */

/**
 * 加载模板文件
 *
 * @param string $template 模板名
 * @param string $ext 模板后缀名
 * @return string 模板路径
 */
function getViews($template, $ext = ".php")
{
	global $cerTemplatePath;
	if (!$template)
	{
		$template = 'none';
	}
	$path = $cerTemplatePath.$template.$ext;
	return $path;
}

/**
 * 执行去除转义字符
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
 * 递归去除转义字符
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
 * 转换HTML代码函数
 *
 * @param unknown_type $content
 * @param unknown_type $wrap 是否换行
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
 * 获取用户ip地址
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
		if (getenv("HTTP_X_FORWARDED_FOR")) {
			$ip = getenv( "HTTP_X_FORWARDED_FOR");
		} elseif (getenv("HTTP_CLIENT_IP")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else {
			$ip = getenv("REMOTE_ADDR");
		}
	}
	if(!preg_match("/\d+\.\d+\.\d+\.\d+/", $ip))
	{
		$ip = '';
	}
	return $ip;
}

/**
 * 访问统计
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
			$curtime = date("Y-m-d");
			if ($viewcount_date != $curtime)
			{
				$DB->query("UPDATE ".DB_PREFIX."options SET option_value ='$curtime' where option_name='viewcount_date'");
				$DB->query("UPDATE ".DB_PREFIX."options SET option_value ='1' where option_name='viewcount_day'");
			} else {
				$DB->query("UPDATE ".DB_PREFIX."options SET option_value =option_value+1 where option_name='viewcount_day'");
			}
			$DB->query("UPDATE ".DB_PREFIX."options SET option_value =option_value+1 where option_name='viewcount_all'");
			$CACHE->mc_options();
		}
	}
}

/**
 * 验证email地址格式
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
 * 截取编码为utf8的字符串
 *
 * @param string $strings 预处理字符串
 * @param int $start 开始处 eg:0
 * @param int $length 截取长度
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
 * 转换附件大小单位
 *
 * @param string $filesize 文件大小 kb
 * @return unknown
 */
function changeFileSize($filesize)
{
	if($filesize >= 1073741824)
	{
		$filesize = round($filesize / 1073741824  ,2) . 'GB';
	} elseif($filesize >= 1048576){
		$filesize = round($filesize / 1048576 ,2) . 'MB';
	} elseif($filesize >= 1024){
		$filesize = round($filesize / 1024, 2) . 'KB';
	} else{
		$filesize = $filesize . '字节';
	}
	return $filesize;
}

/**
 * 分页函数
 *
 * @param int $count 条目总数
 * @param int $perlogs 每页显示条数目
 * @param int $page 当前页码
 * @param string $url 页码的地址
 * @return unknown
 */
function pagination($count,$perlogs,$page,$url)
{
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
	if ($page > 6) $re = "<a href=\"$url=1\" title=\"首页\">&laquo;</a> ...$re";
	if ($page + 5 < $pnums) $re .= "... <a href=\"$url=$pnums\" title=\"尾页\">&raquo;</a>";
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
 * 执行挂在钩子上的函数,支持多参数 eg:doAction('post_comment', $author, $email, $url, $comment);
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
 * 按照比例改变图片大小(非生成缩略图)
 *
 * @param string $img 图片路径
 * @param int $max_w 最大缩放宽
 * @param int $max_h 最大缩放高
 * @return unknown
 */
function chImageSize ($img,$max_w,$max_h)
{
	$size = @getimagesize($img);
	$w = $size[0];
	$h = $size[1];
	//计算缩放比例
	@$w_ratio = $max_w / $w;
	@$h_ratio =	$max_h / $h;
	//决定处理后的图片宽和高
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
 * 改变图片附件的比例，用于模板中
 *
 * @param string $attstr 缓存中的附件串
 * @param int $width 新的宽
 * @param int $height 新的高
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
 * 清除模板中的注释,并完成URL优化
 *
 */
function cleanPage($beUrlRewrite = false)
{
	global $isurlrewrite,$isgzipenable;
	$output = str_replace(array('?>','<?php',"<?php\r\n?>"),array('','',''),ob_get_contents());
	if($beUrlRewrite)
	{
		if ($isurlrewrite == 'y' )
		{
			$searchlink = "/href\=\"(index\.php|\.\/|\.\/index.php)\?(post|record|sort|author|page|tag)=(\d+|[%+-_A-Za-z0-9]+)(#*[\w]*)\"/i";
			$replacelink = "href=\"./$2-$3.html$4\"";
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
 * 日志分割
 *
 * @param string $content 日志内容
 * @param int $lid 日志id
 * @return unknown
 */
function breakLog($content,$lid)
{
	$a = explode("[break]",$content,2);
	if(!empty($a[1]))
	$a[0].='<p><a href="./?post='.$lid.'">阅读全文&gt;&gt;</a></p>';
	return $a[0];
}

/**
 * 删除[break]标签
 *
 * @param string $content 日志内容
 * @return unknown
 */
function rmBreak($content)
{
	$content = str_replace('[break]','',$content);
	return $content;
}

/**
 * 获取远程文件内容
 *
 * @param 文件http地址 $url
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
 * 时间转化函数
 *
 * @param unix timestamp $datetemp
 * @return string
 */
function smartyDate($now,$datetemp,$dstr='Y-m-d H:i')
{
	$op = '';
	$sec = $now-$datetemp;
	$hover = floor($sec/3600);
	if ($hover == 0){
		$min = floor($sec/60);
		if ( $min == 0) {
			$op = $sec.' 秒前';
		} else {
			$op = "$min 分钟前";
		}
	} elseif ($hover < 24){
		$op = "约 {$hover} 小时前";
	} else {
		$op = date($dstr,$datetemp);
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
 * 寻找两数组所有不同元素
 *
 * @param array $array1
 * @param array $array2
 * @return array
 */
function findArray($array1,$array2)
{
	#合并数组
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
		#寻找不同项
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
 * 附件上传
 *
 * @param string $filename 文件名
 * @param string $errorNum 错误码：$_FILES['error']
 * @param string $tmpfile 上传后的临时文件
 * @param string $filesize 文件大小 KB
 * @param string $filetype 上传文件的类型 eg:image/jpeg
 * @param array $type 允许上传的文件类型
 * @param boolean $isIcon 是否为上传头像
 * @return string 文件路径
 */
function uploadFile($filename, $errorNum, $tmpfile, $filesize, $filetype, $type, $isIcon = 0)
{
	if ($errorNum == 1)
	{
		formMsg('附件大小超过系统'.ini_get('upload_max_filesize').'限制', 'javascript:history.go(-1);', 0);
	}elseif ($errorNum > 1)
	{
		formMsg('上传文件失败,错误码：'.$errorNum, 'javascript:history.go(-1);', 0);
	}
	$extension  = strtolower(substr(strrchr($filename, "."),1));
	if (!in_array($extension, $type))
	{
		formMsg("错误的文件类型","javascript:history.go(-1);",0);
	}
	if ($filesize > UPLOADFILE_MAXSIZE)
	{
		$ret = changeFileSize(UPLOADFILE_MAXSIZE);
		formMsg("文件大小超出{$ret}的限制","javascript:history.go(-1);",0);
	}
	$uppath = UPLOADFILE_PATH . date("Ym") . "/";
	$fname = md5($filename) . date("YmdHis") .'.'. $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir(UPLOADFILE_PATH))
	{
		umask(0);
		$ret = @mkdir(UPLOADFILE_PATH, 0777);
		if ($ret === false)
		{
			formMsg('创建文件上传目录失败', "javascript:history.go(-1);", 0);
		}
	}
	if (!is_dir($uppath))
	{
		umask(0);
		$ret = @mkdir($uppath, 0777);
		if ($ret === false)
		{
			formMsg("上传失败。文件上传目录(content/uploadfile)不可写","javascript:history.go(-1);",0);
		}
	}
	//缩略
	$imtype = array('jpg','png','jpeg');
	$thum = $uppath."thum-". $fname;
	if (IS_THUMBNAIL && in_array($extension, $imtype) && function_exists("ImageCreate") && resizeImage($tmpfile,$filetype,$thum,$isIcon))
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
			formMsg("上传失败。文件上传目录(content/uploadfile)不可写","javascript:history.go(-1);",0);
		}
		chmod($attachpath, 0777);
	}
	return 	$attach;
}

/**
 * 图片生成缩略图
 *
 * @param string $img 预缩略的图片
 * @param unknown_type $imgtype 上传文件的类型 eg:image/jpeg
 * @param string $name 缩略图名
 * @param boolean $isIcon 是否为上传个性头像
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
	if ($imgtype == "image/pjpeg" || $imgtype == "image/jpeg")
	{
		if(function_exists("imagecreatefromjpeg"))
		{
			$img = imagecreatefromjpeg($img);
		}else{
			return false;
		}
	} elseif ($imgtype == "image/x-png" || $imgtype == "image/png") {
		if (function_exists("imagecreatefrompng"))
		{
			$img = imagecreatefrompng($img);
		}else{
			return false;
		}
	}
	if (function_exists("imagecopyresampled"))
	{
		$newim = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
	} else {
		$newim = imagecreate($newwidth, $newheight);
		imagecopyresized($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
	}
	if ($imgtype == "image/pjpeg" || $imgtype == "image/jpeg")
	{
		if(!imagejpeg($newim,$name))
		{
			return false;
		}
	} elseif ($imgtype == "image/x-png" || $imgtype == "image/png") {
		if (!imagepng($newim,$name))
		{
			return false;
		}
	}
	ImageDestroy ($newim);
	return true;
}

/**
 * 删除数组中相同元素，只保留一个
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
 * 后台操作返回信息
 *
 * @param string $msg
 * @param string $url
 * @param boolean $type
 */
function formMsg($msg,$url,$type)
{
	$typeimg = $type ? 'mc_ok.gif' : 'mc_no.gif';
	require_once(getViews('msg'));
	cleanPage();
	exit;
}

/**
 * 显示系统信息
 *
 * @param string $msg 信息
 * @param string $url 返回地址
 * @param boolean $isAutoGo 是否自动返回 true false
 */
function emMsg($msg,$url='javascript:history.back(-1);', $isAutoGo=false)
{
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
<p><a href="$url">&laquo;点击返回</a></p>
</div>
</body>
</html>
EOT;
	exit;
}

?>