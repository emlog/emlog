<?php
/**
 * 数据备份
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.6.5
 */

require_once('./globals.php');

if($action == '')
{
	include getViews('header');
	$bakfiles = glob("../adm/bakup/*.sql");
	$tables = array('attachment', 'blog', 'comment', 'config', 'link','statistics','tag','trackback','twitter','user');
	$defname = date("Y_m_d").'_'.substr(md5(date('YmdHis')),0,18);
	require_once(getViews('bakdata'));
	include getViews('footer');
	cleanPage();
}
if($action=='bakstart')
{
	$bakfname = isset($_POST['bakfname'])?$_POST['bakfname']:'';
	$table_box = isset($_POST['table_box'])?$_POST['table_box']:'';

	if(!preg_match("/^[a-zA-Z0-9_]+$/",$bakfname))
	{
		formMsg('错误的备份文件名','javascript:history.go(-1);',0);
	}
	$filename = './bakup/'.$bakfname.'.sql';

	// 获取数据库结构和数据内容
	$sqldump = '';
	foreach($table_box as $table)
	{
		$sqldump .= dataBak($table);
	}

	// 如果数据内容不是空就开始保存
	if(trim($sqldump))
	{
		$setchar = $DB->version() > '4.1'?"ALTER DATABASE {$db} DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;":'';
		$sqldump = "#emlog_$edition database bakup file\n#".date('Y-m-d H:i')."\n$setchar\n$sqldump";
		//备份到服务器
		@$fp = fopen($filename, "w+");
		if ($fp)
		{
			@flock($fp, 3);
			if(@!fwrite($fp, $sqldump))
			{
				@fclose($fp);
				formMsg( '备份失败,请检查目录的权限是否可写','javascript:history.go(-1);',0);
			}else
			{
				formMsg('数据成功备份至服务器','./backupdata.php',1);
			}
		}else
		{
			formMsg('无法打开指定的目录'. $filename .'，请确定该目录是否存在,或者是否有相应权限','javascript:history.go(-1);',0);
		}
	}else
	{
		formMsg('数据表没有任何内容','javascript:history.go(-1);',0);
	}
}

//恢复数据
if ($action == 'renewdata')
{
	$sqlfile = isset($_GET['sqlfile'])?$_GET['sqlfile']:'';
	if (!file_exists($sqlfile))
	{
		formMsg('文件不存在', 'javascript:history.go(-1);',0);
	}else
	{
		$extension=strtolower(substr(strrchr($sqlfile,'.'),1));
		if ($extension !== 'sql')
		{
			formMsg('读取数据库文件失败, 只能恢复 *.sql 文件.', 'javascript:history.go(-1);',0);
		}
		$fp=fopen($sqlfile,'rb');
		$bakinfo=fread($fp,200);
		fclose($fp);
		$detail=explode("\n",$bakinfo);
		$dbfile['system'] = substr($detail[0],1,11);
		if ($dbfile['system'] != "emlog_$edition")
		{
			formMsg("导入失败! 该备份文件不是 emlog_{$edition} 的备份文件!", 'javascript:history.go(-1);',0);
		}
	}
	$fp = fopen($sqlfile, 'rb');
	$sql = fread($fp, filesize($sqlfile));
	fclose($fp);
	unset($sql);
	bakindata($sqlfile);
	$MC->mc_blogger('../cache/blogger');
	$MC->mc_config('../cache/config');
	$MC->mc_record('../cache/records');
	$MC->mc_comment('../cache/comments');
	$MC->mc_logtags('../cache/log_tags');
	$MC->mc_sta('../cache/sta');
	$MC->mc_link('../cache/links');
	$MC->mc_tags('../cache/tags');
	$MC->mc_twitter('../cache/twitter');
	formMsg('数据恢复成功', './backupdata.php',1);
}

function bakindata($filename)
{
	global $DB;
	$sql = file($filename);
	$query = '';
	$num = 0;
	foreach($sql as $key => $value)
	{
		$value = trim($value);
		if(!$value || $value[0]=='#') continue;
		if(eregi("\;$",$value))
		{
			$query .= $value;
			if(eregi("^CREATE",$query))
			{
				$query = preg_replace("/\DEFAULT CHARSET=([a-z0-9]+)/is",'',$query);
			}
			$DB->query($query);
			$query = '';
		} else
		{
			$query .= $value;
		}
	}
}

//批量删除备份文件
if($action== 'dell_all_bak')
{
	if(!isset($_POST['bak']))
	{
		formMsg('请选择要删除的备份文件','./backupdata.php',0);
	}else
	{
		foreach($_POST['bak'] as $value)
		{
			unlink($value);
		}
		formMsg('备份文件删除成功!','./backupdata.php',1);
	}
}
?>