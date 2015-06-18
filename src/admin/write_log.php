<?php
/**
 * 显示撰写、编辑文章界面
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

//显示撰写文章页面
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
    $containertitle = '写文章';
    $orig_date = '';
	$sorts = $CACHE->readCache('sort');
	$tagStr = '';
	$tags = $Tag_Model->getTag();
	$is_top = '';
	$is_sortop = '';
	$is_allow_remark = '';
	$postDate = date('Y-m-d H:i:s');
    $att_frame_url = 'attachment.php?action=selectFile';

	include View::getView('header');
	require_once View::getView('write');
	include View::getView('footer');
	View::output();
}

//显示编辑文章页面
if ($action == 'edit') {
	$Log_Model = new Log_Model();
	$Tag_Model = new Tag_Model();
	$Sort_Model = new Sort_Model();

	$logid = isset($_GET['gid']) ? intval($_GET['gid']) : '';
	$blogData = $Log_Model->getOneLogForAdmin($logid);
	extract($blogData);

    $isdraft = $hide == 'y' ? true : false;
    $containertitle = $isdraft ? '编辑草稿' : '编辑文章';
    $postDate = date('Y-m-d H:i:s', $date);
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
