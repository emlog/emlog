<?php
/**
 * 数据备份
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.2.1
 * $Id$
 */

require_once('globals.php');

if($action == '')
{
	$retval = glob('../content/backup/*.sql');
	$bakfiles = $retval ? $retval : array();
	$tables = array('attachment', 'blog', 'comment', 'options', 'sort', 'link','tag','trackback','twitter','user');
	$defname = 'emlog_'.date('Ymd', $localdate).'_'.substr(md5(date('YmdHis')),0,18);
	doAction('data_prebakup');

	include getViews('header');
	require_once(getViews('data'));
	include getViews('footer');
	cleanPage();
}
if($action == 'bakstart')
{
	$bakfname = isset($_POST['bakfname']) ? $_POST['bakfname'] : '';
	$table_box = isset($_POST['table_box']) ? array_map('addslashes', $_POST['table_box']) : array();
	$bakplace = isset($_POST['bakplace']) ? $_POST['bakplace'] : 'local';

	if(!preg_match("/^[a-zA-Z0-9_]+$/",$bakfname))
	{
		header("Location: ./data.php?error_b=true");
		exit;
	}
	$filename = '../content/backup/'.$bakfname.'.sql';

	$sqldump = '';
	foreach($table_box as $table)
	{
		$sqldump .= dataBak($table);
	}
	if(trim($sqldump))
	{
		$sqldump = '#emlog_'.EMLOG_VERSION." database backup file\n#".date('Y-m-d H:i', $localdate)."\n$sqldump";
		if($bakplace == 'local')
		{
			header('Content-Type: text/x-sql');
			header('Expires: '.date('D, d M Y H:i:s', $localdate) . ' GMT');
			header('Content-Disposition: attachment; filename=emlog_'.date('Ymd', $localdate).'.sql');
			if (preg_match("/MSIE ([0-9].[0-9]{1,2})/", $_SERVER['HTTP_USER_AGENT']))
			{
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			} else {
				header('Pragma: no-cache');
				header('Last-Modified: '.date('D, d M Y H:i:s', $localdate) . ' GMT');
			}
			echo $sqldump;
		} else {
			@$fp = fopen($filename, 'w+');
			if ($fp)
			{
				@flock($fp, 3);
				if(@!fwrite($fp, $sqldump))
				{
					@fclose($fp);
					emMsg('备份失败。备份目录(content/backup)不可写','javascript:history.go(-1);',0);
				}else{
					header("Location: ./data.php?active_backup=true");
				}
			}else{
				emMsg('创建备份文件失败。备份目录(content/backup)不可写','javascript:history.go(-1);');
			}			
		}
	}else{
		formMsg('数据表没有任何内容','javascript:history.go(-1);',0);
	}
}

//导入数据
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
	$CACHE->mc_user();
	$CACHE->mc_options();
	$CACHE->mc_record();
	$CACHE->mc_comment();
	$CACHE->mc_logtags();
	$CACHE->mc_logsort();
	$CACHE->mc_logatts();
	$CACHE->mc_sta();
	$CACHE->mc_link();
	$CACHE->mc_tags();
	$CACHE->mc_sort();
	$CACHE->mc_twitter();
	$CACHE->mc_newlog();
	header("Location: ./data.php?active_import=true");
}

//批量删除备份文件
if($action == 'dell_all_bak')
{
	if(!isset($_POST['bak']))
	{
		header("Location: ./data.php?error_a=true");
	}else{
		foreach($_POST['bak'] as $val)
		{
			unlink($val);
		}
		header("Location: ./data.php?active_del=true");
	}
}
//更新缓存
if ($action == 'mkcache')
{
	$CACHE->mc_user();
	$CACHE->mc_options();
	$CACHE->mc_record();
	$CACHE->mc_comment();
	$CACHE->mc_logtags();
	$CACHE->mc_logsort();
	$CACHE->mc_logatts();
	$CACHE->mc_sta();
	$CACHE->mc_link();
	$CACHE->mc_tags();
	$CACHE->mc_sort();
	$CACHE->mc_twitter();
	$CACHE->mc_newlog();
	header("Location: ./data.php?active_mc=true");
}

/**
 * 导入备份文件
 *
 * @param string $filename
 */
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
		if(preg_match("/\;$/i", $value))
		{
			$query .= $value;
			if(preg_match("/^CREATE/i", $query))
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
