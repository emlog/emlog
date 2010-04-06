<?php
/**
 * 数据备份
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id$
 */

require_once 'globals.php';

$utctimestamp += $timezone * 3600;

if($action == '')
{
	$retval = glob('../content/backup/*.sql');
	$bakfiles = $retval ? $retval : array();
	$tables = array('attachment', 'blog', 'comment', 'options', 'reply', 'sort', 'link','tag','trackback','twitter','user');
	$defname = 'emlog_'. gmdate('Ymd', $utctimestamp) . '_' . substr(md5(gmdate('YmdHis', $utctimestamp)),0,18);
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
		$dumpfile = '#version:emlog '. EMLOG_VERSION . "\n";
		$dumpfile .= '#date:' . gmdate('Y-m-d H:i', $utctimestamp) . "\n";
		$dumpfile .= '#tableprefix:' . DB_PREFIX . "\n";
		$dumpfile .= $sqldump;
		$dumpfile .= "\n#the end of backup";
		if($bakplace == 'local')
		{
			header('Content-Type: text/x-sql');
			header('Expires: '. gmdate('D, d M Y H:i:s', $utctimestamp) . ' GMT');
			header('Content-Disposition: attachment; filename=emlog_'. gmdate('Ymd', $utctimestamp).'.sql');
			if (preg_match("/MSIE ([0-9].[0-9]{1,2})/", $_SERVER['HTTP_USER_AGENT']))
			{
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			} else {
				header('Pragma: no-cache');
				header('Last-Modified: '. gmdate('D, d M Y H:i:s', $utctimestamp) . ' GMT');
			}
			echo $dumpfile;
		} else {
			@$fp = fopen($filename, 'w+');
			if ($fp)
			{
				@flock($fp, 3);
				if(@!fwrite($fp, $dumpfile))
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
		// 读取备份文件信息
		$fp = @fopen($sqlfile, 'r');
		if ($fp)
		{
			$dumpinfo = array();
			$line = 0;
			while (!feof($fp))
			{
				$dumpinfo[] = fgets($fp, 4096);
				$line++;
				if ($line == 3) break;
			}
			fclose($fp);
			if (!empty($dumpinfo))
			{
				// 验证版本
				if (preg_match('/#version:emlog '. EMLOG_VERSION .'/', $dumpinfo[0]) === 0)
					formMsg("导入失败! 该备份文件不是 emlog ".EMLOG_VERSION."的备份文件!", 'javascript:history.go(-1);',0);
				// 验证表前缀
				if (preg_match('/#tableprefix:'. DB_PREFIX .'/', $dumpinfo[2]) === 0)
					formMsg("导入失败! 备份文件中的数据库前缀与当前系统数据库前缀不匹配", 'javascript:history.go(-1);',0);
			} else {
				formMsg("导入失败! 该备份文件不是 emlog 的备份文件!", 'javascript:history.go(-1);',0);
			}
		} else {
			formMsg("导入失败! 备份文件无法读取!", 'javascript:history.go(-1);',0);
		}
	}

	bakindata($sqlfile);
	$CACHE->updateCache();
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
	$CACHE->updateCache();
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
