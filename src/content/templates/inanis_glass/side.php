<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
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
<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="sidebar-mid">
    	<p style="text-align:center;">
    	Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a><br />
    	<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a>
    	</p>
        <p style="text-align:center;">
    	<a href="http://www.inanis.net/"><img src="<?php echo CERTEMPLATE_URL; ?>/images/ilogo_32.png" alt="" /></a>
        </p>
  </div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
</div>
<hr class="rule" />