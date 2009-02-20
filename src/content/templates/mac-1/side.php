<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="dbx-group" id="sidebar">
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
			call_user_func($callback, $custom_widget[$val]['title'], $custom_widget[$val]['content'], $val);
		}
	}else{
		$callback = 'widget_'.$val;
		if(function_exists($callback))
		{
			preg_match("/^.*\s\((.*)\)/", $widget_title[$val], $matchs);
			$wgTitle = isset($matchs[1]) ? $matchs[1] : $widget_title[$val];
			call_user_func($callback, $wgTitle);
		}
	}
}
?>
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('admin')">管理</h3>
        <div class="dbx-content" id="admin">
          <ul>
            <?php if(ISLOGIN): ?>
			<li><a href="./admin/write_log.php">写日志</a></li>
			<li><a href="./admin/">管理中心</a></li>
			<li><a href="./admin/index.php?action=logout">退出</a></li>
			<?php else: ?>
				<li><a href="./admin/index.php">登录</a></li>
			<?php endif; ?>
          </ul>
        </div>
      </div>
</div>
</body>
</html>
