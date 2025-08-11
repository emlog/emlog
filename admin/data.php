<?php

/**
 * data backup
 * @package EMLOG
 * @link https://www.emlog.net
 */

/**
 * @var string $action
 * @var object $CACHE
 */

require_once 'globals.php';

if (!$action) {
    include View::getAdmView('header');
    require_once(View::getAdmView('data'));
    include View::getAdmView('footer');
    View::output();
}

if ($action === 'backup') {
    LoginAuth::checkToken();

    $DB = Database::getInstance();
    $tables = $DB->listTables();

    $filename = 'emlog_' . Option::EMLOG_VERSION . '_' . date('Ymd_His');

    // 设置内存限制和执行时间限制
    @ini_set('memory_limit', '512M');
    @set_time_limit(300); // 5分钟

    // 创建临时文件来存储备份数据，避免内存溢出
    $tempFile = tempnam(sys_get_temp_dir(), 'emlog_backup_');
    $fp = fopen($tempFile, 'w');

    if (!$fp) {
        emMsg('创建临时备份文件失败，请检查系统临时目录权限');
    }

    // 写入备份文件头信息
    fwrite($fp, '#version:emlog ' . Option::EMLOG_VERSION . "\n");
    fwrite($fp, '#date:' . date('Y-m-d H:i') . "\n");
    fwrite($fp, '#tableprefix:' . DB_PREFIX . "\n");

    // 分批导出每个表的数据
    foreach ($tables as $table) {
        exportDataToFile($table, $fp);
        // 强制释放内存
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
    }

    fwrite($fp, "\n#the end of backup");
    fclose($fp);

    // 读取临时文件内容并压缩
    $dumpfile = file_get_contents($tempFile);
    unlink($tempFile);

    if (($dumpfile = emZip($filename . '.sql', $dumpfile)) === false) {
        emDirect('./data.php?error_f=1');
    }

    // Clear output buffer to prevent any accidental output
    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename=' . $filename . '.zip');
    header('Pragma: no-cache');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    echo $dumpfile;
    exit;
}

if ($action === 'import') {
    LoginAuth::checkToken();
    $sqlfile = isset($_FILES['sqlfile']) ? $_FILES['sqlfile'] : '';
    if (!$sqlfile) {
        emMsg('非法提交的信息');
    }
    if ($sqlfile['error'] == 1) {
        emMsg('文件大小超过系统' . ini_get('upload_max_filesize') . '限制');
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
    importData($sqlfile['tmp_name']);
    $CACHE->updateCache();
    emDirect('./data.php?active_import=1');
}

/**
 * 数据库备份函数，使用分页查询和文件写入避免内存溢出
 *
 * @param string $table 表名
 * @param resource $fp 文件句柄
 * @return void
 */
function exportDataToFile($table, $fp)
{
    $DB = Database::getInstance();

    // 写入删除表语句
    fwrite($fp, "DROP TABLE IF EXISTS $table;\n");

    // 获取表结构
    $createtable = $DB->query("SHOW CREATE TABLE $table");
    $create = $DB->fetch_row($createtable);
    fwrite($fp, $create[1] . ";\n\n");

    // 获取表的总行数
    $countResult = $DB->query("SELECT COUNT(*) as total FROM $table");
    $countRow = $DB->fetch_array($countResult);
    $totalRows = $countRow['total'];

    // 如果表为空，直接返回
    if ($totalRows == 0) {
        fwrite($fp, "\n");
        return;
    }

    // 分页参数
    $batchSize = 1000; // 每批处理1000条记录
    $offset = 0;

    // 获取表字段信息
    $fieldsResult = $DB->query("SHOW COLUMNS FROM $table");
    $fields = [];
    while ($field = $DB->fetch_array($fieldsResult)) {
        $fields[] = $field['Field'];
    }
    $fieldsList = '`' . implode('`, `', $fields) . '`';

    // 分批处理数据
    while ($offset < $totalRows) {
        $sql = "SELECT $fieldsList FROM $table LIMIT $offset, $batchSize";
        $rows = $DB->query($sql);

        if (!$rows) {
            break;
        }

        // 处理当前批次的数据
        while ($row = $DB->fetch_array($rows)) {
            $values = [];
            foreach ($fields as $field) {
                $fieldValue = $row[$field];
                if (is_null($fieldValue)) {
                    $values[] = 'NULL';
                } else {
                    $values[] = "'" . $DB->escape_string($fieldValue) . "'";
                }
            }
            fwrite($fp, "INSERT INTO $table ($fieldsList) VALUES (" . implode(',', $values) . ");\n");
        }

        $offset += $batchSize;

        // 强制释放内存
        if (function_exists('gc_collect_cycles')) {
            gc_collect_cycles();
        }
    }

    fwrite($fp, "\n");
}

function checkSqlFileInfo($sqlfile)
{
    $fp = @fopen($sqlfile, 'r');
    if (!$fp) {
        emMsg('读取备份文件失败，检查文件权限');
    }
    $dumpinfo = [];
    $line = 0;
    while (!feof($fp)) {
        $a = fgets($fp, 4096);
        if (empty(trim($a, "\t\n\r\0\x0B"))) {
            continue;
        }
        $dumpinfo[] = $a;
        $line++;
        if ($line == 3) {
            break;
        }
    }
    fclose($fp);
    if (empty($dumpinfo)) {
        emMsg('该文件不是emlog的数据备份文件');
    }

    if (preg_match("/pro\s\d+\.\d+\.\d+/", $dumpinfo[0], $matches)) {
        $v = $matches[0];
        if ($v !== Option::EMLOG_VERSION) {
            emMsg('不是当前版本生成的数据备份，请安装 emlog ' . $v . ' 导入。');
        }
    } else {
        emMsg('该文件不是 emlog pro 的数据备份文件');
    }

    if (preg_match('/#tableprefix:' . DB_PREFIX . '/', $dumpinfo[2]) === 0) {
        emMsg('备份文件中的数据库表前缀与当前系统数据库表前缀不一致' . $dumpinfo[2]);
    }
}

/**
 * 数据导入函数，使用逐行读取避免内存溢出
 * Execute SQL statement of backup file
 */
function importData($filename)
{
    $DB = Database::getInstance();
    $setchar = $DB->getVersion() > '5.5' ? "ALTER DATABASE `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" : '';
    
    // 设置内存和时间限制，参考导出函数的设置
    @ini_set('memory_limit', '256M');
    @set_time_limit(0);
    
    // 打开文件进行逐行读取
    $fp = @fopen($filename, 'r');
    if (!$fp) {
        emMsg('无法打开备份文件进行读取');
    }
    
    // 处理BOM头
    $firstLine = fgets($fp, 4096);
    if ($firstLine && checkBOM($firstLine)) {
        $firstLine = substr($firstLine, 3);
    }
    
    // 执行字符集设置
    if ($setchar) {
        $DB->query($setchar);
    }
    
    $query = '';
    $lineCount = 0;
    
    // 处理第一行（如果有的话）
     if ($firstLine) {
         $firstLine = trim($firstLine);
         if ($firstLine && $firstLine[0] !== '#') {
             $query .= $firstLine;
             if (preg_match("/\;$/i", $firstLine)) {
                 if (preg_match("/^CREATE/i", $query)) {
                     $query = preg_replace("/\DEFAULT CHARSET=([a-z0-9]+)/is", '', $query);
                 }
                 $result = $DB->query($query);
                 if (!$result && $DB->geterrno() != 0) {
                     error_log("SQL执行失败 (第一行): " . $DB->geterror() . " SQL: " . substr($query, 0, 100));
                 }
                 $query = '';
             }
         }
         $lineCount++;
     }
    
    // 逐行读取并处理SQL语句
    while (!feof($fp)) {
        $line = fgets($fp, 4096);
        if ($line === false) {
            break;
        }
        
        $line = trim($line);
        if (!$line || $line[0] === '#') {
            continue;
        }
        
        $query .= $line;
        
        // 检查是否为完整的SQL语句
         if (preg_match("/\;$/i", $line)) {
             if (preg_match("/^CREATE/i", $query)) {
                 $query = preg_replace("/\DEFAULT CHARSET=([a-z0-9]+)/is", '', $query);
             }
             
             // 执行SQL语句，添加错误处理
             $result = $DB->query($query);
             if (!$result && $DB->geterrno() != 0) {
                 // 记录错误但继续执行，避免因个别语句失败导致整个导入中断
                 error_log("SQL执行失败 (行 $lineCount): " . $DB->geterror() . " SQL: " . substr($query, 0, 100));
             }
             $query = '';
             
             $lineCount++;
             
             // 每处理1000行强制释放内存
             if ($lineCount % 1000 == 0 && function_exists('gc_collect_cycles')) {
                 gc_collect_cycles();
             }
         }
    }
    
    // 处理最后可能未完成的查询
     if (!empty(trim($query))) {
         if (preg_match("/^CREATE/i", $query)) {
             $query = preg_replace("/\DEFAULT CHARSET=([a-z0-9]+)/is", '', $query);
         }
         $result = $DB->query($query);
         if (!$result && $DB->geterrno() != 0) {
             error_log("SQL执行失败 (最后查询): " . $DB->geterror() . " SQL: " . substr($query, 0, 100));
         }
     }
    
    fclose($fp);
    
    // 最终内存清理
    if (function_exists('gc_collect_cycles')) {
        gc_collect_cycles();
    }
}

/**
 * check BOM (byte order mark)
 */
function checkBOM($contents)
{
    $charset[1] = substr($contents, 0, 1);
    $charset[2] = substr($contents, 1, 1);
    $charset[3] = substr($contents, 2, 1);
    return ord($charset[1]) == 239 && ord($charset[2]) == 187 && ord($charset[3]) == 191;
}

if ($action == 'Cache') {
    Register::isRegServer();
    $CACHE->updateCache();
    emDirect('./data.php?active_mc=1');
}
