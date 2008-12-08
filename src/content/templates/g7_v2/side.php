<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="sidebar">
<div id="search">
<form name="keyform" method="get" action="index.php">
<div>
<input type="text" name="keyword" id="s" value="输入搜索" onfocus="this.value=''" onblur="this.value='输入搜索';this.style.color='#CCCCCC';" />
<input type="submit" id="go" value="" onclick="return keyw()"/>
</div>
</form>
</div>
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
<a href="./rss.php"><img src="<?php echo $em_tpldir; ?>images/rss.gif" alt="订阅Rss"/></a>
</div>
