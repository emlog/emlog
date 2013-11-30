<?php 
/*
* 侧边栏
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div id="sidebar">
	<ul id="sidebar_list">
<?php if($curpage == CURPAGE_HOME || $curpage == CURPAGE_TW || (isset($type) && $type == 'page')): ?>
	<li>
	<h2>广告</h2>
	<ul>
	<li>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-9763798751971937";
/* qiyuuu */
google_ad_slot = "2259689281";
google_ad_width = 250;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
	</li>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php endif; ?>
<?php 
$widgets = !empty($options_cache['widgets1']) ? unserialize($options_cache['widgets1']) : array();
doAction('diff_side');
foreach ($widgets as $val)
{
	$widget_title = @unserialize($options_cache['widget_title']);
	$custom_widget = @unserialize($options_cache['custom_widget']);
	if(strpos($val, 'custom_wg_') === 0)
	{
		$callback = 'widget_custom_text';
		if(function_exists($callback))
		{
			call_user_func($callback, htmlspecialchars($custom_widget[$val]['title']), $custom_widget[$val]['content']);
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
		<li>
            <h2>Feeds(RSS)</h2>
            <ul>
               	<li><a href="<?php echo BLOG_URL; ?>rss.php" title="订阅 <?php echo $blogname; ?>"><img src="<?php echo TEMPLATE_URL; ?>images/rss-blue.png" alt="订阅 <?php echo $blogname; ?>" /></a></li>
            </ul>
        </li>
    	<div class="sidebar_foot"></div>
    </ul>
</div>