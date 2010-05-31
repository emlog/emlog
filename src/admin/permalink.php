<?php
/**
 * 固定连接
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.5.1
 * $Id: configure.php 1448 2009-08-29 06:25:11Z emloog $
 */

require_once 'globals.php';

if ($action == '') {
	$ex0 = $ex1 = $ex2 = '';
	$t = 'ex'.$isurlrewrite;
	$$t = 'checked="checked"';

	include getViews('header');
	require_once(getViews('permalink'));
	include getViews('footer');
	cleanPage();
}

if ($action == 'update') {
	$permalink = isset($_POST['permalink']) ? addslashes($_POST['permalink']) : '0';

	if($permalink != '0'){
		$fp = @fopen(EMLOG_ROOT.'/.htaccess', 'w');
		$t = parse_url(BLOG_URL);
		switch ($permalink){
			case '1':
				$rw_rule = '
							<IfModule mod_rewrite.c>
								RewriteEngine on
								RewriteCond %{REQUEST_FILENAME} !-f
								RewriteCond %{REQUEST_FILENAME} !-d
								RewriteBase '.$t['path'].'
								RewriteRule ^(post|record|sort|author|page)-([0-9]+)\.html$ index.php?$1=$2
								RewriteRule ^tag-(.+)\.html$ index.php?tag=$1
								RewriteRule ^t/page-([0-9]+)\.html$ t/index.php?page=$1
							</IfModule>';
				break;
			case '2':
				$rw_rule = '
							<IfModule mod_rewrite.c>
								RewriteEngine on
								RewriteCond %{REQUEST_FILENAME} !-f
								RewriteCond %{REQUEST_FILENAME} !-d
								RewriteBase '.$t['path'].'
								RewriteRule ^(post|record|sort|author|page)/([0-9]+)$ index.php?$1=$2
								RewriteRule ^tag/(.+)$ index.php?tag=$1
								RewriteRule ^t/page/([0-9]+)$ t/index.php?page=$1
							</IfModule>';
				break;
		}
		if (!@fwrite($fp, $rw_rule)){
			header("Location: ./permalink.php?error=true");
			exit;
		}
		fclose($fp);
	}

	updateOption('isurlrewrite', $permalink);
	$CACHE->updateCache('options');
	header("Location: ./permalink.php?activated=true");
}
