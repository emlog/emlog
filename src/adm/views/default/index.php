<!--
<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
$hctyle = $hidecom ? 'tips' : 'care2';
$allcom = $hidecom + $comnum;
print <<<EOT
-->
<div class=containertitle><b>博客信息</b></div>
<div class=line></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
	<tr>
		<td width="50%">
<!--
EOT;
if($ischkcomment == 'y' || $hidecom != 0){
print <<<EOT
-->
		待审核评论: <span class="$hctyle"><b>$hidecom</b></span> | 
<!--
EOT;
}print <<<EOT
-->
		日志: <span class=care2><b>$lognum</b></span> | 
		评论: <span class=care2><b>$allcom</b></span> | 
		引用(TrackBack): <span class=care2><b>$tbnum</b></span>
		</td>
	</tr>
</table>
<div class=line2></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
	<tr>
		<td width="50%">服务器环境: $serverapp</td>
		<td width="50%">PHP版本: $php_ver</td>
	</tr>
	 <tr>
		<td width="50%">MySQL数据库: $mysql_ver</td>
		<td width="50%">服务器时间: $serverdate</td>
	</tr>
	<tr>
		<td width="50%">GD图形处理库: $gd_ver</td>
		<td><a href="configure.php?action=phpinfo">[phpinfo]</a></td>
	</tr>
</table>
<div class=line2></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
	<tr>
		<td width="50%">官方主页: <a href="http://www.emlog.net" target="_blank">www.emlog.net</a></font></td>
		<td width="50%">官方博客: <a href="http://www.emlog.net/blog" target="_blank">every memory log</a></td>
	</tr>
	<tr>
		<td width="50%">工程控制: <a href="http://code.google.com/p/emlog/" target="_blank">google-code.emlog</a></td>
		<td width="50%">电子邮件: <a href="mailto:emloog@gmail.com">emloog@gmail.com</a></td>
	</tr>
</table>
$empigeon
</td>
</tr>
</table>
</td>
</tr>
</table>
<!--
EOT;
?>-->