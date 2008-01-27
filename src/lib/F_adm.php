<?php
/* emlog 2.5.0 Emlog.Net */

/*
	验证用户是否处于登陆状态
*/
function isLogin()
{
	session_start();
	global $DB,$db_prefix;
	if (isset($_SESSION['adminname']) && isset($_SESSION['password']) && $_SESSION['adminname'] !='' && $_SESSION['password'] !='')
	{
		$SQL="SELECT password FROM ".$db_prefix."user  WHERE username='".$_SESSION['adminname']."' AND password = '".$_SESSION['password']."' ";
		$result = $DB->query($SQL);
		$getpass = $DB->fetch_array($result);
		if ($getpass['password'] != $_SESSION['password']) 
		{
			loginPage();
		}
	}else 
	{
		loginPage();
	}
}

/*
	验证密码/用户
	@return boolean
*/
function checkUser($username,$password,$imgcode,$logincode)
{
	global $DB,$userinfo,$db_prefix;
	if (trim($username) == '' || trim($username) == '')
	{
		return FALSE;
	}else
	{	
		$userinfo=$DB->fetch_one_array("SELECT * FROM ".$db_prefix."user WHERE username='$username' AND password='$password' ");
		if (empty($userinfo))
		{
			return FALSE;
		}elseif ($logincode=='y' && $imgcode!=$_SESSION['code'])
		{
			return FALSE;
		}else
		{
			return TRUE;
		}
	}
}

/*
	系统返回信息
*/
function formMsg($msg,$url,$type)
{
	global $nonce_tpl;
	$typeimg = $type?'mc_ok.gif':'mc_no.gif';
	require_once(getViews('msg'));
	cleanPage();
	exit;
}

/*
	登录页面
*/
function loginPage() 
{
	global $login_code,$nonce_tpl;
	$login_code=='y'?
	$ckcode = "<tr><td >验证码:<br /><input type=\"hidden\" name=\"action\" value=\"login\" >
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"../lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
	require_once(getViews('login'));
	cleanPage();
	exit;
}

/*
	附件上传
	@param string $filename 文件名
	@param string $tmpfile 上传后的临时文件
	@param string $filesize 文件大小 KB
	@param array $type 允许上传的文件类型
	@param string $filetype 上传文件的类型 eg:image/jpeg
	@param boolean $isIcon 是否为上传个性头像
*/ 
function uploadFile($filename,$tmpfile,$filesize,$type,$filetype,$isIcon=0)
{
	global $uploadroot;
	$extension  = strtolower(substr(strrchr($filename, "."),1));
	if (!in_array($extension, $type))
	{
			formMsg("错误的附件类型","javascript:history.go(-1);",0);
	}
	if($filesize>2297152)
	{
			formMsg("附件大小超出2m!","javascript:history.go(-1);",0);	
	}
	$uppath = $uploadroot.date("Ym")."/";
	$fname = md5($filename).date("YmdHis").'.'.$extension;
	$attachpath = $uppath.$fname;
	if(!is_dir($uploadroot))
	{
		@mkdir($uploadroot,0777) OR die("权限不足无法创建附件目录");
	}
	if(!is_dir($uppath))
	{
		@mkdir($uppath,0777) OR die("创建日期目录失败");
	}
	//thum
	$imtype = array('jpg','png','jpeg');
	$thum = $uppath."thum-".$fname;
	if(in_array($extension, $imtype) && function_exists("ImageCreate") && resizeImage($tmpfile,$filetype,$thum,$isIcon))
		$attach = $thum;
			else
				$attach = 	$attachpath;
	
	if(@is_uploaded_file($tmpfile))
	{
			if(!move_uploaded_file($tmpfile ,$attachpath))
			{
				@unlink($tmpfile);
				formMsg( "上传附件失败","javascript:history.go(-1);",0);
			}
	}	
	return 	$attach;
}

/*
	图片生成缩略图
	@param string $img 预缩略的图片
	@param string $filetype 上传文件的类型 eg:image/jpeg
	@param string $name 缩略图名
	@param boolean $isIcon 是否为上传个性头像
*/ 
function resizeImage($img,$imgtype,$name,$isIcon)
{
	if($isIcon)
	{
		$max_w = ICON_MAX_W;
		$max_h = ICON_MAX_H;
	}else
	{
		$max_w = IMG_ATT_MAX_W;
		$max_h = IMG_ATT_MAX_H;
	}
	$size = chImage($img,$max_w,$max_h);	
	$newwidth = $size['w'];
	$newheight = $size['h'];
	$w =$size['rc_w'];
	$h = $size['rc_h'];
	if($w <= $max_w && $h <= $max_h)
	{
		return FALSE;
	}
	if($imgtype == "image/pjpeg" OR $imgtype == "image/jpeg")
	{
		$img = imagecreatefromjpeg($img);
	}elseif($imgtype == "image/x-png" OR $imgtype == "image/png")
	{
		$img = imagecreatefrompng($img);
	}	
	if(function_exists("imagecopyresampled"))
	{
		$newim = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
	}else
	{
		$newim = imagecreate($newwidth, $newheight);
		imagecopyresized($newim, $img, 0, 0, 0, 0, $newwidth, $newheight, $w, $h);
	}
	if(ImageJpeg($newim,$name))
	{
		return TRUE;
	}
	ImageDestroy ($newim);
}

/*
	备份数据库结构和所有数据
	@param string $table 数据库表名
	@return string sql
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
		for($i = 0; $i < $numfields; $i++)
		{
			$sql .= $comma."'".mysql_escape_string($row[$i])."'";
			$comma = ",";
		}
		$sql .= ");\n";
	}
	$sql .= "\n";

	return $sql;
}

/*
	发送 trackback 数据包
	@param string $url 发送地址
	@param string $date 数据信息
*/ 
function sendPacket($url, $data)
{
	$uinfo = parse_url($url);
	if ($uinfo['query'])
	{
		$data .= "&".$uinfo['query'];
	}
	if (!$fp = @fsockopen($uinfo['host'], (($uinfo['port']) ? $uinfo['port'] : "80"), $errno, $errstr, 3))
	{
		return false;
	}
	fputs ($fp, "POST ".$uinfo['path']." HTTP/1.1\r\n");
	fputs ($fp, "Host: ".$uinfo['host']."\r\n");
	fputs ($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	fputs ($fp, "Content-length: ".strlen($data)."\r\n");
	fputs ($fp, "Connection: close\r\n\r\n");
	fputs ($fp, $data);
	$http_response = '';
	while(!feof($fp))
	{
		$http_response .= fgets($fp, 128);
	}
	@fclose($fp);
	list($http_headers, $http_content) = explode("\r\n\r\n", $http_response);
	return $http_response;
}

/*
	寻找两数组所有不同元素
	@param array $array1
	@param array $array2
	@return array 
*/ 
function findArray($array1,$array2)
{
	#合并数组
	$num1 = count($array1) ;
	$num2 = count($array2);
	$temp = array();
	if(!empty($array1[0]))
	{
		for($i=0;$i<$num1 + $num2;$i++)
		{
			if($i<$num1)
			{
				$addarray[$i] = $array1[$i]; 
			}else{
				$addarray[$i] = $array2[$i-$num1];
			}
		}
		$k = 0;
		#寻找不同项
		for($n=0;$n<count($addarray);$n++)
		{
			$a = 0;
			for($j=0;$j<count($addarray);$j++)
			{
				if($addarray[$n]==$addarray[$j])
				{
					$a++;
				}
			}
			if($a == 1)
			{
				$temp[$k] = $addarray[$n];
				$k++;
			}
		}
		return $temp;
	}else{
		return $array2;
	}
}

/*
	删除数组中相同元素，只保留一个
	@param array $array
	@return array 
*/
function formatArray($array)
{
	 sort($array);
	 $tem = '';
	 $temarray = array();
	 $j = 0;
	 for($i=0;$i<count($array);$i++)
	 {
		if($array[$i]!=$tem)
		{
			 $temarray[$j] = $array[$i];
			 $j++;
		}
		$tem = $array[$i];
	 }
	 return $temarray;
}

/*
	随机读取一个数组元素
	@param array $array
	@return unknow
*/
function getTips($array)
{
	$num = mt_rand(0,count($array)-1);
	return $array[$num];
}

/*
	背景色替换
*/
function getRowbg()
{
	global $bgcounter;
	if ($bgcounter++%2 == 0) {
		return "firstalt";
	} else {
		return "secondalt";
	}
}

/*
	验证密码(修改密码用)
	@param string $password 当前密码
*/
function checkPass($password)
{
	global $DB,$db_prefix;
	$query=$DB->query("select * from ".$db_prefix."user where password='$password'");
	$ispass = $DB->fetch_array($query);
	if (empty($ispass))
	{
		return false;
	}else
	{
		return true;
	}
}

/*
	删除日志
	@param $gid 日志id
*/
function delLog($gid)
{
	global $DB,$db_prefix;
	
	$DB->query("DELETE FROM ".$db_prefix."blog where gid=$gid");
	//评论
	$DB->query("DELETE FROM ".$db_prefix."comment where gid=$gid");
	//引用
	$DB->query("DELETE FROM ".$db_prefix."trackback where gid=$gid");
	//标签
	$DB->query("UPDATE ".$db_prefix."tag SET usenum=usenum-1,gid= REPLACE(gid,',$gid,',',') WHERE gid LIKE '%".$gid."%' ");
	$DB->query("DELETE FROM ".$db_prefix."tag WHERE usenum=0 ");
	//附件
	$query=$DB->query("select filepath from ".$db_prefix."attachment where blogid=$gid ");
	while($attach=$DB->fetch_array($query))
	{
		if(file_exists($attach['filepath']))
		{
			$fpath = str_replace('thum-', '', $attach['filepath']);
			if($fpath != $attach['filepath'])
			{
				@unlink($fpath);
			}
			@unlink($attach['filepath']);
		}
	}
	$DB->query("DELETE FROM ".$db_prefix."attachment where blogid=$gid");
}
?>