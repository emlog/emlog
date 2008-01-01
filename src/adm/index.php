<?php
/* emlog 2.5.0 Emlog.Net */
require_once('./globals.php');

if ($action == ''){

	include getViews('header');
	
	$serverapp = $_SERVER['SERVER_SOFTWARE'];
	$dbversion = $DB->version();
	function_exists('ini_get')?$upload = ini_get('file_uploads'):$upload = get_cfg_var('file_uploads');
	$upload==true?$upload='可以':$upload='不可以';
	$serverdate = date('Y-n-d G:i:s',time());
	$gdlib = getPhpFun("ImageCreate");
	$reg_glabls = getPhpcfg('register_globals');
	$gpc = getPhpcfg('magic_quotes_gpc');
	$safe_mode = getPhpcfg('safe_mode');

	require_once(getViews('index'));
	include getViews('footer');cleanPage();
}

?>

