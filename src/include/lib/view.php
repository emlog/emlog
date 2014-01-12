<?php
/**
 * 视图控制
 * @copyright (c) Emlog All Rights Reserved
 */

class View {
	public static function getView($template, $ext = '.php') {
		if (!is_dir(TEMPLATE_PATH)) {
			emMsg('当前使用的模板已被删除或损坏，请登录后台更换其他模板。', BLOG_URL . 'admin/template.php');
		}
        //增加二级页面单独模板，兼容5.2.1及以前版本
        if($template == 'list' && !file_exists(TEMPLATE_PATH . $template . $ext)) {
            $template = 'log_list';
        }
		return TEMPLATE_PATH . $template . $ext;
	}

	public static function output() {
		$content = ob_get_clean();
		if (Option::get('isgzipenable') == 'y' && function_exists('ob_gzhandler')) {
			ob_start('ob_gzhandler');
		} else {
			ob_start();
		}
		echo $content;
		ob_end_flush();
		exit;
	}
	
}
