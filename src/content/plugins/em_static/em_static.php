<?php defined('EMLOG_ROOT') or die('本页面禁止直接访问!');
/*
Plugin Name: EMLOG静态化插件
Version: 1.5
Plugin URL: http://shop.iemlog.com/plugin/em_static
Description: EMLOG静态化插件 授权给(blog.qiyuuu.com)
Author: 朦胧之影
Author URL: http://be-evil.org/
*/

define('EM_STATIC_ROOT', EMLOG_ROOT.'/content/plugins/em_static');

require_once EM_STATIC_ROOT.'/em_static_const.php';
require_once EM_STATIC_ROOT.'/em_static_func.php';

define('EM_STATIC_KEY', '9d878b14e37d6b2c18d4bed30525c3023b622bfa');

if (is_file(EM_STATIC_CONFIG_DATA_FILE)) {
	$GLOBALS['em_static_config_data'] = include EM_STATIC_CONFIG_DATA_FILE;
} else {
	$GLOBALS['em_static_config_data'] = array(
		'enable_auto_create' => 0,
		'auto_create_performance_value' => 3			
	);
}

addAction('adm_sidebar_ext', 'em_static_menu');
// 开启自动生成才挂上钩子
if ($GLOBALS['em_static_config_data']['enable_auto_create'] == 1) {
	addAction('save_log', 'em_static_update_post');
	// emlog 5.1  新支持的钩子
	addAction('before_del_log', 'em_static_delete_post');
	addAction('comment_saved', 'em_static_update_comment');	
	addAction('adm_footer', 'em_static_print_cront_js');
	addAction('index_footer', 'em_static_print_cront_js');
}

function em_static_menu() {
	echo '<div class="sidebarsubmenu" id="em_static"><a href="./plugin.php?plugin=em_static">静态化</a></div>';
}

