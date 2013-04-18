<?php

/**
 * 附件处理
 * @copyright (c) Emlog All Rights Reserved
 */
require_once 'globals.php';

$DB = MySql::getInstance();

//上传表单显示
if ($action == 'selectFile') {
	$attachnum = 0;
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	$multi = isset($_GET['multi']) ? intval($_GET['multi']) : 0;

	if ($logid) {
        $Log_Model = new Log_Model();
        $row = $Log_Model->getOneLogForAdmin($logid);
		$attachnum = (int)$row['attnum'];
	}
	$maxsize = changeFileSize(Option::UPLOADFILE_MAXSIZE);
	//允许附件类型
	$att_type_str = '';
	foreach (Option::getAttType() as $val) {
		$att_type_str .= " $val";
	}
	$view_tpl = $multi ? 'upload_multi' : 'upload';
	require_once(View::getView($view_tpl));
	View::output();
}

//上传附件
if ($action == 'upload') {
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	$attach = isset($_FILES['attach']) ? $_FILES['attach'] : '';
	if ($attach) {
		for ($i = 0; $i < count($attach['name']); $i++) {
			if ($attach['error'][$i] != 4) {
				$isthumbnail = Option::get('isthumbnail') == 'y' ? true : false;
				$file_info = uploadFile($attach['name'][$i], $attach['error'][$i], $attach['tmp_name'][$i], $attach['size'][$i], Option::getAttType(), false, $isthumbnail);
				// 写入附件信息
				$query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')";
				$query = sprintf($query, $logid, $file_info['file_name'], $file_info['size'], $file_info['file_path'], time(), $file_info['width'], $file_info['height'], $file_info['mime_type']);
				$DB->query($query);
				$DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum+1 WHERE gid=$logid");
				// 写入缩略图信息
				if (isset($file_info['thum_file'])) {
					$query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')";
					$query = sprintf($query, $logid, $file_info['file_name'], $file_info['thum_size'], $file_info['thum_file'], time(), $file_info['thum_width'], $file_info['thum_height'], $file_info['mime_type']);
					$DB->query($query);		
				}
			}
		}
	}
	emDirect("attachment.php?action=attlib&logid=$logid");
}

//批量上传
if ($action == 'upload_multi') {
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	$attach = isset($_FILES['attach']) ? $_FILES['attach'] : '';
	if ($attach) {
		if ($attach['error'] != 4) {
			$isthumbnail = Option::get('isthumbnail') == 'y' ? true : false;
			$file_info = uploadFileBySwf($attach['name'], $attach['error'], $attach['tmp_name'], $attach['size'], Option::getAttType(), false, $isthumbnail);
			// 写入附件信息
			$query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')";
			$query = sprintf($query, $logid, $file_info['file_name'], $file_info['size'], $file_info['file_path'], time(), $file_info['width'], $file_info['height'], $file_info['mime_type']);
			$DB->query($query);
			$DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum+1 WHERE gid=$logid");
			// 写入缩略图信息
			if (isset($file_info['thum_file'])) {
				$query = "INSERT INTO " . DB_PREFIX . "attachment (blogid, filename, filesize, filepath, addtime, width, height, mimetype) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s')";
				$query = sprintf($query, $logid, $file_info['file_name'], $file_info['thum_size'], $file_info['thum_file'], time(), $file_info['thum_width'], $file_info['thum_height'], $file_info['mime_type']);
				$DB->query($query);		
			}
		}
	}
}

//附件库
if ($action == 'attlib') {
	$logid = isset($_GET['logid']) ? intval($_GET['logid']) : '';
	$sql = "SELECT * FROM " . DB_PREFIX . "attachment WHERE blogid = $logid ";
	$query = $DB->query($sql);
	$attach = array();
	while ($row = $DB->fetch_array($query)) {
		$attsize = changeFileSize($row['filesize']);
		$filename = htmlspecialchars($row['filename']);
		// 识别图片
		if (isset($attach[$filename]) && !empty($attach[$filename]['width'])) {
			// 比较图片大小，宽度较大的那个是原图，较小的是缩略图
			if ($attach[$filename]['width']	> $row['width']) {
				$attach[$filename]['thum_filepath']	= $row['filepath'];
				$attach[$filename]['thum_width']	= $row['width'];
				$attach[$filename]['thum_height']	= $row['height'];
			} else {
				$attach[$filename]['thum_filepath']	= $attach[$filename]['filepath'];
				$attach[$filename]['thum_filename']	= $attach[$filename]['filename'];
				$attach[$filename]['thum_width']	= $attach[$filename]['width'];
				$attach[$filename]['thum_height']	= $attach[$filename]['height'];
				$attach[$filename]['filename']  = $filename;
				$attach[$filename]['width']     = $row['width'];
				$attach[$filename]['height']    = $row['height'];
				$attach[$filename]['filepath']	= $row['filepath'];
			}			
		} else {
			$attach[$filename] = array(
				'attsize'  => $attsize,
				'aid'      => $row['aid'],
				'filepath' => $row['filepath'],
				'filename' => $filename,
				'width'    => $row['width'],
				'height'   => $row['height'],			
			);
		}
	}
    $attachnum = count($attach);
	include View::getView('attlib');
	View::output();
}

//删除附件
if ($action == 'del_attach') {
	$aid = isset($_GET['aid']) ? intval($_GET['aid']) : '';
	$query = $DB->query("SELECT * FROM " . DB_PREFIX . "attachment WHERE aid = $aid ");
	$attach = $DB->fetch_array($query);
	$logid = $attach['blogid'];
	if (file_exists($attach['filepath'])) {
		@unlink($attach['filepath']) or emMsg("删除附件失败!");
	}
	$query = $DB->query("SELECT * FROM ".DB_PREFIX."attachment WHERE filename = '{$attach['filename']}' AND aid != {$attach['aid']}");
	$thum_attach = $DB->fetch_array($query);
	if ($thum_attach) {
		if (file_exists($thum_attach['filepath'])) {
			@unlink($thum_attach['filepath']) or emMsg("删除附件失败!");
		}
		$row = $DB->once_fetch_array("SELECT blogid FROM " . DB_PREFIX . "attachment where aid = {$thum_attach['aid']}");
		$DB->query("DELETE FROM " . DB_PREFIX . "attachment where aid= {$thum_attach['aid']} ");
	}

	$DB->query("UPDATE " . DB_PREFIX . "blog SET attnum=attnum-1 WHERE gid = {$attach['blogid']}");
	$DB->query("DELETE FROM " . DB_PREFIX . "attachment where aid = {$attach['aid']} ");
	emDirect("attachment.php?action=attlib&logid=$logid");
}

if ($action == 'upload_tw_img') {
	$attach = isset($_FILES['attach']) ? $_FILES['attach'] : '';
	if ($attach) {
		$upfname = uploadFile($attach['name'], $attach['error'], $attach['tmp_name'], $attach['size'], Option::getAttType(), false, false);
		$size = @getimagesize($upfname);
		$w = $size[0];
		$h = $size[1];
		if ($w > Option::T_IMG_MAX_W || $h > Option::T_IMG_MAX_H) {
			$uppath = Option::UPLOADFILE_PATH . gmdate('Ym') . '/';
			$thum = str_replace($uppath, $uppath . 'thum-', $upfname);
			if (false !== resizeImage($upfname, $thum, Option::T_IMG_MAX_W, Option::T_IMG_MAX_H)) {
				$upfname = $thum;
			}
		}
		echo '{"filePath":"' . $upfname . '"}';
		exit;
	}
	echo '{"filePath":""}';
	exit;
}

if ($action == 'del_tw_img') {
	$filepath = isset($_GET['filepath']) ? $_GET['filepath'] : '';
	if ($filepath && file_exists($filepath)) {
		$fpath = str_replace('thum-', '', $filepath);
		if ($fpath != $filepath) {
			@unlink($fpath) or false;
		}
		@unlink($filepath) or false;
	}
	exit;
}
