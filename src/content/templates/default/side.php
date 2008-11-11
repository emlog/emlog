<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div id="page">
<div class="contentA">
<?php 
require_once (getViews('function'));
$widgets = unserialize($options_cache['sidebar']);
foreach ($widgets as $val)
{
	$callback = 'widget_'.$val;
	if(function_exists($callback))
	{
		call_user_func($callback);
	}
}
?>
<div class="lister">
<a href="./rss.php"><img src="<?php echo $em_tpldir; ?>images/rss.gif" alt="订阅Rss"/></a>
</div>
</div>
<div id="contentB">