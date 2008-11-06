<?php
/**
 * 数据备份
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./globals.php');

if($action == '')
{
	$retval = glob("../content/backup/*.sql");
	$bakfiles = $retval ? $retval : array();
	$tables = array('attachment', 'blog', 'comment', 'config', 'link','statistics','tag','trackback','twitter','user');
	$defname = date("Y_m_d").'_'.substr(md5(date('YmdHis')),0,18);
	
	include getViews('header');	
	require_once(getViews('backup'));
	include getViews('footer');
	cleanPage();
}
if($action=='bakstart')
{
	$bakfname = isset($_POST['bakfname']) ? $_POST['bakfname'] : '';
	$table_box = isset($_POST['table_box']) ? $_POST['table_box'] : '';

	if(!preg_match("/^[a-zA-Z0-9_]+$/",$bakfname))
	{
		formMsg('错误的备份文件名','javascript:history.go(-1);',0);
	}
	$filename = '../content/backup/'.$bakfname.'.sql';

	//获取数据库结构和数据内容
	$sqldump = '';
	foreach($table_box as $table)
	{
		$sqldump .= dataBak($table);
	}

	//如果数据内容不是空就开始保存
	if(trim($sqldump))
	{
		$sqldump = "#emlog_".EMLOG_VERSION." database bakup file\n#".date('Y-m-d H:i')."\n$sqldump";
		//备份到服务器
		@$fp = fopen($filename, "w+");
		if ($fp)
		{
			@flock($fp, 3);
			if(@!fwrite($fp, $sqldump))
			{
				@fclose($fp);
				formMsg( '备份失败,请检查备份目录的权限是否可写','javascript:history.go(-1);',0);
			}else{
				formMsg('数据成功备份至服务器','./backup.php',1);
			}
		}else{
			formMsg('无法打开指定的目录'. $filename .'，请确定该目录是否存在,或者是否有相应权限','javascript:history.go(-1);',0);
		}
	}else{
		formMsg('数据表没有任何内容','javascript:history.go(-1);',0);
	}
}

//恢复数据
if ($action == 'renewdata')
{
	$sqlfile = isset($_GET['sqlfile']) ? $_GET['sqlfile'] : '';
	if (!file_exists($sqlfile))
	{
		formMsg('文件不存在', 'javascript:history.go(-1);',0);
	}else{
		$extension = strtolower(substr(strrchr($sqlfile,'.'),1));
		if ($extension !== 'sql')
		{
			formMsg('读取数据库文件失败, 只能恢复 *.sql 文件', 'javascript:history.go(-1);',0);
		}
		$fp = fopen($sqlfile,'rb');
		$bakinfo = fread($fp,200);
		fclose($fp);
		if (!strstr($bakinfo,"emlog_".EMLOG_VERSION))
		{
			formMsg("导入失败! 该备份文件不是 emlog ".EMLOG_VERSION."的备份文件!", 'javascript:history.go(-1);',0);
		}elseif (!strstr($bakinfo,DB_PREFIX)){
			formMsg("导入失败! 备份文件中的数据库前缀与当前系统数据库前缀不匹配", 'javascript:history.go(-1);',0);
		}
	}
	$fp = fopen($sqlfile, 'rb');
	$sql = fread($fp, filesize($sqlfile));
	fclose($fp);
	unset($sql);
	bakindata($sqlfile);
	$CACHE->mc_blogger('blogger');
	$CACHE->mc_config('config');
	$CACHE->mc_record('records');
	$CACHE->mc_comment('comments');
	$CACHE->mc_logtags('log_tags');
	$CACHE->mc_sta('sta');
	$CACHE->mc_link('links');
	$CACHE->mc_tags('tags');
	$CACHE->mc_twitter('twitter');
	formMsg('数据恢复成功', './backup.php',1);
}

//批量删除备份文件
if($action== 'dell_all_bak')
{
	if(!isset($_POST['bak']))
	{
		formMsg('请选择要删除的备份文件','./backup.php',0);
	}else{
		foreach($_POST['bak'] as $value)
		{
			unlink($value);
		}
		header("Location: ./backup.php");
	}
}

function bakindata($filename)
{
	global $db,$DB;
	
	$setchar = $DB->getMysqlVersion() > '4.1' ? "ALTER DATABASE {$db} DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" : '';
	$sql = file($filename);
	array_unshift($sql,$setchar);
	$query = '';
	$num = 0;
	foreach($sql as $key => $value)
	{
		$value = trim($value);
		if(!$value || $value[0]=='#')
		{
			continue;
		}
		if(eregi("\;$",$value))
		{
			$query .= $value;
			if(eregi("^CREATE",$query))
			{
				$query = preg_replace("/\DEFAULT CHARSET=([a-z0-9]+)/is",'',$query);
			}
			$DB->query($query);
			$query = '';
		} else{
			$query .= $value;
		}
	}
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

?>