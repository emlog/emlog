<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
</DIV>
<DIV id=sidebar>
<UL>
<?php 
require_once (getViews('function'));
$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
$i = 0;
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_title = @unserialize($options_cache['custom_title1']);
	$custom_content = @unserialize($options_cache['custom_content1']);
	$callback = 'widget_'.$val;
	if($val == 'custom_text')
	{
		if(function_exists($callback))
		{
			call_user_func($callback, $custom_title[$i], $custom_content[$i], $i);
		}
		$i++;
	}else{
		if(function_exists($callback))
		{
			preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
			$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
			call_user_func($callback, $wgTitle);
		}
	}
}
?>

	<H2 onClick="showhidediv('admin')">登录</H2>
	<ul id="admin">
	<?php if(ISLOGIN): ?>
		<li><a href="./admin/add_log.php">写日志</a></li>
		<li><a href="./admin/">管理中心</a></li>
		<li><a href="./admin/index.php?action=logout">退出</a></li>
	<?php else: ?>
		<li><a href="./admin/index.php">登录</a></li>
	<?php endif; ?>	
	</ul>
</UL></DIV>
<HR>

<DIV id=footer>powered by 
<a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a><br />
&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp;?></a></P>
</DIV>
</DIV>
</BODY>
</HTML>