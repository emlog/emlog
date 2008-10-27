<?php
/**
 * 后台管理函数库
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

/**
 * 系统返回信息
 *
 * @param unknown_type $msg
 * @param unknown_type $url
 * @param unknown_type $type
 */
function formMsg($msg,$url,$type)
{
	global $nonce_tpl;
	$typeimg = $type?'mc_ok.gif':'mc_no.gif';
	require_once(getViews('msg'));
	cleanPage();
	exit;
}

/**
 * 附件上传
 *
 * @param string $filename 文件名
 * @param string $tmpfile 上传后的临时文件
 * @param string $filesize 文件大小 KB
 * @param array $type 允许上传的文件类型
 * @param string $filetype 上传文件的类型 eg:image/jpeg
 * @param boolean $isIcon 是否为上传头像
 * @return unknown
 */
function uploadFile($filename,$tmpfile,$filesize,$type,$filetype,$isIcon=0)
{
	global $uploadroot, $uploadmax;

	$extension  = strtolower(substr(strrchr($filename, "."),1));
	if (!in_array($extension, $type))
	{
		return -1;//错误的附件类型
	}
	if ($filesize > $uploadmax)
	{
		return -2;//附件大小超出的限制
	}
	$uppath = $uploadroot . date("Ym") . "/";
	$fname = md5($filename) . date("YmdHis") .'.'. $extension;
	$attachpath = $uppath . $fname;
	if (!is_dir($uploadroot))
	{
		if (@mkdir($uploadroot,0777) === false)
		{
			return -3;//权限不足无法创建附件目录
		}
	}
	if (!is_dir($uppath))
	{
		if (@mkdir($uppath,0777) === false)
		{
			return -3;//权限不足无法创建附件目录
		}
	}
	//缩略
	$imtype = array('jpg','png','jpeg');
	$thum = $uppath."thum-". $fname;
	if (in_array($extension, $imtype) && function_exists("ImageCreate") && resizeImage($tmpfile,$filetype,$thum,$isIcon))
	{
		$attach = $thum;
	} else{
		$attach = 	$attachpath;
	}

	if (@is_uploaded_file($tmpfile))
	{
		if (!move_uploaded_file($tmpfile ,$attachpath))
		{
			@unlink($tmpfile);
			return -4;//上传附件失败
		}
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
 * 备份数据库结构和所有数据
 *
 * @param string $table 数据库表名
 * @return string
 */
function dataBak($table)
{
	global $DB;
	$sql = "DROP TABLE IF EXISTS $table;\n";
	$createtable = $DB->query("SHOW CREATE TABLE $table");
	$create = $DB->fetch_row($createtable);
	$sql .= $create[1].";\n\n";

	$rows = $DB->query("SELECT * FROM $table");
	$numfields = $DB->num_fields($rows);
	$numrows = $DB->num_rows($rows);
	while ($row = $DB->fetch_row($rows))
	{
		$comma = "";
		$sql .= "INSERT INTO $table VALUES(";
		for ($i = 0; $i < $numfields; $i++)
		{
			$sql .= $comma."'".mysql_escape_string($row[$i])."'";
			$comma = ",";
		}
		$sql .= ");\n";
	}
	$sql .= "\n";

	return $sql;
}

/**
 * 随机读取一个数组元素
 *
 * @param array $array
 * @return unknow
 */
function getTips($array)
{
	$num = mt_rand(0,count($array)-1);
	return $array[$num];
}

?>
