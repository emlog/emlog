<?php
/**
 * 附件处理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-3.0.0
 * $Id$
 */

require_once('./globals.php');

//上传表单显示
if($action == 'selectFile')
{
	$attachnum = 0;
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	if($logid)
	{
		$sql="SELECT * FROM ".DB_PREFIX."attachment where blogid=$logid";
		$query=$DB->query($sql);
		$attachnum = $DB->num_rows($query);
	}
	$maxsize = changeFileSize(UPLOADFILE_MAXSIZE);
	//允许附件类型
	$att_type_str = '';
	foreach ($att_type as $val)
	{
		$att_type_str .= " $val";
	}
	require_once(getViews('upload'));
	cleanPage();
}

//上传附件
if($action == 'upload')
{
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	$attach = isset($_FILES['attach']) ? $_FILES['attach'] : '';
	if($attach)
	{
		for ($i = 0; $i < count($attach['name']); $i++)
		{
			if($attach['error'][$i]!=4)
			{
				//$att_type 允许上传的后缀名
				$upfname = uploadFile($attach['name'][$i],$attach['tmp_name'][$i],$attach['size'][$i],$att_type,$attach['type'][$i]);
				switch ($upfname)
				{
					case -1:
						formMsg("错误的附件类型","javascript:history.go(-1);",0);
						break;
					case -2:
						$ret = changeFileSize(UPLOADFILE_MAXSIZE);
						formMsg("附件大小超出{$ret}的限制","javascript:history.go(-1);",0);
						break;
					case -3:
						formMsg("权限不足无法创建附件目录","javascript:history.go(-1);",0);
						break;
					case -4:
						formMsg("上传附件失败","javascript:history.go(-1);",0);
						break;
				}
				//写入附件信息
				$query="INSERT INTO ".DB_PREFIX."attachment (`blogid`,`filename`,`filesize`,`filepath`,`addtime`) values ('".$logid."','".$attach['name'][$i]."','".$attach['size'][$i]."','".$upfname."','".time()."')";
				$DB->query($query);
			}
		}
	}
	header("Location: attachment.php?action=attlib&logid=$logid");
}

//附件库
if($action == 'attlib')
{
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	$sql="SELECT * FROM ".DB_PREFIX."attachment where blogid=$logid ";
	$query=$DB->query($sql);
	$attachnum = $DB->num_rows($query);
	$attach = array();
	while($dh=$DB->fetch_array($query))
	{
		$attsize = changeFileSize($dh['filesize']);
		$filename = htmlspecialchars($dh['filename']);

		$attach[] = array(
		'attsize'=>$attsize,
		'aid'=>$dh['aid'],
		'filepath'=>$dh['filepath'],
		'filename'=>$filename
		);
	}
	require_once(getViews('attlib'));
	cleanPage();
}

//删除附件
if ($action == 'del_attach')
{
	$aid = isset($_GET['aid']) ? intval($_GET['aid']) : '';
	$query=$DB->query("select filepath,blogid from ".DB_PREFIX."attachment where aid=$aid ");
	$attach=$DB->fetch_array($query);
	$logid = $attach['blogid'];
	if(file_exists($attach['filepath']))
	{
		$fpath = str_replace('thum-', '', $attach['filepath']);
		if($fpath != $attach['filepath'])
		{
			@unlink($fpath) or die('删除附件失败');
		}
		@unlink($attach['filepath']) or die('删除附件失败');
	}
	$DB->query("DELETE FROM ".DB_PREFIX."attachment where aid=$aid ");
	header("Location: attachment.php?action=attlib&logid=$logid");
}
?>