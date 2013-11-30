<?php 
/*
* 首页日志列表部分
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php
$isHome = 0;
if(isset($sortName)){
?>
<div class="header single">
	<div class="container">
		<h2>分类：<?php echo $sortName; ?></h2>
	</div>
</div>
<?php
}elseif(isset($tag)){
?>
<div class="header single">
	<div class="container">
		<h2>标签：<?php echo $tag; ?></h2>
	</div>
</div>
<?php
}elseif(isset($author)){
?>
<div class="header single">
	<div class="container">
		<h2>作者：<?php echo $author_name; ?></h2>
	</div>
</div>
<?php
}elseif(isset($record)){
?>
<div class="header single">
	<div class="container">
		<h2>归档：<?php echo $record; ?></h2>
	</div>
</div>
<?php
}elseif(isset($keyword)){
?>
<div class="header single">
	<div class="container">
		<h2>搜索：<?php echo $keyword; ?></h2>
	</div>
</div>
<?php
}elseif(isset($page) && $page > 1){
?>
<div class="header single">
	<div class="container">
		<h2><?php echo $blogname; ?></h2>
	</div>
</div>
<?php
}else{
	$isHome = 1;
?>
<div class="header">
	<?php
		$date = time() - 3600 * 24 * 60;
		$Log_Model = new Log_Model();
		$id1 = $logs[0]['gid'];
		$id2 = $logs[1]['gid'];
		$hotlogs = $Log_Model->getLogsForHome("AND date > {$date} AND gid!=$id1 AND gid!=$id2 ORDER BY comnum DESC,date DESC", 1, 7);
	?>
	<div class="container">
		<div class="header-left">
			<div class="content-list nonce">
				<h4><a href="<?php echo $logs[0]['log_url']; ?>"><?php echo $logs[0]['title']; ?></a></h4>
				<div class="log-meta"><?php echo gmdate('Y-n-j G:i l', $logs[0]['date']); ?> <?php blog_sort($logs[0]['gid']); ?> <a href="<?php echo $logs[0]['log_url']; ?>#comments">评论(<?php echo $logs[0]['comnum']; ?>)</a> <a href="<?php echo $logs[0]['log_url']; ?>">阅读(<?php echo $logs[0]['views']; ?>)</a></div>
				<div class="log-content"><?php echo $logs[0]['content']; ?></div>
			</div>
			<div class="content-list">
				<h4><a href="<?php echo $logs[1]['log_url']; ?>"><?php echo $logs[1]['title']; ?></a></h4>
				<div class="log-meta"><?php echo gmdate('Y-n-j G:i l', $logs[1]['date']); ?> <?php blog_sort($logs[1]['gid']); ?> <a href="<?php echo $logs[1]['log_url']; ?>#comments">评论(<?php echo $logs[1]['comnum']; ?>)</a> <a href="<?php echo $logs[1]['log_url']; ?>">阅读(<?php echo $logs[1]['views']; ?>)</a></div>
				<div class="log-content"><?php echo $logs[1]['content']; ?></div>
			</div>
			<?php foreach($hotlogs as $key=>$value): ?>
			<div class="content-list">
				<h4><a href="<?php echo $value['log_url']; ?>"><?php echo $value['title']; ?></a></h4>
				<div class="log-meta"><?php echo gmdate('Y-n-j G:i l', $value['date']); ?> <?php blog_sort($value['gid']); ?> <a href="<?php echo $value['log_url']; ?>#comments">评论(<?php echo $value['comnum']; ?>)</a> <a href="<?php echo $value['log_url']; ?>">阅读(<?php echo $value['views']; ?>)</a></div>
				<div class="log-content"><?php echo $value['content']; ?></div>
			</div>
			<?php endforeach;?>
		</div>
		<div class="header-right">
			<div class="title-list">
				<ul>
					<li>
						<span class="rank"><?php echo $logs[0]['top'] == 'y' ? 'Top' : 'New'; ?></span>
						<span class="title"><a href="<?php echo Url::log($logs[0]['gid']); ?>"><?php echo $logs[0]['title']; ?></a></span>
					</li>
					<li>
						<span class="rank"><?php echo $logs[1]['top'] == 'y' ? 'Top' : 'New'; ?></span>
						<span class="title"><a href="<?php echo Url::log($logs[1]['gid']); ?>"><?php echo $logs[1]['title']; ?></a></span>
					</li>
					<?php foreach($hotlogs as $key=>$value): ?>
					<li>
						<span class="rank"><?php echo $key + 1; ?></span>
						<span class="title"><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></span>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php }?>
<div class="main<?php if($isHome) echo ' home'; ?>">
	<div class="mini-logs">
		<?php
			foreach($logs as $key=>$value):
			preg_match_all("|<img[^>]+src=\"([^>\"]+)\"?[^>]*>|is", $value['content'], $img);
			$imgsrc = !empty($img[1]) ? $img[1][0] : TEMPLATE_URL . 'images/log-thumb.jpg';
		?>
		<div class="mini-content">
			<div class="thumb" style="background:url('<?php echo $imgsrc; ?>') center top transparent;"></div>
			<div class="desc">
				<p><b><?php echo $value['log_title']; ?></b></p>
				<?php echo strip_tags($value['log_description'],"<p>,<img>"); ?>
			</div>
			<div class="title"><a href="<?php echo $value['log_url']; ?>" title="<?php echo $value['title']; ?>"><?php echo $value['title']; ?></a></div>
		</div>
		<?php if($key % 4 == 3): ?><div class="clear"></div><?php endif; ?>
		<?php endforeach; ?>
		<div class="pagenavi"><?php if($page_url): ?>Page <?php echo $page; ?> of <?php echo ceil($lognum/$index_lognum); ?> <?php endif; ?><?php echo $page_url; ?></div>
	</div>
	<div class="clear"></div>
	<?php include View::getView('widgets'); ?>
</div>
<?php include View::getView('footer'); ?>