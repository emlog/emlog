<?php
/**
 * Views Handler
 * @package EMLOG (www.emlog.net)
 */

class View {
	public static function getView($template, $ext = '.php') {
		if (!is_dir(TEMPLATE_PATH)) {
/*vot*/			emMsg(lang('template_not_found'), BLOG_URL . 'admin/template.php');
		}
		return TEMPLATE_PATH . $template . $ext;
	}

	public static function output() {
		$content = ob_get_clean();
		ob_start();
		echo $content;
		ob_end_flush();
		exit;
	}

}
