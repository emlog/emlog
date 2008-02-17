<?php
/**
 * 附件处理
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.0
 */

//require_once('./globals.php');

if($action == '')
{
	//$attach = isset($_FILES['attachment'])?$_FILES['attachment']:'';
	
	var_dump($_REQUEST);exit;
	
	print 'ddddddddddd:'.$_FILES['attachment']['name'];exit;
	
	if($attach){
		if($attach['error']!=4)
		{
			$ades = addslashes(trim($des[$i]));
			//$att_type 允许上传的后缀名
			$upfname = uploadFile($attach['name'],$attach['tmp_name'],$attach['size'],$att_type,$attach['type']);
		}
	}
}

//删除附件
if ($action== 'del_attach')
{
	//删除附件文件
	$aid = isset($_GET['aid'])?intval($_GET['aid']):'';
	$query=$DB->query("select filepath from {$db_prefix}attachment where aid=$aid ");
	$attach=$DB->fetch_array($query);
	if(file_exists($attach['filepath']))
	{
		$fpath = str_replace('thum-', '', $attach['filepath']);
		if($fpath != $attach['filepath'])
		{
			@unlink($fpath) or die('删除附件失败');
		}
		@unlink($attach['filepath']) or die('删除附件失败');
	}
	//删除数据库记录
	$DB->query("DELETE FROM {$db_prefix}attachment where aid=$aid ");
	formMsg('附件成功删除','javascript:history.go(-1);',1);
}
?>