<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
//$photo = getAttachment($photo ,600,500);
?>		
<div class="obar">
<ul>
<?php
require_once (getViews('function'));
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
<p><a href="./rss.php"><img src="<?php echo $em_tpldir; ?>images/rss.gif" alt="订阅Rss"/></a></p>	
</ul>
</div>