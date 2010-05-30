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
	updateOption('isurlrewrite', $permalink);
	$CACHE->updateCache('options');
	header("Location: ./permalink.php?activated=true");
}
