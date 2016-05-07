<?php 
/**
 * Custom 404 page
 */
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<!DOCTYPE html>
<!--vot--><html dir="<?= EMLOG_LANGUAGE_DIR ?>" lang="<?=EMLOG_LANGUAGE?>">
<head>
<meta charset="utf-8">
<!--vot--><title><?=lang('404_error')?></title>
<style type="text/css">
<!--
body {
	background-color:#F7F7F7;
	font-family: Arial;
	font-size: 12px;
	line-height:150%;
}
.main {
	background-color:#FFFFFF;
	font-size: 12px;
	color: #666666;
	width:650px;
	margin:60px auto 0px;
	border-radius: 10px;
	padding:30px 10px;
	list-style:none;
	border:#DFDFDF 1px solid;
}
.main p {
	line-height: 18px;
	margin: 5px 20px;
}
-->
</style>
</head>
<body>
<div class="main">
<!--vot--><p><?=lang('404_description')?></p>
<!--vot--><p><a href="javascript:history.back(-1);"><?=lang('click_return')?></a></p>
</div>
</body>
</html>