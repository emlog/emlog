<?php
/* emlog 2.5.0 Emlog.Net */
require_once('./globals.php');

if ($action == ''){

	include getViews('header');

		function_exists('ini_get')?$upload = ini_get('file_uploads'):$upload = get_cfg_var('file_uploads');
		$upload==true?$upload='可以':$upload='不可以';
		$serverdate = date('Y-n-d G:i:s',time());
		$gdlib = getPhpFun("ImageCreate");
		$reg_glabls = getPhpcfg('register_globals');
		$gpc = getPhpcfg('magic_quotes_gpc');
		$safe_mode = getPhpcfg('safe_mode');

	require_once(getViews('cache'));
	include getViews('footer');cleanPage();
}
if ($action == 'mkcache'){
	$MC->mc_blogger('../cache/blogger');
	$MC->mc_config('../cache/config');
	$MC->mc_record('../cache/records');
	$MC->mc_comment('../cache/comments');
	$MC->mc_logtags('../cache/log_tags');
	$MC->mc_logatts('../cache/log_atts');
	$MC->mc_sta('../cache/sta');
	$MC->mc_link('../cache/links');
	$MC->mc_tags('../cache/tags');
	formMsg('缓存更新成功', './cache.php',1);
}

?>

