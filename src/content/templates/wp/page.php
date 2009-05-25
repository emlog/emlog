<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<div class=post id=post-1>
<h2>
<b><?php echo $log_title;?></b>
</h2>
<div class="entry">
<p><?php echo $log_content;?></p>
<p><?php blog_att($logid); ?></p>
</div></div>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>

<?php include getViews('footer'); ?>