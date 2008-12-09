<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>

<div class="sidebar">
<ul>
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
</ul>
</div>

<div class="sidebar">
<ul>
<?php 
$widgets = !empty($options_cache['widgets2']) ? unserialize($options_cache['widgets2']) : array();
$i = 0;
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_title = @unserialize($options_cache['custom_title2']);
	$custom_content = @unserialize($options_cache['custom_content2']);
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
<?php if(ISLOGIN === false):?> 
<li class="random"><h2><a href="./admin/index.php">登录</a></h2>
<?php else:?>
<li class="random"><h2 onclick="showhidediv('loginfm')" >管理</h2>
<ul id="loginfm">
	<li><a href="./admin/add_log.php">写日志</a></li>
	<li><a href="./admin/">管理中心</a></li>
	<li><a href="./admin/index.php?action=logout">退出</a></li>
</ul>
<?php endif; ?>
</ul>
</div>