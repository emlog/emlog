<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="content">
<?php foreach($logs as $value):  ?>
	<div class="post" id="post-<?php echo $value['logid']; ?>">
		<h1>
		<?php echo $topFlg; ?><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>"><?php echo $value['log_title']; ?></a>
		<?php blog_sort($value['sortid'], $value['logid']); ?>
		</h1>
		<div class="post_p"><?php echo $value['log_description']; ?></div>
			<p><?php blog_att($value['logid']); ?></p>
			<p><?php blog_tag($value['logid']); ?></p>
			<div class="post-info">
			<?php echo date('Y-n-j G:i l', $value['date']); ?> | 
			<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>
			<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a> 
			<a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
		</div>
	</div>
<?php endforeach; ?>
<div id="pages">
	<?php echo $page_url;?>
</div>
</div>
<?php include getViews('side'); ?>
<?php include getViews('foot'); ?>