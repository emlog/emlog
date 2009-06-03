<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="sidebar_tag">
<?php foreach($tag_cache as $value): ?>
<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="./?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
<?php endforeach; ?>
</div>

<div id="sidebar">
<div id="sidebar_1">
<ul>
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
</ul>
</div>

<div id="sidebar_2">
<ul>
<?php 
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

<li class="random"><h2 onclick="showhidediv('loginfm')" >Meta</h2>
<ul>
<?php foreach ($navibar as $key => $val):
if ($val['hide'] == 'y'){continue;}
if (empty($val['url'])){$val['url'] = './?post='.$key;}
?>
	<li><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
<?php endforeach;?>
<?php doAction('navbar', '<li class="menus2">', '</li>'); ?>
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
	<li><a href="./admin/write_log.php">写日志</a></li>
	<li><a href="./admin/">管理中心</a></li>
	<li><a href="./admin/?action=logout">退出</a></li>
<?php else: ?>
	<li><a href="./admin/">登录</a></li>
<?php endif; ?>
</ul>


<p><a href="<?php echo BLOG_URL; ?>rss.php"><img src="<?php echo CERTEMPLATE_URL; ?>/images/rss.png" alt="订阅Rss"/></a></p>
</ul>
</div>

</div> 
</div> 
</ul>
</div>			
