<?php 
if(!defined('ADMIN_ROOT')) {exit('error!');}
$allcom = $hidecom + $comnum;
?>
<div class=containertitle></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
	<tr>
		<td width="50%">
<?php if($ischkcomment == 'y' || $hidecom != 0): ?>
		待审核评论: <span class="care"><b><?php echo $hidecom; ?></b></span> | 
<?php endif; ?>
		日志: <span class=care2><b><?php echo $lognum; ?></b></span> | 
		评论: <span class=care2><b><?php echo $allcom; ?></b></span> | 
		引用: <span class=care2><b><?php echo $tbnum; ?></b></span>
		</td>
	</tr>
</table>
<div class=line2></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
	<tr>
		<td width="50%">服务器环境: <?php echo $serverapp; ?></td>
		<td width="50%">PHP版本: <?php echo $php_ver; ?></td>
	</tr>
	 <tr>
		<td width="50%">MySQL数据库: <?php echo $mysql_ver; ?></td>
		<td width="50%">服务器时间: <?php echo $serverdate; ?></td>
	</tr>
	<tr>
		<td width="50%">GD图形处理库: <?php echo $gd_ver; ?></td>
		<td><a href="configure.php?action=phpinfo">[phpinfo]</a></td>
	</tr>
</table>
<div class=line2></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
	<tr>
		<td width="50%">官方主页: <a href="http://www.emlog.net" target="_blank">www.emlog.net</a></font></td>
		<td width="50%">电子邮件: <a href="mailto:emloog@gmail.com">emloog@gmail.com</a></td>
	</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>