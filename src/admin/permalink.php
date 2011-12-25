<?php
/**
 * 固定连接
 * @copyright (c) Emlog All Rights Reserved
 */

require_once 'globals.php';

if ($action == '') {
	$ex0 = $ex1 = $ex2 = $ex3 = '';
	$t = 'ex'.Option::get('isurlrewrite');
	$$t = 'checked="checked"';

	$isalias = Option::get('isalias') == 'y' ? 'checked="checked"' : '';
	$isalias_html = Option::get('isalias_html') == 'y' ? 'checked="checked"' : '';

	include View::getView('header');
	require_once(View::getView('permalink'));
	include View::getView('footer');
	View::output();
}

if ($action == 'update') {
	$permalink = isset($_POST['permalink']) ? addslashes($_POST['permalink']) : '0';
	$isalias = isset($_POST['isalias']) ? addslashes($_POST['isalias']) : 'n';
	$isalias_html = isset($_POST['isalias_html']) ? addslashes($_POST['isalias_html']) : 'n';

	if($permalink != '0' || $isalias == 'y'){
		$fp = @fopen(EMLOG_ROOT.'/.htaccess', 'w');
		$t = parse_url(BLOG_URL);
		$rw_rule = '<IfModule mod_rewrite.c>
					   RewriteEngine on
					   RewriteCond %{REQUEST_FILENAME} !-f
					   RewriteCond %{REQUEST_FILENAME} !-d
					   RewriteBase ' . $t['path'] . '
					   RewriteRule . ' . $t['path'] . 'index.php [L]
					</IfModule>';
		if (!@fwrite($fp, $rw_rule)){
			header('Location: ./permalink.php?error=true');
			exit;
		}
		fclose($fp);
	}

	Option::updateOption('isurlrewrite', $permalink);
	Option::updateOption('isalias', $isalias);
	Option::updateOption('isalias_html', $isalias_html);
	$CACHE->updateCache('options');
	header('Location: ./permalink.php?activated=true');
}
