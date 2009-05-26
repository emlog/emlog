    <div class="recent-posts">
    <?php
    	$topquery = $DB->query("SELECT * FROM ".DB_PREFIX."blog WHERE hide='n' ORDER BY date DESC  LIMIT 5");
		while($toplogs = $DB->fetch_array($topquery)):
			$toplogs['post_time'] = date('Y-n-j G:i l',$toplogs['date']);
			$toplogs['title'] = htmlspecialchars(trim($toplogs['title']));
	?>
    <ul>
    <li><a href="<?php echo BLOG_URL; ?>?post=<?php echo $toplogs['gid']; ?>"><?php echo $toplogs['title']; ?><br />
    <span class="listMeta"><?php echo $toplogs['post_time']; ?></span></a></li>
    </ul>
    <?php endwhile;?>
    </div>
    <div class="postit-bottom"></div>

<div class="side-meta">
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
	<li><span onclick="showhidediv('admin')"><b>登录</b></span></li>
	<div id="admin">
	<ul>
		<li><a href="<?php echo BLOG_URL; ?>">首页</a></li>
		<?php foreach ($navibar as $key => $val):
		if ($val['hide'] == 'y'){continue;}
		if (empty($val['url'])){$val['url'] = BLOG_URL.'?post='.$key;}
		?>
		<li><a href="<?php echo $val['url']; ?>" target="<?php echo $val['is_blank']; ?>"><?php echo $val['title']; ?></a></li>
		<?php endforeach;?>
		<?php doAction('navbar', '<li>', '</li>'); ?>
		<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
		<li><a href="<?php echo BLOG_URL; ?>admin/write_log.php">写日志</a></li>
		<li><a href="<?php echo BLOG_URL; ?>admin/">管理中心</a></li>
		<li><a href="<?php echo BLOG_URL; ?>admin/?action=logout">退出</a></li>
		<?php else: ?>
		<li><a href="<?php echo BLOG_URL; ?>admin/">登录</a></li>
		<?php endif; ?>
	</ul>
	</div>
</ul>
</div>