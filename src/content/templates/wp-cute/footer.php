<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
</DIV>
<DIV id=sidebar>
<UL>
<?php 
$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_widget = @unserialize($options_cache['custom_widget']);
	if(strpos($val, 'custom_wg_') === 0)
	{
		$callback = 'widget_custom_text';
		if(function_exists($callback))
		{
			call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content'], $val);
		}
	}else{
		$callback = 'widget_'.$val;
		if(function_exists($callback))
		{
			preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
			$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
			call_user_func($callback, htmlspecialchars($wgTitle));
		}
	}
}
?>
<H2 onClick="showhidediv('admin')">META</H2>
<ul id="admin">
	<li><a href="./">首页</a></li>
	<?php foreach ($navibar as $key => $val):
	if ($val['hide'] == 'y'){continue;}
	if (empty($val['url'])){$val['url'] = './?post='.$key;}
	?>
	<li><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
	<?php endforeach;?>
	<?php doAction('navbar', '<li>', '</li>'); ?>
	<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
	<li><a href="./admin/write_log.php">写日志</a></li>
	<li><a href="./admin/">管理中心</a></li>
	<li><a href="./admin/?action=logout">退出</a></li>
	<?php else: ?>
	<li><a href="./admin/">登录</a></li>
	<?php endif; ?>
</ul>
</DIV>
<HR>

<DIV id=footer>Powered by 
<a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a><br />
&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a>
<?php doAction('index_footer'); ?></P>
</DIV>
</DIV>
</BODY>
</HTML>