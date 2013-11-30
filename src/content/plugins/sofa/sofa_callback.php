<?php
/*
Plugin Name: 沙发热榜
Version: 1.0
Plugin URL:
Description: 比比看谁抢的沙发多哦～
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
function callback_init() {
	require_once EMLOG_ROOT . '/content/plugins/sofa/class.sofa.php';
	$DB = MySql::getInstance();
	$sql = "SELECT * FROM ".DB_PREFIX."blog WHERE alias='sofa'";
	if($DB->num_rows($DB->query($sql)) == 0) {
		$emPage = new Log_Model();
		$logData = array(
			'title'=>'沙发榜',
			'content'=>'',
			'excerpt'=>'',
			'date'=>$emPage->postDate(Option::get('timezone')),
			'allow_remark'=>'n',
			'hide'=>'n',
			'alias'=>'sofa',
			'type'=>'page'
		);
		$pageId = $emPage->addlog($logData);
		$navibar = Option::get('navibar');
		$navibar[$pageId] = array(
	       'title' => '沙发榜',
	       'url' => '',
	       'is_blank' => '',
	       'hide' => 'n'
	       );
		$navibar = addslashes(serialize($navibar));
		Option::updateOption('navibar', $navibar);
		Cache::getInstance()->updateCache(array('options', 'logalias'));
	}
	sofa::getInstance()->update();
}