<?php 
if(!defined('ADMIN_ROOT')) {exit('error!');}
$allcom = $hidecom + $comnum;
?>
<div id="admindex">
<div id="admindex_main">
我有<span class=care2><b><?php echo $lognum; ?></b></span>篇日志，<span class=care2><b><?php echo $tbnum; ?></b></span>条引用通告，<span class=care2><b><?php echo $allcom; ?></b></span>条评论<?php if($ischkcomment == 'y' || $hidecom != 0): ?>，其中有<b><a href="./comment.php?hide=y"><?php echo $hidecom; ?></a></b>条评论等待审核<?php endif; ?>。
</div>
<div id="admindex_servinfo">
<h3>服务器信息</h3>
<ul>
	<li>服务器环境: <?php echo $serverapp; ?></li>
	<li>PHP版本: <?php echo $php_ver; ?></li>
	<li>MySQL数据库: <?php echo $mysql_ver; ?></li>
	<li>服务器时间: <?php echo $serverdate; ?></li>
	<li>GD图形处理库: <?php echo $gd_ver; ?></li>
	<li><a href="configure.php?action=phpinfo">[phpinfo]</a></li>
</ul>
</div>
<div id="admindex_msg">
<h3>官方信息</h3>
<ul>
	<li>服务器环境: <?php echo $serverapp; ?></li>
	<li>PHP版本: <?php echo $php_ver; ?></li>
	<li>MySQL数据库: <?php echo $mysql_ver; ?></li>
	<li>服务器时间: <?php echo $serverdate; ?></li>
	<li>GD图形处理库: <?php echo $gd_ver; ?></li>
	<li><a href="configure.php?action=phpinfo">[phpinfo]</a></li>
</ul>
</div>
</div>