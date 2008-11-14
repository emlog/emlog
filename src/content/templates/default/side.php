<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="page">
<div class="contentA">
<?php 
require_once (getViews('function'));
$widgets = unserialize($options_cache['widgets']);
$i = 0;
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_title = @unserialize($options_cache['custom_title']);
	$custom_content = @unserialize($options_cache['custom_content']);
	$callback = 'widget_'.$val;
	if($val == 'custom_text')
	{
		if(function_exists($callback))
		{
			call_user_func($callback, $custom_title[$i], $custom_content[$i]);
		}
		$i++;
	}else{
		if(function_exists($callback))
		{
			call_user_func($callback, $widget_title[$val]);
		}
	}
}
?>
<div class="lister">
<a href="./rss.php"><img src="<?php echo $em_tpldir; ?>images/rss.gif" alt="订阅Rss"/></a>
</div>
</div>
<div id="contentB">