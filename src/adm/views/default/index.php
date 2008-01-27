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
		<td width="50%">待审核评论: <span class="$hctyle"><b>$hidecom</b></span> | 
						日志: <span class=care2><b>$lognum</b></span> | 
						评论: <span class=care2><b>$allcom</b></span> | 
						引用(TrackBack): <span class=care2><b>$tbnum</b></span>
		</td>
	</tr>
</table>
<div class=line2></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
	<tr>
		<td width="50%">PHP版本: $php_ver</td>
		<td width="50%">服务器引擎: $serverapp</td>
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
<div class=containertitle><b>关于我们</b></div>
<div class=line></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
	<tr>
		<td width="50%">程序设计: <a href="http://www.emlog.net/blog">那多记忆</a></td>
		<td width="50%">美工: <a href="mailto:jflyang@sohu.com">CrazyDavinc</a></td>
	</tr>
	<tr>
		<td width="50%">官方主页: <a href="http://www.emlog.net" target="_blank">Www.Emlog.Net</a></font></td>
		<td width="50%">电子邮件: <a href="mailto:emloog@gmail.com">emloog@gmail.com</a></td>
	</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
<!--
EOT;
?>-->