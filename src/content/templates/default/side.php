<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>



						<div id="sidebar"> 
				<table width="100%"> 
					<tr> 
						<td align="left" width="158" valign="top" class="td_left" id="sidebar_1"> 
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
?></ul>
						</td> 
						<td align="left" valign="top" class="td_right" id="sidebar_2"> 
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
							</ul> 
						</td> 
					</tr> 
				</table> 
	</div> 
				</div> 
			</td> 
		</tr> 
	</table> 
	<div id="blog_end"> 
	</div> 