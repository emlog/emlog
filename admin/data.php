<?php
/**
 * data backup
 * @package EMLOG (www.emlog.net)
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (!$action) {
	doAction('data_prebakup');
	include View::getView('header');
	require_once(View::getView('data'));
	include View::getView('footer');
	View::output();
}

// 备份到本地
if ($action === 'bakstart') {
	LoginAuth::checkToken();
	$zipbak = $_POST['zipbak'] ?? 'n';

	$tables = [
		'attachment',
		'blog',
		'comment',
		'options',
		'navi',
		'sort',
		'link',
		'storage',
		'tag',
		'user'
	];

	$bakfname = 'emlog_' . date('Ymd') . '_' . substr(md5(AUTH_KEY . uniqid()), 0, 18);
	$filename = '';
	$sqldump = '';

	foreach ($tables as $table) {
		$sqldump .= dataBak(DB_PREFIX . $table);
	}

	$dumpfile = '#version:emlog ' . Option::EMLOG_VERSION . "\n";
	$dumpfile .= '#date:' . date('Y-m-d H:i') . "\n";
	$dumpfile .= '#tableprefix:' . DB_PREFIX . "\n";
	$dumpfile .= $sqldump;
	$dumpfile .= "\n#the end of backup";

	$filename = 'emlog_' . date('Ymd_His');
	if ($zipbak == 'y') {
		if (($dumpfile = emZip($filename . '.sql', $dumpfile)) === false) {
			emDirect('./data.php?error_f=1');
		}
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename=' . $filename . '.zip');
	} else {
		header('Content-Type: text/x-sql');
		header('Content-Disposition: attachment; filename=' . $filename . '.sql');
	}
	if (preg_match("/MSIE ([0-9].[0-9]{1,2})/", $_SERVER['HTTP_USER_AGENT'])) {
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
	} else {
		header('Pragma: no-cache');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	}
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	echo $dumpfile;
}

//导入本地备份文件
if ($action === 'import') {
	LoginAuth::checkToken();
	$sqlfile = $_FILES['sqlfile'] ?? '';
	if (!$sqlfile) {
		emMsg('非法提交的信息');
	}
	if ($sqlfile['error'] == 1) {
		emMsg('附件大小超过系统' . ini_get('upload_max_filesize') . '限制');
	} elseif ($sqlfile['error'] > 1) {
		emMsg('上传文件失败,错误码：' . $sqlfile['error']);
	}
	if (getFileSuffix($sqlfile['name']) == 'zip') {
		$ret = emUnZip($sqlfile['tmp_name'], dirname($sqlfile['tmp_name']), 'backup');
		switch ($ret) {
			case -3:
				emDirect('./data.php?error_e=1');
				break;
			case 1:
			case 2:
				emDirect('./data.php?error_d=1');
				break;
			case 3:
				emDirect('./data.php?error_c=1');
				break;
		}
		$sqlfile['tmp_name'] = dirname($sqlfile['tmp_name']) . '/' . str_replace('.zip', '.sql', $sqlfile['name']);
		if (!file_exists($sqlfile['tmp_name'])) {
			emMsg('只能导入emlog备份的压缩包，且不能修改压缩包文件名！');
		}
	} elseif (getFileSuffix($sqlfile['name']) != 'sql') {
		emMsg('只能导入emlog备份的SQL文件');
	}
	checkSqlFileInfo($sqlfile['tmp_name']);
	bakindata($sqlfile['tmp_name']);
	$CACHE->updateCache();
	emDirect('./data.php?active_import=1');
}

/**
 * 检查备份文件头信息
 */
function checkSqlFileInfo($sqlfile) {
	$fp = @fopen($sqlfile, 'r');
	if (!$fp) {
		emMsg('导入失败！读取文件失败');
	}
	$dumpinfo = array();
	$line = 0;
	while (!feof($fp)) {
		$dumpinfo[] = fgets($fp, 4096);
		$line++;
		if ($line == 3) break;
	}
	fclose($fp);
	if (empty($dumpinfo)) {
		emMsg('导入失败！该文件不是emlog的数据备份文件!');
	}
	if (!strstr($dumpinfo[0], '#version:emlog ' . Option::EMLOG_VERSION)) {
		emMsg('导入失败！该文件不是emlog' . Option::EMLOG_VERSION . '生成的备份!');
	}
	if (preg_match('/#tableprefix:' . DB_PREFIX . '/', $dumpinfo[2]) === 0) {
		emMsg('导入失败！备份文件中的数据库表前缀与当前系统数据库表前缀不一致' . $dumpinfo[2]);
	}
}

/**
 * 执行备份文件的SQL语句
 *
 * @param string $filename
 */
function bakindata($filename) {
	$DB = Database::getInstance();
	$setchar = $DB->getMysqlVersion() > '4.1' ? "ALTER DATABASE `" . DB_NAME . "` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;" : '';
	$sql = file($filename);
	if (isset($sql[0]) && !empty($sql[0]) && checkBOM($sql[0])) {
		$sql[0] = substr($sql[0], 3);
	}
	array_unshift($sql, $setchar);
	$query = '';
	foreach ($sql as $value) {
		$value = trim($value);
		if (!$value || $value[0] == '#') {
			continue;
		}
		if (preg_match("/\;$/i", $value)) {
			$query .= $value;
			if (preg_match("/^CREATE/i", $query)) {
				$query = preg_replace("/\DEFAULT CHARSET=([a-z0-9]+)/is", '', $query);
			}
			$DB->query($query);
			$query = '';
		} else {
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
function dataBak($table) {
	$DB = Database::getInstance();
	$sql = "DROP TABLE IF EXISTS $table;\n";
	$createtable = $DB->query("SHOW CREATE TABLE $table");
	$create = $DB->fetch_row($createtable);
	$sql .= $create[1] . ";\n\n";

	$rows = $DB->query("SELECT * FROM $table");
	$numfields = $DB->num_fields($rows);
	while ($row = $DB->fetch_row($rows)) {
		$comma = '';
		$sql .= "INSERT INTO $table VALUES(";
		for ($i = 0; $i < $numfields; $i++) {
			$sql .= $comma . "'" . $DB->escape_string($row[$i]) . "'";
			$comma = ',';
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

if ($action == 'Cache') {
	Register::isRegServer();
	$CACHE->updateCache();
	emDirect('./data.php?active_mc=1');
}
