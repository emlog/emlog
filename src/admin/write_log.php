<?php
/**
 * Post writing, editing interface
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

//Write post page
if ($action == '') {
	$Tag_Model = new Tag_Model();
	$Sort_Model = new Sort_Model();

	$sorts = $CACHE->readCache('sort');
	$tags = $Tag_Model->getTag();

	$localtime = time() + Option::get('timezone') * 3600;
	$postDate = gmdate('Y-m-d H:i:s', $localtime);

	include View::getView('header');
	require_once View::getView('add_log');
	include View::getView('footer');
	View::output();
}

//Edit blog page
if ($action == 'edit') {
	$Log_Model = new Log_Model();
	$Tag_Model = new Tag_Model();
	$Sort_Model = new Sort_Model();

	$logid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$blogData = $Log_Model->getOneLogForAdmin($logid);
	extract($blogData);

	$orig_date = $date - Option::get('timezone') * 3600;
	$sorts = $CACHE->readCache('sort');
	//log tag
	$tags = array();
	foreach ($Tag_Model->getTag($logid) as $val) {
		$tags[] = $val['tagname'];
	}
	$tagStr = implode(',', $tags);
	//old tag
	$tags = $Tag_Model->getTag();

	$is_top = $top == 'y' ? 'checked="checked"' : '';
	$is_sortop = $sortop == 'y' ? 'checked="checked"' : '';
	$is_allow_remark = $allow_remark == 'y' ? 'checked="checked"' : '';

	include View::getView('header');
	require_once View::getView('edit_log');
	include View::getView('footer');View::output();
}
