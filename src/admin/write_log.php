<?php
/**
 * Show writing, editing, log in interface
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

//Display the Write blog page
if ($action == '') {
	$Tag_Model = new Tag_Model();
	$Sort_Model = new Sort_Model();

    $blogData = array(
        'logid' => -1,
        'title' => '',
        'content' => '',
        'excerpt' => '',
        'alias' => '', 
        'author' => '',
        'sortid' => -1,
        'type' => 'blog',
        'password' => '',
        'hide' => '',
        'author' => UID,
    );
    extract($blogData);

    $isdraft = false;
/*vot*/    $containertitle = lang('post_write');
    $orig_date = '';
	$sorts = $CACHE->readCache('sort');
	$tagStr = '';
	$tags = $Tag_Model->getTag();
	$is_top = '';
	$is_sortop = '';
	$is_allow_remark = '';
	$localtime = time() + Option::get('timezone') * 3600;
	$postDate = gmdate('Y-m-d H:i:s', $localtime);
    $att_frame_url = 'attachment.php?action=selectFile';

	include View::getView('header');
	require_once View::getView('write');
	include View::getView('footer');
	View::output();
}

//Show edit blog page
if ($action == 'edit') {
	$Log_Model = new Log_Model();
	$Tag_Model = new Tag_Model();
	$Sort_Model = new Sort_Model();

	$logid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$blogData = $Log_Model->getOneLogForAdmin($logid);
	extract($blogData);

    $isdraft = $hide == 'y' ? true : false;
/*vot*/    $containertitle = $isdraft ? lang('draft_edit') : lang('post_edit');
    $postDate = gmdate('Y-m-d H:i:s', $date);
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
    
    $att_frame_url = 'attachment.php?action=attlib&logid='.$logid;

	include View::getView('header');
	require_once View::getView('write');
	include View::getView('footer');View::output();
}
