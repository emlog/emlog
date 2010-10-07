<?php
/**
 * 附件处理
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

//上传表单显示
if ($action == 'selectFile') {
	$attachnum = 0;
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	if ($logid) {
		$sql = 'SELECT * FROM '.DB_PREFIX."attachment where blogid=$logid";
		$query=$DB->query($sql);
		$attachnum = $DB->num_rows($query);
	}
	$maxsize = changeFileSize(Options::UPLOADFILE_MAXSIZE);
	//允许附件类型
	$att_type_str = '';
	foreach (Options::getAttType() as $val) {
		$att_type_str .= " $val";
	}
	require_once(View::getView('upload'));
	View::output();
}
//上传附件
if ($action == 'upload') {
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	$attach = isset($_FILES['attach']) ? $_FILES['attach'] : '';
	if ($attach) {
		for ($i = 0; $i < count($attach['name']); $i++) {
			if ($attach['error'][$i] != 4) {
				$upfname = uploadFile($attach['name'][$i], $attach['error'][$i], $attach['tmp_name'][$i], $attach['size'][$i], $attach['type'][$i], Options::getAttType());
				//写入附件信息
				$query="INSERT INTO ".DB_PREFIX."attachment (blogid,filename,filesize,filepath,addtime) values ($logid,'".$attach['name'][$i]."','".$attach['size'][$i]."','".$upfname."','".time()."')";
				$DB->query($query);
				$DB->query("UPDATE ".DB_PREFIX."blog SET attnum=attnum+1 WHERE gid=$logid");
			}
		}
	}
	$CACHE->updateCache('logatts');
	header("Location: attachment.php?action=attlib&logid=$logid");
}
//附件库
if ($action == 'attlib') {
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	$sql="SELECT * FROM ".DB_PREFIX."attachment where blogid=$logid ";
	$query=$DB->query($sql);
	$attachnum = $DB->num_rows($query);
	$attach = array();
	while ($dh=$DB->fetch_array($query)) {
		$attsize = changeFileSize($dh['filesize']);
		$filename = htmlspecialchars($dh['filename']);

		$attach[] = array(
		'attsize'=>$attsize,
		'aid'=>$dh['aid'],
		'filepath'=>$dh['filepath'],
		'filename'=>$filename
		);
	}
	require_once(View::getView('attlib'));
	View::output();
}
//删除附件
if ($action == 'del_attach') {
	$aid = isset($_GET['aid']) ? intval($_GET['aid']) : '';
	$query=$DB->query("select filepath,blogid from ".DB_PREFIX."attachment where aid=$aid ");
	$attach=$DB->fetch_array($query);
	$logid = $attach['blogid'];
	if (file_exists($attach['filepath'])) {
		$fpath = str_replace('thum-', '', $attach['filepath']);
		if ($fpath != $attach['filepath']) {
			@unlink($fpath) or formMsg("删除附件失败!", "javascript:history.go(-1);", 0);
		}
		@unlink($attach['filepath']) or formMsg("删除附件失败!", "javascript:history.go(-1);", 0);
	}
	$row = $DB->once_fetch_array("SELECT blogid FROM ".DB_PREFIX."attachment where aid=$aid");
	$DB->query("UPDATE ".DB_PREFIX."blog SET attnum=attnum-1 WHERE gid={$row['blogid']}");
	$DB->query("DELETE FROM ".DB_PREFIX."attachment where aid=$aid ");
	$CACHE->updateCache('logatts');
	header("Location: attachment.php?action=attlib&logid=$logid");
}
