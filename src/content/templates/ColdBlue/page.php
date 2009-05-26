<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="post" id="post-1">
<div class="post-title">
	<h2><?php echo $log_title;?></h2>
</div>
<div class="post-content">
	<?php echo $log_content; ?>
</div>
	<p><?php blog_att($logid); ?></p>
	<?php 
	if ($allow_remark == 'y'){
		blog_comments();
		blog_comments_post();
	}
	?>
	</div>	
	</div>
	<ul id="sidebar">
<?php
include getViews('side');
include getViews('footer'); 
?>