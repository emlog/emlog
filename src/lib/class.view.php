<?php
/**
 * 视图控制
 * @copyright (c) Emlog All Rights Reserved
 * $Id$
 */

class View {

	public static function getView($template, $ext = '.php'){
	    if (!is_dir(TEMPLATE_PATH)){
	        emMsg('当前使用的模板已被删除或损坏，请登录后台更换其他模板。', BLOG_URL . 'admin/template.php');
	    }
	    return TEMPLATE_PATH.$template.$ext;
	}

    public static function output() {
        $content = ob_get_clean();
        header('Content-Type: text/html; charset=UTF-8');
	    if (Options::get('isgzipenable') == 'y' && function_exists('ob_gzhandler')){
	        ob_start('ob_gzhandler');
	    } else {
	        ob_start();
	    }
        echo $content;
        ob_end_flush();
        exit;
    }

}
