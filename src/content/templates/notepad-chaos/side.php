    <div class="recent-posts">
    <?php
    	$topquery = $DB->query("SELECT * FROM ".DB_PREFIX."blog WHERE hide='n' ORDER BY date DESC  LIMIT 5");
		while($toplogs = $DB->fetch_array($topquery)):
			$toplogs['post_time'] = date('Y-n-j G:i l',$toplogs['date']);
			$toplogs['title'] = htmlspecialchars(trim($toplogs['title']));
	?>
    <ul>
    <li><a href="./?action=showlog&gid=<?php echo $toplogs['gid']; ?>"><?php echo $toplogs['title']; ?><br />
    <span class="listMeta"><?php echo $toplogs['post_time']; ?></span></a></li>
    </ul>
    <?php endwhile;?>
    </div>
    <div class="postit-bottom"></div>

<div class="side-meta">
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
	<li><span onclick="showhidediv('admin')"><b>登录</b></span></li>
	<div id="admin">
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
</ul>
</div>