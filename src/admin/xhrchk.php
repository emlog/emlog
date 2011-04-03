<?php
/**
 * 异步校验.XMLHTTPrequest
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

//检查日志别名
if ($action == 'chk_alias') {
	$alias = isset($_GET['alias']) ? addslashes(trim($_GET['alias'])) : '';
	$logid = isset($_GET['gid']) ? intval(trim($_GET['gid'])) : '';

    if (!empty($alias)) {
        if (preg_match("/^[0-9]+$/", $alias)) {
    		exit('001');//别名格式错误,不能是纯数字
    	}

    	if (!preg_match("/^[^/\.=\?]+$/", $alias)) {
    		exit('001');//别名格式错误
    	}

        $logalias_cache = $CACHE->readCache('logalias');
        $key = array_search($alias, $logalias_cache);
        if (false !== $key && $key != $logid){
        	exit('002');//别名重复
        }
    }
}
