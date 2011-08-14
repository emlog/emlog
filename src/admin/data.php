<?php
/**
 * 数据备份
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

if($action == ''){
	$retval = glob('../content/backup/*.sql');
	$bakfiles = $retval ? $retval : array();
	$timezone = Option::get('timezone');
	$tables = array('attachment', 'blog', 'comment', 'options', 'reply', 'sort', 'link','tag','trackback','twitter','user');
	$defname = 'emlog_'. gmdate('Ymd', time() + $timezone * 3600) . '_' . substr(md5(gmdate('YmdHis', time() + $timezone * 3600)),0,18);
	doAction('data_prebakup');

	include View::getView('header');
	require_once(View::getView('data'));
	include View::getView('footer');
	View::output();
}

if($action == 'bakstart'){
	$bakfname = isset($_POST['bakfname']) ? $_POST['bakfname'] : '';
	$table_box = isset($_POST['table_box']) ? array_map('addslashes', $_POST['table_box']) : array();
	$bakplace = isset($_POST['bakplace']) ? $_POST['bakplace'] : 'local';

	$timezone = Option::get('timezone');

	if(!preg_match("/^[a-zA-Z0-9_]+$/",$bakfname)){
		emDirect("./data.php?error_b=true");
	}
	$filename = '../content/backup/'.$bakfname.'.sql';

	$sqldump = '';
	foreach($table_box as $table){
		$sqldump .= dataBak($table);
	}
	if(trim($sqldump)){
		$dumpfile = '#version:emlog '. Option::EMLOG_VERSION . "\n";
		$dumpfile .= '#date:' . gmdate('Y-m-d H:i', time() + $timezone * 3600) . "\n";
		$dumpfile .= '#tableprefix:' . DB_PREFIX . "\n";
		$dumpfile .= $sqldump;
		$dumpfile .= "\n#the end of backup";
		if($bakplace == 'local'){
			header('Content-Type: text/x-sql');
			header('Expires: '. gmdate('D, d M Y H:i:s', time() + $timezone * 3600) . ' GMT');
			header('Content-Disposition: attachment; filename=emlog_'. gmdate('Ymd', time() + $timezone * 3600).'.sql');
			if (preg_match("/MSIE ([0-9].[0-9]{1,2})/", $_SERVER['HTTP_USER_AGENT'])){
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
			} else {
				header('Pragma: no-cache');
				header('Last-Modified: '. gmdate('D, d M Y H:i:s', time() + $timezone * 3600) . ' GMT');
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
					emMsg('备份失败。备份目录(content/backup)不可写');
				}else{
					emDirect("./data.php?active_backup=true");
				}
			}else{
				emMsg('创建备份文件失败。备份目录(content/backup)不可写');
			}
		}
	}else{
		emMsg('数据表没有任何内容');
	}
}

//导入服务器备份文件
if ($action == 'renewdata'){
	$sqlfile = isset($_GET['sqlfile']) ? $_GET['sqlfile'] : '';
	if (!file_exists($sqlfile)){
		emMsg('文件不存在');
	}

	if (getFileSuffix($sqlfile) !== 'sql'){
		emMsg('只能导入emlog备份的SQL文件');
	}
	checkSqlFileInfo($sqlfile);
	bakindata($sqlfile);
	$CACHE->updateCache();
	emDirect("./data.php?active_import=true");
}

//导入本地备份文件
if ($action == 'import'){
	$sqlfile = isset($_FILES['sqlfile']) ? $_FILES['sqlfile'] : '';
	if (!$sqlfile) {
		emMsg('非法提交的信息');
	}
	if (getFileSuffix($sqlfile['name']) != 'sql') {
		emMsg('只能导入emlog备份的SQL文件');
	}
	if ($sqlfile['error'] == 1){
		emMsg('附件大小超过系统'.ini_get('upload_max_filesize').'限制');
	}elseif ($sqlfile['error'] > 1){
		emMsg('上传文件失败,错误码：'.$sqlfile['error']);
	}
	checkSqlFileInfo($sqlfile['tmp_name']);
	bakindata($sqlfile['tmp_name']);
	$CACHE->updateCache();
	emDirect("./data.php?active_import=true");
}

//批量删除备份文件
if($action == 'dell_all_bak'){
	if(!isset($_POST['bak'])){
		emDirect("./data.php?error_a=true");
	}else{
		foreach($_POST['bak'] as $val){
			unlink($val);
		}
		emDirect("./data.php?active_del=true");
	}
}

//更新缓存
if ($action == 'Cache'){
	$CACHE->updateCache();
	emDirect("./data.php?active_mc=true");
}

/**
 * 检查备份文件头信息
 * 
 * @param file $sqlfile
 */
function checkSqlFileInfo($sqlfile) {
	// 读取备份文件信息
	$fp = @fopen($sqlfile, 'r');
	if ($fp){
		$dumpinfo = array();
		$line = 0;
		while (!feof($fp)){
			$dumpinfo[] = fgets($fp, 4096);
			$line++;
			if ($line == 3) break;
		}
		fclose($fp);
		if (!empty($dumpinfo)){
			// 验证版本
			if (preg_match('/#version:emlog '. Option::EMLOG_VERSION .'/', $dumpinfo[0]) === 0) {
				emMsg("导入失败! 该备份文件不是 emlog " . Option::EMLOG_VERSION . "的备份文件!");
			}
			// 验证表前缀
			if (preg_match('/#tableprefix:'. DB_PREFIX .'/', $dumpinfo[2]) === 0) {
				emMsg("导入失败! 备份文件中的数据库前缀与当前系统数据库前缀不匹配" . $dumpinfo[2]);
			}
		} else {
			emMsg("导入失败! 该备份文件不是 emlog的备份文件!");
		}
	} else {
		emMsg("导入失败! 读取文件失败");
	}
}

/**
 * 执行备份文件的SQL语句
 *
 * @param string $filename
 */
function bakindata($filename) {
	global $db;
	$DB = MySql::getInstance();
	$setchar = $DB->getMysqlVersion() > '4.1' ? "ALTER DATABASE {$db} DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" : '';
	$sql = file($filename);
	if(isset($sql[0]) && !empty($sql[0]) && checkBOM($sql[0])) {
	    $sql[0] = substr($sql[0], 3);
	}
	array_unshift($sql,$setchar);
	$query = '';
	foreach($sql as $value){
		$value = trim($value);
		if(!$value || $value[0]=='#'){
			continue;
		}
		if(preg_match("/\;$/i", $value)){
			$query .= $value;
			if(preg_match("/^CREATE/i", $query)){
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
function dataBak($table){
	$DB = MySql::getInstance();
	$sql = "DROP TABLE IF EXISTS $table;\n";
	$createtable = $DB->query("SHOW CREATE TABLE $table");
	$create = $DB->fetch_row($createtable);
	$sql .= $create[1].";\n\n";

	$rows = $DB->query("SELECT * FROM $table");
	$numfields = $DB->num_fields($rows);
	$numrows = $DB->num_rows($rows);
	while ($row = $DB->fetch_row($rows)){
		$comma = "";
		$sql .= "INSERT INTO $table VALUES(";
		for ($i = 0; $i < $numfields; $i++){
			$sql .= $comma."'".mysql_escape_string($row[$i])."'";
			$comma = ",";
		}
		$sql .= ");\n";
	}
	$sql .= "\n";
	return $sql;
}

/**
 * 检查文件是否包含BOM(byte-order mark)
 */
function checkBOM($contents) {
    $charset[1] = substr($contents, 0, 1);
    $charset[2] = substr($contents, 1, 1);
    $charset[3] = substr($contents, 2, 1);
    if (ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191) {
        return true;
    } else {
        return false;
    }
}
