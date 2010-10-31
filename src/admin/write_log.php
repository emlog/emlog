<?php
/**
 * 显示撰写、编辑日志界面
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

require_once 'globals.php';

//显示撰写日志页面
if($action == '') {
	$Tag_Model = new Tag_Model();
	$Sort_Model = new Sort_Model();

	$sorts = $Sort_Model->getSorts();
	$tags = $Tag_Model->getTag();

	$localtime = time() + Option::get('timezone') * 3600;
	$postDate = gmdate('Y-m-d H:i:s', $localtime);

	include View::getView('header');
	require_once View::getView('add_log');
	include View::getView('footer');
	View::output();
}

//显示编辑日志页面
if ($action == 'edit') {
	$Log_Model = new Log_Model();
	$Tag_Model = new Tag_Model();
	$Sort_Model = new Sort_Model();

	$logid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$blogData = $Log_Model->getOneLogForAdmin($logid);
	extract($blogData);
	$sorts = $Sort_Model->getSorts();
	//log tag
	$tags = array();
	foreach ($Tag_Model->getTag($logid) as $val) {
		$tags[] = $val['tagname'];
	}
	$tagStr = implode(',', $tags);
	//old tag
	$tags = $Tag_Model->getTag();

	$is_top = $top == 'y' ? 'checked="checked"' : '';
    $is_allow_remark = $allow_remark == 'y' ? 'checked="checked"' : '';
    $is_allow_tb = $allow_tb == 'y' ? 'checked="checked"' : '';

	include View::getView('header');
	require_once View::getView('edit_log');
	include View::getView('footer');View::output();
}
