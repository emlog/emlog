<div id="sidebar">
	<div id="sbarheader">
	<div class="ti"><h1><a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a></h1></div>
			<div class="des"><?php echo $bloginfo; ?></div>
	<div class="rsssubscribe">
	<a href="<?php echo BLOG_URL; ?>rss.php">
	<img style="vertical-align:middle" border="0" src="<?php echo CERTEMPLATE_URL; ?>/images/rss.gif" alt="Subscribe to <?php echo $blogname; ?>" /><br/>
	Subscribe via RSS</a>
	</div>
	</div>
	<div id="nav">
		<ul>
			<li><a href="<?php echo BLOG_URL; ?>">首页</a></li>
			<li><a href="http://www.emlog.net" target="_blank">emlog</a></li>
			<?php if(ISLOGIN): ?>
			<li><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
			<li><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
			<li><a href="<?php echo BLOG_URL; ?>admin/index.php?action=logout">退出</a></li>
			<?php else: ?>
			<li><a href="<?php echo BLOG_URL; ?>admin/index.php">登录</a></li>
			<?php endif; ?>
		</ul>
	</div>
	<div id="sbarsearch">
	<form method="get" id="searchform" action="<?php echo BLOG_URL; ?>index.php">
	<input value="" type="text" name="keyword" class="s" />
	<input type="submit" class="sub" value="search" onclick="return keyw()"/>
	</form>
	</div>
<div class="sbarright">
<ul>
<?php 
require_once (getViews('function'));
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
</ul>
</div>
<div class="sbarleft">
<ul>
<?php 
require_once (getViews('function'));
$widgets = !empty($options_cache['widgets2']) ? unserialize($options_cache['widgets2']) : array();
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
</ul>
</div>
</div>
